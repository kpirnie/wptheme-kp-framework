<?php
/**
 * Cookie Notice Module Settings
 * 
 * Handles the cookie notice settings tab
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

// make sure we aren't loading in the class multiple times
if( ! class_exists( 'KPF_Module_Cookie_Notice_Settings' ) ) {

    /**
     * Class KPF_Module_Cookie_Notice_Settings
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_Module_Cookie_Notice_Settings extends KPF_Module_Base {

        /**
         * get_tab_config
         * 
         * Returns the tab configuration for the cookie notice module
         * 
         * @return array The tab configuration
         */
        public function get_tab_config( ): array {

            return [
                'title'    => __( 'Cookie Notice', 'kpf' ),
                'sections' => [
                    'cn_settings' => [
                        'fields' => $this->get_fields( ),
                    ],
                ],
            ];

        }

        /**
         * get_fields
         * 
         * Returns the cookie notice settings fields
         * 
         * @access private
         * 
         * @return array The fields configuration
         */
        private function get_fields( ): array {

            return [
                $this->get_enable_field( ),
                $this->get_settings_accordion( ),
                $this->get_content_accordion( ),
                $this->get_styling_accordion( ),
            ];

        }

        /**
         * get_enable_field
         * 
         * Returns the enable cookie notice field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_enable_field( ): array {

            return [
                'id'          => 'kpf_cn_allow',
                'label'       => __( 'Cookie Notice?', 'kpf' ),
                'type'        => 'switch',
                'description' => __( 'Should your site contain a cookie notice?', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
            ];

        }

        /**
         * get_settings_accordion
         * 
         * Returns the settings accordion field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_settings_accordion( ): array {

            return [
                'id'          => 'kpf_cn_settings',
                'type'        => 'accordion',
                'label'       => __( 'Settings', 'kpf' ),
                'description' => __( 'Display options, buttons, and labels for the cookie notice "banner"', 'kpf' ),
                'open'        => true,
                'fields'      => [
                    $this->get_excluded_posttypes_field( ),
                    $this->get_display_options_group( ),
                    $this->get_buttons_group( ),
                    $this->get_privacy_button_field( ),
                    $this->get_privacy_options_group( ),
                ],
                'conditional' => [
                    'field'     => 'kpf_cn_allow',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_excluded_posttypes_field
         * 
         * Returns the excluded post types field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_excluded_posttypes_field( ): array {

            return [
                'id'          => 'kpf_cn_expt',
                'label'       => __( 'Excluded Post Types', 'kpf' ),
                'description' => __( 'Select the post types you want to exclude from rendering the cookie notice.', 'kpf' ),
                'type'        => 'multiselect',
                'options'     => $this->get_all_post_types( ),
                'size'        => 100,
                'conditional' => [
                    'field'     => 'kpf_cn_allow',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_display_options_group
         * 
         * Returns the display options group field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_display_options_group( ): array {

            return [
                'id'          => 'kpf_cn_intd',
                'type'        => 'group',
                'label'       => __( 'Display Options', 'kpf' ),
                'fields'      => [
                    [
                        'id'          => 'kpf_cn_noscroll',
                        'type'        => 'switch',
                        'label'       => __( 'No Scroll?', 'kpf' ),
                        'description' => __( 'Should we apply a "no scroll" to the site?<br /><strong>NOTE: </strong>This is considered intrusive as it will prevent the page from being scrolled until the end-user accepts the cookie notice.', 'kpf' ),
                        'on_label'    => __( 'Yes', 'kpf' ),
                        'off_label'   => __( 'No', 'kpf' ),
                        'default'     => true,
                        'inline'      => true,
                    ],
                    [
                        'id'          => 'kpf_cn_overlay',
                        'type'        => 'switch',
                        'label'       => __( 'Show Overlay?', 'kpf' ),
                        'description' => __( 'Should we render a page overlay?<br />You will be able to control it\'s styling below.', 'kpf' ),
                        'on_label'    => __( 'Yes', 'kpf' ),
                        'off_label'   => __( 'No', 'kpf' ),
                        'default'     => true,
                        'inline'      => true,
                    ],
                ],
                'conditional' => [
                    'field'     => 'kpf_cn_allow',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_buttons_group
         * 
         * Returns the buttons group field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_buttons_group( ): array {

            return [
                'id'          => 'kpf_cn_btn',
                'type'        => 'group',
                'label'       => __( 'Buttons', 'kpf' ),
                'fields'      => [
                    [
                        'id'          => 'kpf_cn_accept',
                        'type'        => 'text',
                        'label'       => __( 'Accept', 'kpf' ),
                        'description' => __( 'Enter the accept button text', 'kpf' ),
                        'default'     => __( 'Accept', 'kpf' ),
                        'inline'      => true,
                    ],
                    [
                        'id'          => 'kpf_cn_cancel',
                        'type'        => 'text',
                        'label'       => __( 'Cancel', 'kpf' ),
                        'description' => __( 'Enter the cancel button text', 'kpf' ),
                        'default'     => __( 'Do Not Accept', 'kpf' ),
                        'inline'      => true,
                    ],
                ],
                'conditional' => [
                    'field'     => 'kpf_cn_allow',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_privacy_button_field
         * 
         * Returns the privacy button toggle field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_privacy_button_field( ): array {

            return [
                'id'          => 'kpf_cn_privacybutton',
                'type'        => 'switch',
                'label'       => __( 'Add Privacy Policy Button?', 'kpf' ),
                'description' => __( 'Should we add a privacy policy button?', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
                'conditional' => [
                    'field'     => 'kpf_cn_allow',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_privacy_options_group
         * 
         * Returns the privacy options group field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_privacy_options_group( ): array {

            return [
                'id'          => 'kpf_cn_privacy',
                'type'        => 'group',
                'label'       => __( 'Button Options', 'kpf' ),
                'fields'      => [
                    [
                        'id'          => 'kpf_cn_privacy_page',
                        'type'        => 'page_select',
                        'label'       => __( 'Page', 'kpf' ),
                        'description' => __( 'Select your privacy policy page.', 'kpf' ),
                        'inline'      => true,
                    ],
                    [
                        'id'          => 'kpf_privacy_button_text',
                        'type'        => 'text',
                        'label'       => __( 'Button Text', 'kpf' ),
                        'description' => __( 'Enter the button text', 'kpf' ),
                        'default'     => __( 'Privacy Policy', 'kpf' ),
                        'inline'      => true,
                    ],
                ],
                'conditional' => [
                    'field'     => 'kpf_cn_settings_kpf_cn_privacybutton',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_content_accordion
         * 
         * Returns the content accordion field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_content_accordion( ): array {

            return [
                'id'          => 'kpf_cn_content',
                'type'        => 'accordion',
                'label'       => __( 'Banner Content', 'kpf' ),
                'open'        => false,
                'fields'      => [
                    [
                        'id'          => 'kpf_cn_title',
                        'type'        => 'text',
                        'label'       => __( 'Notice Title', 'kpf' ),
                        'default'     => __( 'Notice', 'kpf' ),
                        'conditional' => [
                            'field'     => 'kpf_cn_allow',
                            'value'     => true,
                            'condition' => '==',
                        ],
                    ],
                    [
                        'id'            => 'kpf_cn_message',
                        'type'          => 'wysiwyg',
                        'label'         => __( 'Content', 'kpf' ),
                        'rows'          => 10,
                        'media_buttons' => false,
                        'teeny'         => false,
                        'quicktags'     => true,
                        'conditional'   => [
                            'field'     => 'kpf_cn_allow',
                            'value'     => true,
                            'condition' => '==',
                        ],
                    ],
                ],
                'conditional' => [
                    'field'     => 'kpf_cn_allow',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_styling_accordion
         * 
         * Returns the styling accordion field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_styling_accordion( ): array {

            return [
                'id'          => 'kpf_cn_styling',
                'type'        => 'accordion',
                'label'       => __( 'Styling', 'kpf' ),
                'open'        => false,
                'fields'      => [
                    $this->get_position_field( ),
                    $this->get_css_classes_group( ),
                    $this->get_custom_css_field( ),
                ],
                'conditional' => [
                    'field'     => 'kpf_cn_allow',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_position_field
         * 
         * Returns the banner position field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_position_field( ): array {

            return [
                'id'      => 'kpf_cn_banner_position',
                'type'    => 'radio',
                'label'   => __( 'Banner/Notice Position', 'kpf' ),
                'inline'  => true,
                'options' => [
                    'top-left'      => __( 'Top Left', 'kpf' ),
                    'top-center'    => __( 'Top Center', 'kpf' ),
                    'top-right'     => __( 'Top Right', 'kpf' ),
                    'screen-center' => __( 'Screen Center', 'kpf' ),
                    'bottom-left'   => __( 'Bottom Left', 'kpf' ),
                    'bottom-center' => __( 'Bottom Center', 'kpf' ),
                    'bottom-right'  => __( 'Bottom Right', 'kpf' ),
                ],
                'default' => 'screen-center',
            ];

        }

        /**
         * get_css_classes_group
         * 
         * Returns the CSS classes group field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_css_classes_group( ): array {

            return [
                'id'     => 'kpf_cn_classes',
                'type'   => 'group',
                'label'  => __( 'CSS Classes', 'kpf' ),
                'fields' => [
                    [
                        'id'     => 'kpf_cn_accept_btn_class',
                        'type'   => 'text',
                        'label'  => __( 'Accept Button', 'kpf' ),
                        'inline' => true,
                    ],
                    [
                        'id'     => 'kpf_cn_nonaccept_btn_class',
                        'type'   => 'text',
                        'label'  => __( 'Cancel Button', 'kpf' ),
                        'inline' => true,
                    ],
                    [
                        'id'   => 'kpf_cn_sep1',
                        'type' => 'separator',
                    ],
                    [
                        'id'     => 'kpf_cn_privacy_btn_class',
                        'type'   => 'text',
                        'label'  => __( 'Privacy Button', 'kpf' ),
                        'inline' => true,
                    ],
                    [
                        'id'     => 'kpf_cn_overlay_class',
                        'type'   => 'text',
                        'label'  => __( 'Overlay', 'kpf' ),
                        'inline' => true,
                    ],
                    [
                        'id'   => 'kpf_cn_sep2',
                        'type' => 'separator',
                    ],
                    [
                        'id'    => 'kpf_cn_banner_class',
                        'type'  => 'text',
                        'label' => __( 'Banner Container', 'kpf' ),
                    ],
                ],
            ];

        }

        /**
         * get_custom_css_field
         * 
         * Returns the custom CSS field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_custom_css_field( ): array {

            return [
                'id'          => 'kpf_cn_custom_css',
                'type'        => 'code',
                'label'       => __( 'Custom CSS', 'kpf' ),
                'description' => __( 'Please do not use html tags in this as they will get stripped out. We will properly inject what you put in here...', 'kpf' ),
                'code_type'   => 'text/css',
                'rows'        => 10,
            ];

        }

    }

}