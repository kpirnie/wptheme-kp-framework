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
                ],
                'save_button' => __( 'Save Theme Settings', 'kpf'),
                'footer_text' => '<p class="alignright">Thanks for creating with <a href="https://kevinpirnie.com" target="_blank">Kevin Pirnie\'s</a> framework.</p>',
            ]);

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
                'title' => __('Security Settings', 'kpf'),
                'sections' => [
                    'security' => [
                        'title'  => __('', 'kpf'),
                        'fields' => [
                            [
                                'id'    => 'kpf_wp_rest',
                                'type'  => 'radio',
                                'inline' => true,
                                'label' => __( 'REST API?', 'kpf' ),
                                'sublabel' => __( 'Should we disable the REST API?', 'kpf' ),
                                'options' => [
                                    2 => __('Get Rid of It!', 'kpf' ),
                                    1 => __('Only on the Front-End', 'kpf' ),
                                    0 => __('No Way!', 'kpf' ),
                                ],
                                'default' => 1,
                            ],
                            [
                                'id'    => 'kpf_app_password',
                                'type'  => 'radio',
                                'inline' => true,
                                'label' => __( 'Aplication Passwords?', 'kpf' ),
                                'sublabel' => __( 'Should we disable Application Passwords?', 'kpf' ),
                                'options' => [
                                    1 => __('Get Rid of Them!', 'kpf' ),
                                    0 => __('No Way!', 'kpf' ),
                                ],
                                'default' => 1,
                            ],
                            [
                                'id'    => 'kpf_remove_feeds',
                                'type'  => 'radio',
                                'inline' => true,
                                'label' => __( 'Remove Feeds?', 'kpf' ),
                                'sublabel' => __( 'Should we remove all RSS Feeds?', 'kpf' ),
                                'options' => [
                                    1 => __('Get Rid of Them!', 'kpf' ),
                                    0 => __('No Way!', 'kpf' ),
                                ],
                                'default' => 0,
                            ],
                            [
                                'id'    => 'kpf_remove_rpc',
                                'type'  => 'radio',
                                'inline' => true,
                                'label' => __( 'Remove RPC?', 'kpf' ),
                                'sublabel' => __( 'Should we remove the XML RPC?', 'kpf' ),
                                'options' => [
                                    1 => __('Get Rid of It!', 'kpf' ),
                                    0 => __('No Way!', 'kpf' ),
                                ],
                                'default' => 1,
                            ],
                            [
                                'id'    => 'kpf_remove_identifiers',
                                'type'  => 'radio',
                                'inline' => true,
                                'label' => __( 'Remove Identifiers?', 'kpf' ),
                                'sublabel' => __( 'Should we remove the WordPress Identifiers?', 'kpf' ),
                                'options' => [
                                    1 => __('Get Rid of Them!', 'kpf' ),
                                    0 => __('No Way!', 'kpf' ),
                                ],
                                'default' => 1,
                            ],
                            [
                                'id'    => 'kpf_remove_adminbar',
                                'type'  => 'radio',
                                'inline' => true,
                                'label' => __( 'Remove Admin-Bar?', 'kpf' ),
                                'sublabel' => __( 'Should we remove the admin bar on the front-end?', 'kpf' ),
                                'options' => [
                                    1 => __('Get Rid of It!', 'kpf' ),
                                    0 => __('No Way!', 'kpf' ),
                                ],
                                'default' => 1,
                            ],
                            [
                                'id'    => 'kpf_remove_commenting',
                                'type'  => 'radio',
                                'inline' => true,
                                'label' => __( 'Remove Commenting?', 'kpf' ),
                                'sublabel' => __( 'Should we remove commenting?', 'kpf' ),
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
                                'sublabel' => __('This will remove the commenting capabilities from the selected post types.', 'kpf'),
                                'options' => $this -> get_all_post_types(),
                                'size' => 5,
                                'conditional' => [
                                    'AND' => [ // <- OR
                                        'field' => '', // field id
                                        'value' => true, // value 
                                        'condition' => '==' // ==, !=, >, <, >=, <=, IN, NOT_IN
                                    ],
                                ],
                            ]
                            
                        ],
                    ],
                ],
            ];
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
                'title' => __('CSS Framework Settings', 'kpf'),

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
                'title' => __('Imagery Settings', 'kpf'),
                'sections' => [
                    'imagery' => [
                        'title'  => __('', 'kpf'),
                        'fields' => [
                            [
                                'id'    => 'kpf_allow_svg',
                                'type'  => 'radio',
                                'inline' => true,
                                'label' => __( 'Allow SVGs?', 'kpf' ),
                                'sublabel' => __( 'Should we allow SVGs to be uploaded to the media library?', 'kpf' ),
                                'options' => [
                                    1 => __('Absolutely!', 'kpf' ),
                                    0 => __('No Way!', 'kpf' ),
                                ],
                                'default' => 1,
                            ],
                            [
                                'id'    => 'kpf_allow_webm',
                                'type'  => 'radio',
                                'inline' => true,
                                'label' => __( 'Allow WEBMs?', 'kpf' ),
                                'sublabel' => __( 'Should we allow WEBMs to be uploaded to the media library?', 'kpf' ),
                                'options' => [
                                    1 => __('Absolutely!', 'kpf' ),
                                    0 => __('No Way!', 'kpf' ),
                                ],
                                'default' => 1,
                            ],
                            [
                                'id'    => 'kpf_extra_image_sizes',
                                'type'  => 'repeater',
                                'label' => __( 'Extra Image Sizes', 'kpf' ),
                                'description' => __( 'This will add additional image sizes. WordPress will automagically create them on upload.<br /><strong>NOTE: </strong>If you already have images uploaded, you will need to regenerate your thumbnails.', 'kpf' ),
                            ],
                            
                        ],
                    ],
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

    }

}