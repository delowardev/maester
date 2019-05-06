<?php


if(!function_exists('maester_theme_options')){
    add_action('init', 'maester_theme_options');
    function maester_theme_options () {
        $config_id = 'maester_options';
        if(class_exists('Kirki')){
            Kirki::add_config( $config_id, array(
                'capability'    => 'edit_theme_options',
                'option_type'   => 'theme_mod'
            ));
            Kirki::add_panel( 'maester_options_panel', array(
                'priority'    => 10,
                'title'       => esc_html__( 'Maester Settings', 'maester' ),
                'description' => esc_html__( 'Maester Theme Customization Options', 'maester' ),
            ));

            /**
             * Top Bar Options
             */

            Kirki::add_section( 'maester_topbar_options', array(
                'title'          => esc_html__( 'Top Bar', 'maester' ),
                'description'    => esc_html__( 'Top Bar Settings.', 'maester' ),
                'panel'          => 'maester_options_panel',
                'priority'       => 160,
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_topbar',
                'label'       => esc_html__( 'Top Bar Enable/Disable', 'maester' ),
                'section'     => 'maester_topbar_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            Kirki::add_field( $config_id, array(
                'type'     => 'text',
                'settings' => 'topbar_text',
                'label'    => esc_html__( 'Header Top Text', 'maester' ),
                'section'  => 'maester_topbar_options',
                'default'  => esc_html__( 'Maester | Multipurpose WordPress LMS Theme with Elementor Page Builder', 'maester' ),
                'priority' => 10,
                'partial_refresh'    => array(
                    'topbar_text' => array(
                        'selector'        => '.top-bar-description',
                        'render_callback' => function() {
                            return ;
                        },
                    )
                ),
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'select',
                'settings'    => 'topbar_custom_links',
                'label'       => esc_html__( 'Menu Custom Links', 'maester' ),
                'section'     => 'maester_topbar_options',
                'default'     => array('login', 'profile', 'logout' ),
                'priority'    => 10,
                'multiple'    => 999,
                'choices'     => array(
                    'search' => esc_html__( 'Search Icon', 'maester' ),
                    'login' => esc_html__( 'Login Link', 'maester' ),
                    'profile' => esc_html__( 'Profile Link', 'maester' ),
                    'logout' => esc_html__( 'Sign Out Link', 'maester' ),
                ),
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'repeater',
                'label'       => esc_html__( 'Top Bar Social Icons', 'maester' ),
                'section'     => 'maester_topbar_options',
                'priority'    => 10,
                'row_label' => array(
                    'type'  => 'text',
                    'value' => esc_html__('Social Icon: ', 'maester' ),
                ),
                'button_label' => esc_html__('Add New Soical Icon', 'maester' ),
                'settings'     => 'topbar_social',
                'default'      => array(),
                'fields' => array(
                    'topbar_social_icon'  => array(
                        'type'        => 'text',
                        'label'       => esc_html__( 'Icon Class Name', 'maester' ),
                        'description' => sprintf('<a target="_blank" href="%s">%s</a> %s <br><span style="color: green">%s</span>', esc_url('https://fontawesome.com/cheatsheet/'), __('Click Here', 'maester'), __('to get icons list', 'maester'), __('Note: Use prefix `fab` for brand, `far` for regular, `fas` for solid icons', 'maester')),
                        'default'     => 'fab fa-facebook',
                    ),
                    'topbar_social_link'  => array(
                        'type'        => 'link',
                        'label'       => esc_html__( 'Icon URL', 'maester' ),
                        'description' => __( 'Example: <span style="color: green;">https://fb.com/your_user_name</span>', 'maester' ),
                        'default'     => '#',
                    ),
                    'topbar_social_link_target' => array(
                        'type'        => 'radio',
                        'label'       => esc_html__( 'Link target', 'maester' ),
                        'default'     => '_self',
                        'priority'    => 10,
                        'choices'     => array(
                            '_blank'   => esc_html__( 'Open in new tab', 'maester' ),
                            '_self' => __( 'Don\'t open in new tab', 'maester' )
                        ),
                    )
                )
            ) );


            /**
             * Header Options
             */

            Kirki::add_section( 'maester_header_options', array(
                'title'          => esc_html__( 'Header & Menu Bar', 'maester' ),
                'description'    => esc_html__( 'Header Settings.', 'maester' ),
                'panel'          => 'maester_options_panel',
                'priority'       => 160,
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_header_search',
                'label'       => esc_html__( 'Header Search Enable/Disable', 'maester' ),
                'section'     => 'maester_header_options',
                'default'     => '1',
                'priority'    => 10,
                'partial_refresh'    => array(
                    'enable_header_search' => array(
                        'selector'        => '.custom-search-form-column',
                        'render_callback' => function() {
                            return get_theme_mod('enable_header_search');
                        },
                    )
                ),
            ));


            Kirki::add_field( $config_id, array(
                'type'        => 'select',
                'settings'    => 'header_search_post_types',
                'label'       => esc_html__( 'Header Search Post Types', 'maester' ),
                'section'     => 'maester_header_options',
                'default'     => 'post',
                'priority'    => 10,
                'multiple'    => 0,
                'choices'     => search_post_types()
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_header_cart',
                'label'       => esc_html__( 'Enable Menubar Cart', 'maester' ),
                'description' => __("NB: WooCommerce must be installed to see the cart icon", 'maester'),
                'section'     => 'maester_header_options',
                'default'     => '1',
                'priority'    => 10,
                'partial_refresh'    => array(
                    'enable_header_cart' => array(
                        'selector'        => '.header-cart-menu',
                        'render_callback' => function() {
                            return get_theme_mod('enable_header_cart');
                        },
                    )
                ),
            ) );


            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_menubar_search_icon',
                'label'       => esc_html__( 'Enable Menubar Search Icon', 'maester' ),
                'section'     => 'maester_header_options',
                'default'     => '1',
                'priority'    => 10,
                'partial_refresh'    => array(
                    'enable_menubar_search_icon' => array(
                        'selector'        => '.menubar-search-icon',
                        'render_callback' => function() {
                            return get_theme_mod('enable_menubar_search_icon');
                        },
                    )
                ),
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_header_login_icon',
                'label'       => esc_html__( 'Enable Menubar Login Icon', 'maester' ),
                'section'     => 'maester_header_options',
                'default'     => '1',
                'priority'    => 10,
                'partial_refresh'    => array(
                    'enable_header_login_icon' => array(
                        'selector'        => '.menubar-login-icon',
                        'render_callback' => function() {
                            return get_theme_mod('enable_header_login_icon');
                        },
                    )
                ),
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'repeater',
                'label'       => esc_html__( 'Menu Bar Social Icons', 'maester' ),
                'section'     => 'maester_header_options',
                'priority'    => 10,
                'row_label' => array(
                    'type'  => 'text',
                    'value' => esc_html__('Social Icon: ', 'maester' ),
                ),
                'button_label' => esc_html__('Add New Soical Icon', 'maester' ),
                'settings'     => 'menubar_social',
                'default'      => array(),
                'fields' => array(
                    'menubar_social_icon'  => array(
                        'type'        => 'text',
                        'label'       => esc_html__( 'Icon Class Name', 'maester' ),
                        'description' => sprintf('<a target="_blank" href="%s">%s</a> %s <br><span style="color: green">%s</span>', esc_url('https://fontawesome.com/cheatsheet/'), __('Click Here', 'maester'), __('to get icons list', 'maester'), __('Note: Use prefix `fab` for brand, `far` for regular, `fas` for solid icons', 'maester')),
                        'default'     => 'fab fa-facebook',
                    ),
                    'menubar_social_link'  => array(
                        'type'        => 'link',
                        'label'       => esc_html__( 'Icon URL', 'maester' ),
                        'description' => __( 'Example: <span style="color: green;">https://fb.com/your_user_name</span>', 'maester' ),
                        'default'     => '#',
                    ),
                    'menubar_social_link_target' => array(
                        'type'        => 'radio',
                        'label'       => esc_html__( 'Link target', 'maester' ),
                        'default'     => '_self',
                        'priority'    => 10,
                        'choices'     => array(
                            '_blank'   => esc_html__( 'Open in new tab', 'maester' ),
                            '_self' => __( 'Don\'t open in new tab', 'maester' )
                        ),
                    )
                )
            ) );



            /**
             * Footer Options
             */

            Kirki::add_section( 'maester_footer_options', array(
                'title'          => esc_html__( 'Footer', 'maester' ),
                'description'    => esc_html__( 'Footer Settings.', 'maester' ),
                'panel'          => 'maester_options_panel',
                'priority'       => 160,
            ) );

            Kirki::add_field( $config_id, array(
                'type'     => 'text',
                'settings' => 'footer_text',
                'label'    => esc_html__( 'Footer Text', 'maester' ),
                'section'  => 'maester_footer_options',
                'default'  => esc_html__( '&copy; Maester, Developed by idea420', 'maester' ),
                'priority' => 10,
                'partial_refresh'    => array(
                    'footer_text' => array(
                        'selector'        => '.site-info p',
                        'render_callback' => function() {
                            return get_theme_mod('footer_text');
                        },
                    )
                ),
            ));

        }
    }
}


