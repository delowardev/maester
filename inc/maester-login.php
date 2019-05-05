<?php



/**
 * Ajax Login
 */


// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}

function ajax_login_init(){
    global $wp;
    wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array('jquery') );
    wp_enqueue_script('ajax-login-script');
    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url($wp->request),
        'loadingmessage' => __('Sending user info, please wait...', 'maester'),
        'email_valid'   => __('Email address is not valid!', 'maester')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
    add_action( 'wp_ajax_nopriv_ajaxregister', 'ajax_register' );
    add_action( 'wp_ajax_nopriv_ajaxlostpass', 'ajax_lostpass' );
}

/**
 * Ajax Lost Password
 */
function ajax_lostpass(){
    check_ajax_referer( 'ajax-forget-nonce', 'security' );

    global $wpdb;

    $account = $_POST['email'];

    if( empty( $account ) ) {
        $error = __('Enter an username or e-mail address.', 'maester');
    } else {
        if(is_email( $account )) {
            if( email_exists($account) )
                $get_by = 'email';
            else
                $error = __('There is no user registered with that email address.', 'maester');
        }
        else if (validate_username( $account )) {
            if( username_exists($account) )
                $get_by = 'login';
            else
                $error = __('There is no user registered with that username.', 'maester');
        }
        else
            $error = __('Invalid username or e-mail address.', 'maester');
    }

    if(empty ($error)) {
        // lets generate our new password
        //$random_password = wp_generate_password( 12, false );
        $random_password = wp_generate_password();


        // Get user data by field and data, fields are id, slug, email and login
        $user = get_user_by( $get_by, $account );

        $update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );

        // if  update user return true then lets send user an email containing the new password
        if( $update_user ) {

            $from = 'WRITE SENDER EMAIL ADDRESS HERE'; // Set whatever you want like mail@yourdomain.com

            if(!(isset($from) && is_email($from))) {
                $sitename = strtolower( $_SERVER['SERVER_NAME'] );
                if ( substr( $sitename, 0, 4 ) == 'www.' ) {
                    $sitename = substr( $sitename, 4 );
                }
                $from = 'admin@'.$sitename;
            }

            $to = $user->user_email;
            $subject = 'Your new password';
            $sender = 'From: '.get_option('name').' <'.$from.'>' . "\r\n";

            $message = 'Your new password is: '.$random_password;

            $headers[] = 'MIME-Version: 1.0' . "\r\n";
            $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers[] = "X-Mailer: PHP \r\n";
            $headers[] = $sender;

            $mail = wp_mail( $to, $subject, $message, $headers );
            if( $mail )
                $success = __('Check your email address for you new password.', 'maester');
            else
                $error = __('System is unable to send you mail containg your new password.', 'maester');
        } else {
            $error = __('Oops! Something went wrong while updaing your account.', 'maester');
        }
    }

    if( ! empty( $error ) )
        echo json_encode(array('loggedin'=>false, 'message'=>$error));

    if( ! empty( $success ) )
        echo json_encode(array('loggedin'=>false, 'message'=> $success));

    die();
}

/**
 * Ajax Login
 */
function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = $_POST['rememberme'];

    auth_user_login($info['user_login'], $info['user_password'], 'Login');
}

/**
 * Ajax User Register
 */

function ajax_register(){
    check_ajax_referer( 'ajax-registration-nonce', 'security' );
    $info = array();
    $info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']);
    $info['user_pass'] = sanitize_text_field($_POST['password']);
    $info['user_email'] = sanitize_email( $_POST['email']);
    $user_register = wp_insert_user( $info );
    if (is_wp_error($user_register)){
        $error = $user_register->get_error_codes();
        if(in_array('empty_user_login', $error))
            echo json_encode(array('loggedin'=>false, 'message'=>$user_register->get_error_message('empty_user_login')));
        elseif(in_array('existing_user_login',$error))
            echo json_encode(array('loggedin'=>false, 'message'=>__('This username is already registered.', 'maester')));
        elseif(in_array('existing_user_email',$error))
            echo json_encode(array('loggedin'=>false, 'message'=>__('This email address is already registered.', 'maester')));
    } else {
        auth_user_login($info['nickname'], $info['user_pass'], 'Registration');
    }

    die();
}

/**
 * Ajax login user auth
 * @param $user_login
 * @param $password
 * @param $login
 */

function auth_user_login($user_login, $password, $login){
    $info = array();
    $info['user_login'] = $user_login;
    $info['user_password'] = $password;
    $info['remember'] = isset($_POST['rememberme']) ? $_POST['rememberme'] : false;

    $user_signon = wp_signon( $info, '' ); // From false to '' since v4.9
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.', 'maester')));
    } else {
        wp_set_current_user($user_signon->ID);
        echo json_encode(array('loggedin'=>true, 'message'=> $login.__(' successful, redirecting...', 'maester')));
    }
    die();
}