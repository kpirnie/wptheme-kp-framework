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
                    'permissions' => $this -> add_permissions_settings(),
                    'security' => $this -> add_security_settings(),
                    'themeframework' => $this -> add_theme_framework_settings(),
                    'images' => $this -> add_image_settings(),
                    'content' => $this -> add_content_settings(),
                    'performance' => $this -> add_performance_settings(),
                    'smtp' => $this -> add_smtp_settings(),
                    'cookienotice' => $this -> add_cookie_notice_settings(),
                ],
                'save_button' => __( 'Save Your Settings', 'kpf'),
                'footer_text' => __( '<p class="alignright">Copyright &copy; ' . date('Y') . ' <a href="https://kevinpirnie.com" target="_blank">Kevin Pirnie</a></p>', 'kpf'),
                'show_export_import' => true,
            ]);

        }

        /**
         * add_permissions_settings
         * 
         * Creates the themes permissions
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
        private function add_permissions_settings(): array {
            return [
                'title' => __('Permissions', 'kpf'),
                'description' => __('Controls which settings are available to which Roles and Users.', 'kpf'),
                'sections' => [
                    'permissions' => [
                        'fields' => [
                            [
                                'id' => 'kpf_perms_roles',
                                'type' => 'group',
                                'label' => __('Site Roles', 'kpf'),
                                'description' => __('Select the roles that should have permissions to access the settings below.', 'kpf'),
                                'fields' => [

                                ],
                            ],
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

                            // bootstrap version
                            [
                                'id' => 'kpf_fw_bs_ver',
                                'type' => 'select',
                                'label' => __('Framework Version', 'kpf'),
                                'description' => __('Select the framework version that you would like ot utilize.', 'kpf'),
                                'options' => [
                                    'latest' => '5.3.3',
                                    '5.3' => '5.3.3',
                                    '5.2' => '5.2.3',
                                    '5.1' => '5.1.3',
                                    '5.0' => '5.0.2',
                                ],
                                'conditional' => [
                                    'field' => 'kpf_fw_name',
                                    'value' => '1',
                                    'condition' => '==',
                                ],
                            ],
                            // uikit version
                            [
                                'id' => 'kpf_fw_uk_ver',
                                'type' => 'select',
                                'label' => __('Framework Version', 'kpf'),
                                'description' => __('Select the framework version that you would like ot utilize.', 'kpf'),
                                'options' => [
                                    'latest' => '3.21.6',
                                    '3.21' => '3.21.6',
                                    '3.20' => '3.20.8',
                                    '3.19' => '3.19.4',
                                ],
                                'conditional' => [
                                    'field' => 'kpf_fw_name',
                                    'value' => '2',
                                    'condition' => '==',
                                ],
                            ],
                            // tailwind version
                            [
                                'id' => 'kpf_fw_tw_ver',
                                'type' => 'select',
                                'label' => __('Framework Version', 'kpf'),
                                'description' => __('Select the framework version that you would like ot utilize.', 'kpf'),
                                'options' => [
                                    'latest' => '3.4.17',
                                    '3.4' => '3.4.17',
                                    '3.3' => '3.3.6',
                                ],
                                'conditional' => [
                                    'field' => 'kpf_fw_name',
                                    'value' => '3',
                                    'condition' => '==',
                                ],
                            ],
                            // foundation version
                            [
                                'id' => 'kpf_fw_f_ver',
                                'type' => 'select',
                                'label' => __('Framework Version', 'kpf'),
                                'description' => __('Select the framework version that you would like ot utilize.', 'kpf'),
                                'options' => [
                                    'latest' => '6.8.1',
                                    '6.8' => '6.8.1',
                                    '6.7' => '6.7.5',
                                    '6.6' => '6.6.3',
                                ],
                                'conditional' => [
                                    'field' => 'kpf_fw_name',
                                    'value' => '4',
                                    'condition' => '==',
                                ],
                            ],
                            // bulma version
                            [
                                'id' => 'kpf_fw_b_ver',
                                'type' => 'select',
                                'label' => __('Framework Version', 'kpf'),
                                'description' => __('Select the framework version that you would like ot utilize.', 'kpf'),
                                'options' => [
                                    'latest' => '1.0.2',
                                    '1.0' => '1.0.2',
                                    '0.9' => '0.9.4',
                                ],
                                'conditional' => [
                                    'field' => 'kpf_fw_name',
                                    'value' => '5',
                                    'condition' => '==',
                                ],
                            ],
                            // materialize version
                            [
                                'id' => 'kpf_fw_m_ver',
                                'type' => 'select',
                                'label' => __('Framework Version', 'kpf'),
                                'description' => __('Select the framework version that you would like ot utilize.', 'kpf'),
                                'options' => [
                                    'latest' => '1.0.0',
                                    '1.0' => '1.0.0',
                                    '0.100.2' => '0.100.2',
                                ],
                                'conditional' => [
                                    'field' => 'kpf_fw_name',
                                    'value' => '6',
                                    'condition' => '==',
                                ],
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
                'sections' => [
                    'smtp' => [
                        'fields' => [
                            [
                                'id' => 'kpf_smtp_override',
                                'label' => __('Override WordPress?', 'kpf'),
                                'description' => __('Should we override WordPress\'s email sender?', 'kpf'),
                                'type' => 'switch',
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id' => 'kpf_smtp_force_from',
                                'label' => __('Force From?', 'kpf'),
                                'description' => __('Should the from email address be overridden?<br />If you do not, the from address will default to the username account you set below (if it is an email address), otherwise it will be set to the websites admin email address.', 'kpf'),
                                'type' => 'switch',
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                                'conditional' => [
                                    'field' => 'kpf_smtp_override',
                                    'value' => true,
                                    'condition' => '==',
                                ],
                            ],
                            [
                                'id' => 'kpf_smtp_from',
                                'label' => __('From', 'kpf'),
                                'type' => 'group',
                                'fields' => [
                                    [
                                        'id' => 'kpf_smtp_from_n',
                                        'type' => 'text',
                                        'label' => __('Name', 'kpf'),
                                        'inline' => true,
                                    ],
                                    [
                                        'id' => 'kpf_smtp_from_e',
                                        'type' => 'email',
                                        'label' => __('Email Address', 'kpf'),
                                        'inline' => true,
                                    ],
                                ],
                                'conditional' => [
                                    'field' => 'kpf_smtp_force_from',
                                    'value' => true,
                                    'condition' => '==',
                                ],
                            ],
                            [
                                'id' => 'kpf_smtp_server',
                                'label' => __('Server Information', 'kpf'),
                                'sublabel' => __('Please see your providers support pages for the information you will need here.', 'kpf'),
                                'type' => 'group',
                                'fields' => [
                                    [
                                        'id' => 'kpf_smtp_host',
                                        'type' => 'url',
                                        'label' => __('Server/Host', 'kpf'),
                                        'inline' => true,
                                    ],
                                    [
                                        'id' => 'kpf_smtp_port',
                                        'type' => 'text',
                                        'label' => __('Port', 'kpf'),
                                        'default' => 25,
                                        'inline' => true,
                                    ],
                                    ['id' => 'kpf_smtp_br1', 'type' => 'html', 'content' => '<br />'],
                                    [
                                        'id' => 'kpf_smtp_un',
                                        'type' => 'text',
                                        'label' => __('Username', 'kpf'),
                                        'inline' => true,
                                    ],
                                    [
                                        'id' => 'kpf_smtp_pw',
                                        'type' => 'password',
                                        'label' => __('Password', 'kpf'),
                                        'inline' => true,
                                    ],
                                    ['id' => 'kpf_smtp_br2', 'type' => 'html', 'content' => '<br />'],
                                    [
                                        'id' => 'kpf_smtp_html',
                                        'label' => __('Force HTML?', 'kpf'),
                                        'description' => __('Should emails sent out be converted to HTML format?', 'kpf'),
                                        'type' => 'switch',
                                        'on_label'  => __('Yes', 'kpf'),
                                        'off_label' => __('No', 'kpf'),
                                        'default' => true,
                                        'inline' => true,
                                    ],
                                    [
                                        'id' => 'kpf_smtp_security',
                                        'label' => __('Security Type?', 'kpf'),
                                        'type' => 'radio',
                                        'options' => [
                                            '0' => __('None', 'kpf'),
                                            '1' => __('SSL', 'kpf'),
                                            '2' => __('STARTTLS', 'kpf'),
                                        ],
                                        'inline' => true,
                                    ],

                                ],
                                'conditional' => [
                                    'field' => 'kpf_smtp_override',
                                    'value' => true,
                                    'condition' => '==',
                                ],
                            ],
                            
                        ],
                    ],
                ],
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
                'sections' => [
                    'cn_settings' => [
                        'fields' => [
                            [
                                'id' => 'kpf_cn_allow',
                                'label' => __('Cookie Notice?', 'kpf'),
                                'type' => 'switch',
                                'description' => __('Should your site contain a cookie notice?', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id' => 'kpf_cn_settings',
                                'type' => 'accordion',
                                'label' => __('Settings', 'kpf'),
                                'description' => __('Display options, buttons, and labels for the cookie notice "banner"', 'kpf'),
                                'open' => true,
                                'fields' => [
                                    [
                                        'id' => 'kpf_cn_expt',
                                        'label' => __('Excluded Posts Types', 'kpf'),
                                        'description' => __('Select the post types you want to exclude from rendering the cookie notice.', 'kpf'),
                                        'type' => 'multiselect',
                                        'options' => $this -> get_all_post_types(),
                                        'size' => 100,
                                        'conditional' => [
                                            'field' => 'kpf_cn_allow',
                                            'value' => true,
                                            'condition' => '==',
                                        ],
                                    ],  
                                    [
                                        'id' => 'kpf_cn_intd',
                                        'type' => 'group',
                                        'label' => __('Display Options', 'kpf'),
                                        'fields' => [
                                            [
                                                'id' => 'kpf_cn_noscroll',
                                                'type' => 'switch',
                                                'label' => __('No Scroll?', 'kpf'),
                                                'description' => __('Should we apply a "no scroll" to the site?<br /><strong>NOTE: </strong>This is considered intrusive as it will prevent the page from being scrolled until the end-user accepts the cookie notice.', 'kpf'),
                                                'on_label'  => __('Yes', 'kpf'),
                                                'off_label' => __('No', 'kpf'),
                                                'default' => true,
                                                'inline' => true,
                                            ],
                                            [
                                                'id' => 'kpf_cn_overlay',
                                                'type' => 'switch',
                                                'label' => __('Show Overlay?', 'kpf'),
                                                'description' => __('Should we render a page overlay?<br />You will be able to control it\'s styling below.', 'kpf'),
                                                'on_label'  => __('Yes', 'kpf'),
                                                'off_label' => __('No', 'kpf'),
                                                'default' => true,
                                                'inline' => true,
                                            ],
                                        ],
                                        'conditional' => [
                                            'field' => 'kpf_cn_allow',
                                            'value' => true,
                                            'condition' => '==',
                                        ],
                                    ],
                                    [
                                        'id' => 'kpf_cn_btn',
                                        'type' => 'group',
                                        'label' => __('Buttons', 'kpf'),
                                        'fields' => [
                                            [
                                                'id' => 'kpf_cn_accept',
                                                'type' => 'text',
                                                'label' => __('Accept', 'kpf'),
                                                'description' => __('Enter the accept button text', 'kpf'),
                                                'default' => 'Accept',
                                                'inline' => true,
                                            ],
                                            [
                                                'id' => 'kpf_cn_cancel',
                                                'type' => 'text',
                                                'label' => __('Show Overlay?', 'kpf'),
                                                'label' => __('Cancel', 'kpf'),
                                                'description' => __('Enter the cancel button text', 'kpf'),
                                                'default' => __('Do Not Accept', 'kpf'),
                                                'inline' => true,
                                            ],
                                        ],
                                        'conditional' => [
                                            'field' => 'kpf_cn_allow',
                                            'value' => true,
                                            'condition' => '==',
                                        ],
                                    ],
                                    [
                                        'id' => 'kpf_cn_privacybutton',
                                        'type' => 'switch',
                                        'label' => __('Add Privacy Policy Button?', 'kpf'),
                                        'description' => __('Should we add a privacy policy button?', 'kpf'),
                                        'on_label'  => __('Yes', 'kpf'),
                                        'off_label' => __('No', 'kpf'),
                                        'default' => false,
                                        'conditional' => [
                                            'field' => 'kpf_cn_allow',
                                            'value' => true,
                                            'condition' => '==',
                                        ],
                                    ],
                                    [
                                        'id' => 'kpf_cn_privacy',
                                        'type' => 'group',
                                        'label' => __('Button Options', 'kpf'),
                                        'fields' => [
                                            [
                                                'id'    => 'kpf_cn_privacy_page',
                                                'type'  => 'page_select',
                                                'label' => __('Page', 'kpf'),
                                                'description' => __('Select your privacy policy page.', 'kpf'),
                                            ],
                                            [
                                                'id'    => 'kpf_privacy_button_text',
                                                'type'  => 'text',
                                                'label' => __('Button Text', 'kpf'),
                                                'description' => __('Enter the button text', 'kpf'),
                                                'default' => __('Privacy Policy', 'kpf'),
                                                'inline' => true,
                                            ],
                                            [
                                                'id'    => 'kpf_privacy_button_classes',
                                                'type'  => 'text',
                                                'label' => __('Extra Classes', 'kpf'),
                                                'description' => __('Extra CSS classes you want applied to the button', 'kpf'),
                                                'inline' => true,
                                            ],
                                            
                                        ],
                                        'conditional' => [
                                            'field' => 'kpf_cn_privacybutton',
                                            'value' => true,
                                            'condition' => '==',
                                        ],
                                    ],
                                ],
                                'conditional' => [
                                    'field' => 'kpf_cn_allow',
                                    'value' => true,
                                    'condition' => '==',
                                ],
                            ],
                            [
                                'id' => 'kpf_cn_content',
                                'type' => 'accordion',
                                'label' => __('Banner Content', 'kpf'),
                                'open' => false,
                                'fields' => [
                                    [
                                        'id' => 'kpf_cn_title',
                                        'type' => 'text',
                                        'label' => __('Notice Title', 'kpf'),
                                        'default' => __('Notice', 'kpf'),
                                        'conditional' => [
                                            'field' => 'kpf_cn_allow',
                                            'value' => true,
                                            'condition' => '==',
                                        ],
                                    ],
                                    [
                                        'id' => 'kpf_cn_message',
                                        'type' => 'wysiwyg',
                                        'label' => __('Content', 'kpf'),
                                        'rows'          => 10,
                                        'media_buttons' => false,
                                        'teeny'         => false,
                                        'quicktags'     => true,
                                        'conditional' => [
                                            'field' => 'kpf_cn_allow',
                                            'value' => true,
                                            'condition' => '==',
                                        ],
                                    ],
                                ],
                                'conditional' => [
                                    'field' => 'kpf_cn_allow',
                                    'value' => true,
                                    'condition' => '==',
                                ],
                            ],
                            [
                                'id' => 'kpf_cn_styling',
                                'type' => 'accordion',
                                'label' => __('Styling', 'kpf'),
                                'open' => false,
                                'fields' => [
                                    [
                                        'id' => 'kpf_cn_banner_position',
                                        'type' => 'radio',
                                        'label' => __('Banner/Notice Position', 'kpf'),
                                        'inline' => true,
                                        'options' => [
                                            'top-left' => __( 'Top Left', 'kpf' ),
                                            'top-center' => __( 'Top Center', 'kpf' ),
                                            'top-right' => __( 'Top Right', 'kpf' ),
                                            'screen-center' => __( 'Screen Center', 'kpf' ),
                                            'bottom-left' => __( 'Bottom Left', 'kpf' ),
                                            'bottom-center' => __( 'Bottom Center', 'kpf' ),
                                            'bottom-right' => __( 'Bottom Right', 'kpf' ),
                                        ],
                                        'default' => 'screen-center'
                                    ],
                                    [
                                        'id' => 'kpf_cn_classes',
                                        'type' => 'group',
                                        'label' => __('CSS Classes', 'kpf'),
                                        'fields' => [
                                            [
                                                'id' => 'kpf_cn_accept_btn_class',
                                                'type' => 'text',
                                                'label' => __('Accept Button', 'kpf'),
                                                'inline' => true,
                                            ],
                                            [
                                                'id' => 'kpf_cn_nonaccept_btn_class',
                                                'type' => 'text',
                                                'label' => __('Cancel Button', 'kpf'),
                                                'inline' => true,
                                            ],
                                            ['id' => '', 'type' => 'separator'],
                                            [
                                                'id' => 'kpf_cn_privacy_btn_class',
                                                'type' => 'text',
                                                'label' => __('Privacy Button', 'kpf'),
                                                'inline' => true,
                                            ],
                                            [
                                                'id' => 'kpf_cn_overlay_class',
                                                'type' => 'text',
                                                'label' => __('Overlay', 'kpf'),
                                                'inline' => true,
                                            ],
                                            ['id' => '', 'type' => 'separator'],
                                            [
                                                'id' => 'kpf_cn_banner_class',
                                                'type' => 'text',
                                                'label' => __('Banner Container', 'kpf'),
                                            ],

                                        ],
                                    ],
                                    [
                                        'id' => 'kpf_cn_custom_css',
                                        'type' => 'code',
                                        'label' => __('Custom CSS', 'kpf'),
                                        'description' => __('Please do not use html tags in this as they will get stripped out.  We will properly inject what you put in here...', 'kpf'),
                                        'code_type' => 'text/css', // text/html, application/javascript, etc.
                                        'rows'      => 10,
                                    ],

                                ],
                                'conditional' => [
                                    'field' => 'kpf_cn_allow',
                                    'value' => true,
                                    'condition' => '==',
                                ],
                            ],
                        ],
                    ],

                ],
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
                                'id'    => 'kpf_sec_rest',
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
                                'id'    => 'kpf_sec_app_password',
                                'type'  => 'switch',
                                'label' => __( 'Aplication Passwords?', 'kpf' ),
                                'description' => __( 'Should we disable Application Passwords?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                            ],
                            [
                                'id'    => 'kpf_sec_remove_feeds',
                                'type'  => 'switch',
                                'label' => __( 'Remove Feeds?', 'kpf' ),
                                'description' => __( 'Should we remove all RSS Feeds?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id'    => 'kpf_sec_remove_rpc',
                                'type'  => 'switch',
                                'label' => __( 'Remove RPC?', 'kpf' ),
                                'sublabel' => __( 'Should we remove the XML RPC?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                            ],
                            [
                                'id'    => 'kpf_sec_remove_identifiers',
                                'type'  => 'switch',
                                'label' => __( 'Remove Identifiers?', 'kpf' ),
                                'description' => __( 'Should we remove the WordPress Identifiers?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id'    => 'kpf_sec_remove_adminbar',
                                'type'  => 'switch',
                                'label' => __( 'Remove Admin-Bar?', 'kpf' ),
                                'description' => __( 'Should we remove the admin bar on the front-end?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                            ],
                            [
                                'id'    => 'kpf_sec_remove_commenting',
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
                                'id' => 'kpf_sec_remove_commenting_posttypes',
                                'type' => 'multiselect',
                                'label' => __('Post Types', 'kpf'),
                                'description' => __('This will remove the commenting capabilities from the selected post types.', 'kpf'),
                                'options' => $this -> get_all_post_types(),
                                'size' => 100,
                                'conditional' => [
                                    'field' => 'kpf_sec_remove_commenting',
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
                                'id'    => 'kpf_img_allow_svg',
                                'type'  => 'switch',
                                'label' => __( 'Allow SVGs?', 'kpf' ),
                                'description' => __( 'Should we allow SVG images to be uploaded to the media library?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                            ],
                            [
                                'id'    => 'kpf_img_allow_webm',
                                'type'  => 'switch',
                                'label' => __( 'Allow WEBPs?', 'kpf' ),
                                'description' => __( 'Should we allow WEBP imagess to be uploaded to the media library?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                            ],
                            [
                                'id'    => 'kpf_img_allow_convert',
                                'type'  => 'switch',
                                'label' => __( 'Convert Images?', 'kpf' ),
                                'description' => __( 'Should we attempt to convert images uploaded to webp format?', 'kpf' ),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => true,
                            ],
                            [
                                'id'    => 'kpf_img_extra_image_sizes',
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
                                'id' => 'kpf_cont_search_type',
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
                                'id' => 'kpf_cont_revisions',
                                'label' => __('Revisions', 'kpf'),
                                'description' => __('How many revisions shoud be kept?', 'kpf'),
                                'type' => 'number',
                                'default' => 3,
                            ],
                            [
                                'id' => 'kpf_cont_allow_inline_css',
                                'type' => 'switch',
                                'label' => __('Allow Inline CSS?', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id' => 'kpf_cont_inline_css_posttypes',
                                'type' => 'multiselect',
                                'label' => __('Post Types', 'kpf'),
                                'description' => __('This will add a textarea to the post types you select, that will allow you to input inlined CSS.', 'kpf'),
                                'options' => $this -> get_all_post_types(),
                                'size' => 100,
                                'conditional' => [
                                    'field' => 'kpf_cont_inline_css_posttypes',
                                    'value' => true,
                                    'condition' => '==',
                                ],
                            ],
                            [
                                'id' => 'kpf_cont_allow_inline_js',
                                'type' => 'switch',
                                'label' => __('Allow Inline Javascript?', 'kpf'),
                                'on_label'  => __('Yes', 'kpf'),
                                'off_label' => __('No', 'kpf'),
                                'default' => false,
                            ],
                            [
                                'id' => 'kpf_cont_inline_js_posttypes',
                                'type' => 'multiselect',
                                'label' => __('Post Types', 'kpf'),
                                'description' => __('This will add a textarea to the post types you select, that will allow you to input inlined javascript.', 'kpf'),
                                'options' => $this -> get_all_post_types(),
                                'size' => 100,
                                'conditional' => [
                                    'field' => 'kpf_cont_allow_inline_js',
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