<?php


	get_template_part('inc/maester', 'breadcrumbs');



	/**
	 * Enqueue scripts and styles.
	 */
	if(!function_exists('maester_scripts')){
	    function maester_scripts() {

	        // Default Included files
	        wp_enqueue_style( 'maester-style', get_stylesheet_uri() );
	        wp_enqueue_script( 'maester-navigation', MAESTER_JS . '/navigation.js', array(), '20151215', true );
	        wp_enqueue_script( 'maester-skip-link-focus-fix', MAESTER_JS . '/skip-link-focus-fix.js', array(), '20151215', true );
	        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	            wp_enqueue_script( 'comment-reply' );
	        }

	        // Maester Styles
	        wp_enqueue_style('maester-nice-select', MAESTER_CSS.'/nice-select.min.css', array(), '1.0.0');
	        wp_enqueue_style('maester-bootstrap', MAESTER_CSS.'/bootstrap-grid.min.css', array(), '4.3.1');
	        wp_enqueue_style('maester-main-css', MAESTER_CSS. '/main.min.css', array(), '1.0.0');
	        wp_enqueue_style('maester-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,600i,700,700i', array());
	        wp_enqueue_style('maester-fontawesome', MAESTER_CSS.'/fontawesome.min.css', array(), '5.9.0');

	        //Maester JS
	        wp_enqueue_script( 'maester-main-js', MAESTER_JS . '/main.js', array('jquery'), '1.0.0', true );
	        wp_enqueue_script( 'maester-nice-select-js', MAESTER_JS . '/jquery.nice-select.min.js', array('jquery'), '1.0.0', true );

	    }
	    add_action( 'wp_enqueue_scripts', 'maester_scripts' );
	}

	if(!function_exists('maester_admin_scripts')){
		function maester_admin_scripts(){
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'maester-admin-js', MAESTER_JS . '/main.admin.js', array('jquery', 'wp-color-picker'), '1.0.0', true );
			wp_enqueue_style('maester-main-css', MAESTER_CSS. '/main.admin.css', array(), '1.0.0');
		}
		add_action('admin_enqueue_scripts', 'maester_admin_scripts');
	}


	/**
	 * Register widget area.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	function maester_widgets_init() {
	    register_sidebar( array(
	        'name'          => esc_html__( 'Sidebar', 'maester-lite' ),
	        'id'            => 'sidebar-1',
	        'description'   => esc_html__( 'Add widgets here.', 'maester-lite' ),
	        'before_widget' => '<section id="%1$s" class="widget %2$s">',
	        'after_widget'  => '</section>',
	        'before_title'  => '<h4 class="widget-title">',
	        'after_title'   => '</h4>',
	    ) );
	    register_sidebar( array(
	        'name'          => esc_html__( 'Footer Widget 1', 'maester-lite' ),
	        'id'            => 'footer-1',
	        'description'   => esc_html__( 'Add widgets here.', 'maester-lite' ),
	        'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
	        'after_widget'  => '</section>',
	        'before_title'  => '<h4 class="widget-title">',
	        'after_title'   => '</h4>',
	    ) );
	    register_sidebar( array(
	        'name'          => esc_html__( 'Footer Widget 2', 'maester-lite' ),
	        'id'            => 'footer-2',
	        'description'   => esc_html__( 'Add widgets here.', 'maester-lite' ),
	        'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
	        'after_widget'  => '</section>',
	        'before_title'  => '<h4 class="widget-title">',
	        'after_title'   => '</h4>',
	    ) );
	    register_sidebar( array(
	        'name'          => esc_html__( 'Footer Widget 3', 'maester-lite' ),
	        'id'            => 'footer-3',
	        'description'   => esc_html__( 'Add widgets here.', 'maester-lite' ),
	        'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
	        'after_widget'  => '</section>',
	        'before_title'  => '<h4 class="widget-title">',
	        'after_title'   => '</h4>',
	    ) );
	    register_sidebar( array(
	        'name'          => esc_html__( 'Footer Widget 4', 'maester-lite' ),
	        'id'            => 'footer-4',
	        'description'   => esc_html__( 'Add widgets here.', 'maester-lite' ),
	        'before_widget' => '<section id="%1$s" class="widget footer-widget %2$s">',
	        'after_widget'  => '</section>',
	        'before_title'  => '<h4 class="widget-title">',
	        'after_title'   => '</h4>',
	    ) );
	}
	add_action( 'widgets_init', 'maester_widgets_init' );


	/**
	 * Include the TGM Plugin Activation class
	 */
	add_action( 'tgmpa_register', 'maester_plugins_include');

	if(!function_exists('maester_plugins_include')){
	    function maester_plugins_include() {
	        $plugins = apply_filters('maester_plugin_include', array(
		        array(
			        'name'                  => esc_html__( 'Elementor', 'maester-lite' ),
			        'slug'                  => 'elementor',
			        'required'              => false,
			        'version'               => '',
			        'force_activation'      => false,
			        'force_deactivation'    => false
		        ),
		        array(
			        'name'                  => esc_html__( 'Tutor LMS', 'maester-lite' ),
			        'slug'                  => 'tutor',
			        'required'              => false,
			        'version'               => '',
			        'force_activation'      => false,
			        'force_deactivation'    => false
		        ),
		        array(
			        'name'                  => esc_html__( 'Kirki Toolkit', 'maester-lite' ),
			        'slug'                  => 'kirki',
			        'required'              => false,
			        'version'               => '',
			        'force_activation'      => false,
			        'force_deactivation'    => false
		        ),
		        array(
			        'name'                  => esc_html__( 'Maester Toolkit', 'maester-lite' ),
			        'slug'                  => 'maester-toolkit',
			        'required'              => false,
			        'version'               => '',
			        'force_activation'      => false,
			        'force_deactivation'    => false
		        )
	        ));
	        $config = array(
	            'domain'            => 'maester-lite',
	            'default_path'      => '',
	            'parent_slug'  => 'themes.php',
	            'capability'  => 'manage_options',
	            'menu'              => 'install-required-plugins',
	            'has_notices'       => true,
	            'is_automatic'      => false,
	            'message'           => '',
	            'strings'           => array(
	                'page_title'                                => esc_html__( 'Install Required Plugins', 'maester-lite' ),
	                'menu_title'                                => esc_html__( 'Install Plugins', 'maester-lite' ),
		            /* translators: %s: plugin name */
	                'installing'                                => esc_html__( 'Installing Plugin: %s', 'maester-lite' ),
	                'oops'                                      => esc_html__( 'Something went wrong with the plugin API.', 'maester-lite'),
	                'return'                                    => esc_html__( 'Return to Required Plugins Installer', 'maester-lite'),
	                'plugin_activated'                          => esc_html__( 'Plugin activated successfully.','maester-lite'),
		            /* translators: %s: plugin name */
	                'complete'                                  => esc_html__( 'All plugins installed and activated successfully. %s', 'maester-lite' )
	            )
	        );

	        tgmpa( $plugins, $config );

	    }

	}