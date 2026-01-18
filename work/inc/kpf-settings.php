<?php
/**
 * Theme Settings Class
 * 
 * Handles the theme settings
 * 
 * @author Kevin Pirnie <iam@kevinpirnie.com>
 * @copyright 2025 Kevin Pirnie
 * 
 * @since 1.0.1
 * @package KP Theme Framework
 * 
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// pull our field framework
use \KP\WPFieldFramework\Loader;

// make sure we aren't loading in the class multiple times
if( ! class_exists( 'KPF_Settings' ) ) {

    /**
     * Class KPF_Settings
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_Settings {

        /**
         * The field framework
         * @var bool
         */
        private ?\KP\WPFieldFramework\Framework $fw = null;

        /**
         * Class constructor.
         * 
         * Setup the object
         * 
         * @internal
         */
        public function __construct( ) {

            // load up our framework
            $this -> fw = Loader::init( );

            // add in the theme settings
            $this -> add_theme_settings( );
        }

        /**
         * add_theme_settings
         * 
         * Creates the theme settings
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return void Returns nothing
         */
        private function add_theme_settings( ): void {

            // setup the key
            $key = 'kpf_settings';

            // create the official options page
            $this -> fw -> addOptionsPage([
                'option_key' => $key,
                'page_title'  => __( 'KP Framework Theme Settings', 'kpf' ),
                'menu_title'  => __( 'KPF Settings', 'kpf'),
                'capability'  => 'list_users',
                'menu_slug'   => 'kpf-settings',
                'icon_url'    => 'dashicons-vault',
                'position'    => 2,
                'tabs'       => [
                    'security' => $this -> add_security_settings(),
                    'themeframework' => $this -> add_theme_framework_settings(),
                    'images' => $this -> add_image_settings(),
                    'content' => $this -> add_content_settings(),
                    'performance' => $this -> add_performance_settings(),
                    'smtp' => $this -> add_smtp_settings(),
                    'cookienotice' => $this -> add_cookie_notice_settings(),
                ],
                'save_button' => __( 'Save Theme Settings', 'kpf'),
                'footer_text' => __( '<p class="alignright">Copyright &copy; ' . date('Y') . ' <a href="https://kevinpirnie.com" target="_blank">Kevin Pirnie</a></p>', 'kpf'),
                'show_export_import' => true,
            ]);

        }

        /**
         * add_theme_framework_settings
         * 
         * Creates the themes frameworks settings
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return array Returns the sections fields
         */
        private function add_theme_framework_settings(): array {

            // return the settings array
            return [
                'title' => __('Framework', 'kpf'),
                'sections' => [
                    'css_framework' => [
                        'fields' => [ // framework selector, framework version, load from cdn
                            [
                                'id' => 'kpf_fw_name',
                                'type' => 'select',
                                'label' => __('CSS Framework', 'kpf'),
                                'description' => __('Picking a framework here will automatically load in everything needed for you to utilize it.<br /><strong>NOTE: </strong>Once you make a selection, you will be able to choose the version to utilize, and whether or not you want to load it from the CDN.', 'kpf'),
                                'options' => [
                                    '0' => __('None', 'kpf'),
                                    '1' => __('Bootstrap', 'kpf'),
                                    '2' => __('UIKit', 'kpf'),
                                    '3' => __('Tailwind', 'kpf'),
                                    '4' => __('Foundation', 'kpf'),
                                    '5' => __('Bulma', 'kpf'),
                                    '6' => __('Materialize', 'kpf'),
                                ],
                                'default' => '0',
                            ],

                            
                            [
                                'id' => 'kpf_fw_cdn',
                                'label' => __('Load from CDN?', 'kpf'),
                                'type' => 'switch',
                                'description' => __('Should we load the framework from the CDN? (cdn.jsdelivr.net)', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                                'conditional' => [
                                    'field' => 'kpf_fw_name',
                                    'value' => ['1', '2', '4', '5', '6'],
                                    'condition' => 'IN',
                                ],
                            ],
                            [
                                'id' => 'kpf_fw_f_note',
                                'type' => 'message',
                                'message_type' => 'warning', // info, success, warning, error
                                'content' => __( 'Tailwind plays a bit differently, you will need to utilize it\'s build processes in order to use this framework.<br />See here for more information: <a href="https://tailwindcss.com/docs/installation/using-vite" target="_blank">https://tailwindcss.com/docs/installation/using-vite</a>', 'kpf'),
                                'conditional' => [
                                    'field' => 'kpf_fw_name',
                                    'value' => '3',
                                    'condition' => '==',
                                ],
                            ],
                        ],
                    ],
                ],
            ];
        }

        /**
         * add_smtp_settings
         * 
         * Creates SMTP configuration options
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return array Returns the sections fields
         */
        private function add_smtp_settings( ): array {

            // return the settings array
            return [
                'title' => __('SMTP', 'kpf'),

            ];
        }

        /**
         * add_cookie_notice_settings
         * 
         * Creates a configurable cookie notice
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return array Returns the sections fields
         */
        private function add_cookie_notice_settings( ): array {

            // return the settings array
            return [
                'title' => __('Cookie Notice', 'kpf'),

            ];
        }

        /**
         * add_security_settings
         * 
         * Creates the theme security settings
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return array Returns the sections fields
         */
        private function add_security_settings(): array {

            // return the settings array
            return [
                'title' => __('Security', 'kpf'),
                'sections' => [
                    'security' => [
                        'fields' => [
                            [
                                'id'    => 'kpf_wp_rest',
                                'type'  => 'radio',
                                'inline' => true,
                                'label' => __( 'REST API?', 'kpf' ),
                                'description' => __( 'Should we disable the REST API?', 'kpf' ),
                                'options' => [
                                    2 => __('Get Rid of It!', 'kpf' ),
                                    1 => __('Only on the Front-End', 'kpf' ),
                                    0 => __('No Way!', 'kpf' ),
                                ],
                                'default' => 1,
                            ],
                            [
                                'id'    => 'kpf_app_password',
                                'type'  => 'switch',
                                'label' => __( 'Aplication Passwords?', 'kpf' ),
                                'description' => __( 'Should we disable Application Passwords?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                            ],
                            [
                                'id'    => 'kpf_remove_feeds',
                                'type'  => 'switch',
                                'label' => __( 'Remove Feeds?', 'kpf' ),
                                'description' => __( 'Should we remove all RSS Feeds?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id'    => 'kpf_remove_rpc',
                                'type'  => 'switch',
                                'label' => __( 'Remove RPC?', 'kpf' ),
                                'sublabel' => __( 'Should we remove the XML RPC?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                            ],
                            [
                                'id'    => 'kpf_remove_identifiers',
                                'type'  => 'switch',
                                'label' => __( 'Remove Identifiers?', 'kpf' ),
                                'description' => __( 'Should we remove the WordPress Identifiers?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id'    => 'kpf_remove_adminbar',
                                'type'  => 'switch',
                                'label' => __( 'Remove Admin-Bar?', 'kpf' ),
                                'description' => __( 'Should we remove the admin bar on the front-end?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                            ],
                            [
                                'id'    => 'kpf_remove_commenting',
                                'type'  => 'radio',
                                'inline' => true,
                                'label' => __( 'Remove Commenting?', 'kpf' ),
                                'description' => __( 'Should we remove commenting?', 'kpf' ),
                                'options' => [
                                    2 => __('Get Rid of It!', 'kpf' ),
                                    1 => __('Only for the Selected Post Types!', 'kpf' ),
                                    0 => __('No Way!', 'kpf' ),
                                ],
                                'default' => 0,
                            ],
                            // needs to be conditional
                            [
                                'id' => 'kpf_remove_commenting_posttypes',
                                'type' => 'multiselect',
                                'label' => __('Post Types', 'kpf'),
                                'description' => __('This will remove the commenting capabilities from the selected post types.', 'kpf'),
                                'options' => $this -> get_all_post_types(),
                                'size' => 100,
                                'conditional' => [
                                    'field' => 'kpf_remove_commenting',
                                    'value' => '1',
                                    'condition' => '==',
                                ],
                            ],
                            
                        ],
                    ],
                ],
            ];
        }

        /**
         * add_image_settings
         * 
         * Create the imagery settings tab
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return array Returns the sections fields
         */
        private function add_image_settings(): array {

            // return the settings array
            return [
                'title' => __('Imagery', 'kpf'),
                'sections' => [
                    'imagery' => [
                        'fields' => [
                            [
                                'id'    => 'kpf_allow_svg',
                                'type'  => 'switch',
                                'label' => __( 'Allow SVGs?', 'kpf' ),
                                'description' => __( 'Should we allow SVG images to be uploaded to the media library?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                            ],
                            [
                                'id'    => 'kpf_allow_webm',
                                'type'  => 'switch',
                                'label' => __( 'Allow WEBPs?', 'kpf' ),
                                'description' => __( 'Should we allow WEBP imagess to be uploaded to the media library?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                            ],
                            [
                                'id'    => 'kpf_allow_convert',
                                'type'  => 'switch',
                                'label' => __( 'Convert Images?', 'kpf' ),
                                'description' => __( 'Should we attempt to convert images uploaded to webp format?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                            ],
                            [
                                'id'    => 'kpf_extra_image_sizes',
                                'type'  => 'repeater',
                                'label' => __( 'Extra Image Sizes', 'kpf' ),
                                'sublabel' => __( 'Existing Sizes:<br />' . $this -> get_current_image_sizes(), 'kpf'),
                                'description' => __( 'This will add additional image sizes. WordPress will automagically create them on upload.<br /><strong>NOTE: </strong>If you already have images uploaded, you will need to regenerate your thumbnails.', 'kpf' ),
                                'fields' => [
                                    [
                                        'id' => 'kpf_img_size_name',
                                        'type' => 'text',
                                        'label' => __('Size Name', 'kpf'),
                                    ],
                                    [
                                        'id' => 'kpf_img_dimensions',
                                        'type' => 'group',
                                        'fields' => [
                                            [
                                                'id' => 'kpf_img_width',
                                                'type' => 'text',
                                                'label' => __('Image Width', 'kpf'),
                                                'sublabel' => __('in pixels', 'kpf'),
                                            ],
                                            [
                                                'id' => 'kpf_img_height',
                                                'type' => 'text',
                                                'label' => __('Image Height', 'kpf'),
                                                'sublabel' => __('in pixels', 'kpf'),
                                            ],
                                            [
                                                'id' => 'kpf_img_crop_vert',
                                                'type' => 'radio',
                                                'label' => __('Crop Vertical', 'kpf'),
                                                'options' => [
                                                    0 => __('None', 'kpf'),
                                                    1 => __('Top', 'kpf'),
                                                    2 => __('Center', 'kpf'),
                                                    3 => __('Bottom', 'kpf'),                                                    
                                                ],
                                                'default' => 0,
                                            ],
                                            [
                                                'id' => 'kpf_img_crop_horz',
                                                'type' => 'radio',
                                                'label' => __('Crop Horizontal', 'kpf'),
                                                'options' => [
                                                    0 => __('None', 'kpf'),
                                                    1 => __('Left', 'kpf'),
                                                    2 => __('Center', 'kpf'),
                                                    3 => __('Right', 'kpf'),                                                    
                                                ],
                                                'default' => 0,
                                            ],
                                        ]
                                    ],
                                ],
                            ],
                            
                        ],
                    ],
                ],
            ];
        }

        /**
         * add_content_settings
         * 
         * Create the content settings tab
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return array Returns the sections fields
         */
        private function add_content_settings(): array {

            // return the array of the fields we need
            return [
                'title' => __('Content', 'kpf'),
                'sections' => [
                    'content' => [
                        'fields' => [
                            [
                                'id' => 'kpf_search_type',
                                'type' => 'radio',
                                'label' => __('Search Type', 'kpf'),
                                'inline' => true,
                                'options' => [
                                    0 => __('Loose (default)', 'kpf'),
                                    1 => __('Exact', 'kpf'),
                                    2 => __('Sentence', 'kpf'),
                                ],
                                'default' => 0,
                            ],
                            [
                                'id' => 'kpf_revisions',
                                'label' => __('Revisions', 'kpf'),
                                'description' => __('How many revisions shoud be kept?', 'kpf'),
                                'type' => 'number',
                                'default' => 3,
                            ],
                            [
                                'id' => 'kpf_allow_inline_css',
                                'type' => 'switch',
                                'label' => __('Allow Inline CSS?', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id' => 'kpf_inline_css_posttypes',
                                'type' => 'multiselect',
                                'label' => __('Post Types', 'kpf'),
                                'description' => __('This will add a textarea to the post types you select, that will allow you to input inlined CSS.', 'kpf'),
                                'options' => $this -> get_all_post_types(),
                                'size' => 100,
                                'conditional' => [
                                    'field' => 'kpf_allow_inline_css',
                                    'value' => true,
                                    'condition' => '==',
                                ],
                            ],
                            [
                                'id' => 'kpf_allow_inline_js',
                                'type' => 'switch',
                                'label' => __('Allow Inline Javascript?', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id' => 'kpf_inline_js_posttypes',
                                'type' => 'multiselect',
                                'label' => __('Post Types', 'kpf'),
                                'description' => __('This will add a textarea to the post types you select, that will allow you to input inlined javascript.', 'kpf'),
                                'options' => $this -> get_all_post_types(),
                                'size' => 100,
                                'conditional' => [
                                    'field' => 'kpf_allow_inline_js',
                                    'value' => true,
                                    'condition' => '==',
                                ],
                            ],
                        ],
                    ]
                ]
            ];
        }

        /**
         * add_performance_settings
         * 
         * Create the performance settings tab
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return array Returns the sections fields
         */
        private function add_performance_settings(): array {

            // return the array of the fields
            return [
                'title' => __('Performance', 'kpf'),
                'sections' => [
                    'performance' => [
                        'fields' => [
                            [
                                'id' => 'kpf_perf_remove_qs',
                                'type' => 'switch',
                                'label' => __('Remove Querystrings?', 'kpf'),
                                'description' => __('This will attempt to remove querystrings from all static resources.', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id' => 'kpf_perf_force_js_footer',
                                'type' => 'switch',
                                'label' => __('JS to Footer?', 'kpf'),
                                'description' => __('This will attempt to force all javascript resrouces to load in the site footer.', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id' => 'kpf_perf_defer_js',
                                'type' => 'switch',
                                'label' => __('Defer JS?', 'kpf'),
                                'description' => __('This will attempt to mark all javascript resources as defered.', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id' => 'kpf_perf_apply_pre',
                                'type' => 'switch',
                                'label' => __('Apply the Pre\'s?', 'kpf'),
                                'sublabel' => __('Pre-Load, Pre-Render, and Pre-Fetch', 'kpf'),
                                'description' => __('This will attempt inject pre-load, pre-render, and pre-fetch meta-tags for all external resources.', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id' => 'kpf_perf_apply_ip',
                                'type' => 'switch',
                                'label' => __('Apply instant.page?', 'kpf'),
                                'description' => __('This will attempt to inject the instant.page library. See here for more info: <a href="https://instant.page/" target="_blank">https://instant.page/</a>', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id' => 'kpf_perf_slow_hb',
                                'type' => 'switch',
                                'label' => __('Slow Down Heartbeat?', 'kpf'),
                                'description' => __('This will attempt to slow down WordPress\'s heartbeat. This will change it from the default 15 seconds to 300 seconds.', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id' => 'kpf_perf_rmove_emojis',
                                'type' => 'switch',
                                'label' => __('Remove Emojis?', 'kpf'),
                                'description' => __('This will attempt to remove all WordPress default emoji scripts and stylesheets.', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                        ],
                    ]
                ],
            ];
        }

        /**
         * get_all_post_types
         * 
         * Get all of the sites post types
         * built-in and custom
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return array Returns the post types
         */
        private function get_all_post_types(): array {

            // hold the return
            $ret = [];
            
            // retrieve them
            $post_types = get_post_types( [], 'objects' );

            // looop over all of them
            foreach( $post_types as $pt ) {
                $labels = get_post_type_labels($pt );
                $ret[esc_attr( $pt->name )] =  esc_html__( $labels->name, 'kpf' );
            }

            // return the array
            return $ret;
        }


        /** 
         * get_current_image_sizes
         * 
         * Gets a list of all registered Wordpress image sizes
         * 
         * @since 7.3
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin's Framework
         * 
         * @return string Returns a formattted string of all currently registered image sizes
         * 
        */
        private function get_current_image_sizes( ) : ?string {

            // hold our return
            $_ret = '';

            // get the wp global for additional image sizes
            global $_wp_additional_image_sizes;

            // let's setup our processing variables
            $sizes = array( );
            $rSizes = array( );

            // get the existing image sizes
            $_get_image_sizes = get_intermediate_image_sizes( );

            // loop over them so we can setup out display
            foreach ( $_get_image_sizes as $s ) {

                // fire up
                $sizes[$s] = array( 0, 0 );
                
                // let's check for the standard sizes
                if ( in_array( $s, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
                    
                    $sizes[$s][0] = get_option( $s . '_size_w' );
                    $sizes[$s][1] = get_option( $s . '_size_h' );
                } else {

                    if ( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[$s] ) )
                        $sizes[$s] = array( $_wp_additional_image_sizes[$s]['width'], $_wp_additional_image_sizes[$s]['height'], );
                }
            }

            // make sure there actually are sizes
            if( $sizes ) {

                // setup the output string
                foreach ( $sizes as $size => $atts ) {
                    $_ret .= '&nbsp;<strong>' . $size . ':</strong> ' . '(' . implode( 'x', $atts ) . ')<br />';
                }
                
            }
            
            // return the sizes string
            return $_ret;

        }

    }

}