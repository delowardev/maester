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

            Kirki::add_field( $config_id, [
                'type'        => 'toggle',
                'settings'    => 'enable_topbar',
                'label'       => esc_html__( 'Top Bar Enable/Disable', 'kirki' ),
                'section'     => 'maester_topbar_options',
                'default'     => '1',
                'priority'    => 10,
            ] );

            Kirki::add_field( $config_id, [
                'type'     => 'text',
                'settings' => 'topbar_text',
                'label'    => esc_html__( 'Header Top Text', 'maester' ),
                'section'  => 'maester_topbar_options',
                'default'  => esc_html__( 'Maester | Multipurpose WordPress LMS Theme with Elementor Page Builder', 'maester' ),
                'priority' => 10,
                'partial_refresh'    => [
                    'topbar_text' => [
                        'selector'        => '.top-bar-description',
                        'render_callback' => function() {
                            return get_theme_mod('topbar_text');
                        },
                    ]
                ],
            ]);

            Kirki::add_field( $config_id, [
                'type'        => 'select',
                'settings'    => 'topbar_custom_links',
                'label'       => esc_html__( 'Menu Custom Links', 'maester' ),
                'section'     => 'maester_topbar_options',
                'default'     => ['login', 'profile', 'logout' ],
                'priority'    => 10,
                'multiple'    => 999,
                'choices'     => [
                    'search' => esc_html__( 'Search Icon', 'maester' ),
                    'login' => esc_html__( 'Login Link', 'maester' ),
                    'profile' => esc_html__( 'Profile Link', 'maester' ),
                    'logout' => esc_html__( 'Sign Out Link', 'maester' ),
                ],
            ]);

            Kirki::add_field( $config_id, [
                'type'        => 'repeater',
                'label'       => esc_html__( 'Top Bar Social Icons', 'kirki' ),
                'section'     => 'maester_topbar_options',
                'priority'    => 10,
                'row_label' => [
                    'type'  => 'text',
                    'value' => esc_html__('Social Icon: ', 'kirki' ),
                ],
                'button_label' => esc_html__('Add New Soical Icon', 'kirki' ),
                'settings'     => 'topbar_social', // This value attached to 'js/customizer-custom.js'
                'default'      => [[]],
                'fields' => [
                    'topbar_social_icon'  => [
                        'type'        => 'text',
                        'label'       => esc_html__( 'Icon Class Name', 'kirki' ),
                        'description' => sprintf('<a target="_blank" href="%s">%s</a> %s <br><span style="color: green">%s</span>', esc_url('https://fontawesome.com/cheatsheet/'), __('Click Here', 'maester'), __('to get icons list', 'maester'), __('Note: Use prefix `fab` for brand, `far` for regular, `fas` for solid icons', 'maester')),
                        'default'     => 'fab fa-facebook',
                    ],
                    'topbar_social_link'  => [
                        'type'        => 'link',
                        'label'       => esc_html__( 'Icon URL', 'kirki' ),
                        'description' => __( 'Example: <span style="color: green;">https://fb.com/your_user_name</span>', 'kirki' ),
                        'default'     => '#',
                    ],
                    'topbar_social_link_target' => [
                        'type'        => 'radio',
                        'label'       => esc_html__( 'Link target', 'kirki' ),
                        'default'     => '_self',
                        'priority'    => 10,
                        'choices'     => [
                            '_blank'   => esc_html__( 'Open in new tab', 'kirki' ),
                            '_self' => __( 'Don\'t open in new tab', 'kirki' )
                        ],
                    ]
                ]
            ] );


            /**
             * Header Options
             */

            Kirki::add_section( 'maester_header_options', array(
                'title'          => esc_html__( 'Header', 'maester' ),
                'description'    => esc_html__( 'Header Settings.', 'maester' ),
                'panel'          => 'maester_options_panel',
                'priority'       => 160,
            ) );

            Kirki::add_field( $config_id, [
                'type'        => 'toggle',
                'settings'    => 'enable_header_search',
                'label'       => esc_html__( 'Header Search Enable/Disable', 'kirki' ),
                'section'     => 'maester_header_options',
                'default'     => '1',
                'priority'    => 10,
            ] );

            Kirki::add_field( $config_id, [
                'type'        => 'select',
                'settings'    => 'header_search_post_types',
                'label'       => esc_html__( 'Header Search Post Types', 'kirki' ),
                'section'     => 'maester_header_options',
                'default'     => 'post',
                'priority'    => 10,
                'multiple'    => 0,
                'choices'     => search_post_types()
            ]);

            Kirki::add_field( $config_id, [
                'type'        => 'toggle',
                'settings'    => 'enable_header_cart',
                'label'       => esc_html__( 'Enable Header Cart', 'kirki' ),
                'description' => __("NB: WooCommerce must be installed to see the cart icon"),
                'section'     => 'maester_header_options',
                'default'     => '1',
                'priority'    => 10,
            ] );

            Kirki::add_field( $config_id, [
                'type'        => 'toggle',
                'settings'    => 'enable_header_login_icon',
                'label'       => esc_html__( 'Enable Header Login Icon', 'kirki' ),
                'section'     => 'maester_header_options',
                'default'     => '1',
                'priority'    => 10,
            ] );

            /**
             * Footer Options
             */

            Kirki::add_section( 'maester_footer_options', array(
                'title'          => esc_html__( 'Footer', 'maester' ),
                'description'    => esc_html__( 'Footer Settings.', 'maester' ),
                'panel'          => 'maester_options_panel',
                'priority'       => 160,
            ) );

            Kirki::add_field( $config_id, [
                'type'     => 'text',
                'settings' => 'footer_text',
                'label'    => esc_html__( 'Footer Text', 'maester' ),
                'section'  => 'maester_footer_options',
                'default'  => esc_html__( '&copy; Maester, Developed by idea420', 'maester' ),
                'priority' => 10,
                'partial_refresh'    => [
                    'footer_text' => [
                        'selector'        => '.site-info p',
                        'render_callback' => function() {
                            return get_theme_mod('footer_text');
                        },
                    ]
                ],
            ]);




        }
    }
}


