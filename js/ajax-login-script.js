
/**
 * Ajax Login Script - Since: 1.0.0
 * @param $
 */
function ajaxLogin($){
    var $loginForm = $('form#login');
    $loginForm.on('submit', function(e){
        e.preventDefault();
        var status = $loginForm.find('p.status'),
            username = $loginForm.find('#username').val(),
            password = $loginForm.find('#password').val(),
            rememberme = $loginForm.find('#rememberme').val(),
            security = $loginForm.find('#security').val()

        status.show().text(ajax_login_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': username,
                'password': password,
                'rememberme': rememberme,
                'security': security
            },
            success: function(data){
                $loginForm.find('p.status').text(data.message);
                if (data.loggedin == true){
                    document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
    });
}

/**
 * Ajax Registration Script - Since: 1.0.0
 * @param $
 */

function ajaxRegistration($){
    var $regForm = $('form#registration');
    $regForm.on('submit', function(e){
        e.preventDefault();

        var username = $regForm.find('#reg-username').val(),
            email = $regForm.find('#email').val(),
            password = $regForm.find('#reg-password').val(),
            security = $regForm.find('#reg-security').val(),
            status = $regForm.find('p.status');

        if(validateEmail(email)){
            status.show().text(ajax_login_object.loadingmessage);
        }else{
            status.show().text(ajax_login_object.email_valid);
            return;
        }

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'ajaxregister', //calls wp_ajax_nopriv_ajaxlogin
                'username': username,
                'email': email,
                'password': password,
                'security': security
            },
            success: function(data){
                $regForm.find('p.status').text(data.message);
                if (data.loggedin == true){
                    document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
    });
}

/**
 * Forget Password Script - Since 1.0.0
 * @param $
 */
function ajaxForgetPass($) {
    var $lostForm = $('form#lostpass');
    $lostForm.on('submit', function(e){
        e.preventDefault();
        var status = $lostForm.find('p.status'),
            email = $lostForm.find('#forget-email').val(),
            security = $lostForm.find('#forget-security').val();

        if(validateEmail(email)){
            status.show().text(ajax_login_object.loadingmessage);
        }else{
            status.show().text(ajax_login_object.email_valid);
            return;
        }

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'ajaxlostpass', //calls wp_ajax_nopriv_ajaxlogin
                'email': email,
                'security': security
            },
            success: function(data){
                $lostForm.find('p.status').text(data.message);
                if (data.loggedin == true){
                    document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
    });
}

/**
 * Email Validation - Since 1.0.0
 * @param email
 * @returns {boolean}
 */
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

jQuery(document).ready(function ($) {
    ajaxLogin($);
    ajaxRegistration($);
    ajaxForgetPass($);
});
