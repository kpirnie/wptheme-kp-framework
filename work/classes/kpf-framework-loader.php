<?php
/** 
 * 
 * Framework Loader Class
 * 
 * Handles loading the selected CSS framework from CDN or locally
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
if( ! class_exists( 'KPF_Framework_Loader' ) ) {

    /** 
     * KPF_Framework_Loader
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
    */
    class KPF_Framework_Loader {

        /**
         * Initialize
         * @var bool
         */
        private bool $initialized = false;

        /**
         * Settings
         * @var array
         */
        private array $settings = [];

        /**
         * Framework configurations
         * @var array
         */
        private array $frameworks = [];

        /**
         * Class constructor.
         * 
         * Setup the object
         * 
         * @internal
         */
        public function __construct() {

            // hold the internals
            $this -> settings = [];
            $this -> frameworks = [];

            // initialize us
            $this -> init( );
        }

        /**
         * Class destructor.
         * 
         * Cleans up internal state and releases resources.
         * 
         * @internal
         */
        public function __destruct() {

            // clean up the internals
            unset( $this->settings, $this->frameworks );
        }

        /**
         * enqueue_framework
         * 
         * Enqueue the selected framework
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access public
         * 
         * @return void Returns nothing
         */
        public function enqueue_framework(): void {

            // Fire action before framework is enqueued
            do_action( 'kpf_before_framework_enqueue' );

            $framework = $this->settings['css_framework'];

            // Exit if no framework selected
            if( $framework === 'none' || ! isset( $this->frameworks[ $framework ] ) ) {
                return;
            }

            $config = $this->frameworks[ $framework ];
            $version = $this->get_resolved_version( $framework );
            $use_cdn = $this->settings['load_from_cdn'];
            $load_js = $this->settings['load_framework_js'];
            $custom_cdn = $this->settings['custom_cdn_url'];

            // Handle Tailwind CSS specially
            if( $framework === 'tailwind' ) {
                $this->enqueue_tailwind( $config, $use_cdn );
                return;
            }

            // Enqueue CSS
            $css_url = $this->get_asset_url( $config, 'css', $version, $custom_cdn, $use_cdn );
            if( $css_url ) {
                $integrity = $this->get_integrity( $framework, $version, 'css' );
                wp_enqueue_style(
                    'kpf-' . $config['handle'],
                    $css_url,
                    [],
                    $use_cdn ? null : $version
                );

                // Add integrity and crossorigin attributes for CDN resources
                if( $use_cdn && $integrity ) {
                    add_filter( 'style_loader_tag', function( $tag, $handle ) use ( $config, $integrity ) {
                        if( $handle === 'kpf-' . $config['handle'] ) {
                            $tag = str_replace(
                                ' href=',
                                ' integrity="' . esc_attr( $integrity ) . '" crossorigin="anonymous" href=',
                                $tag
                            );
                        }
                        return $tag;
                    }, 10, 2 );
                }
            }

            // Enqueue JS if enabled and available
            if( $load_js ) {
                $js_url = $this->get_asset_url( $config, 'js', $version, $custom_cdn, $use_cdn );
                if( $js_url ) {
                    $deps = $config['dependencies']['js'] ?? [];
                    $integrity = $this->get_integrity( $framework, $version, 'js' );
                    
                    wp_enqueue_script(
                        'kpf-' . $config['handle'],
                        $js_url,
                        $deps,
                        $use_cdn ? null : $version,
                        true
                    );

                    // Add integrity and crossorigin attributes for CDN resources
                    if( $use_cdn && $integrity ) {
                        add_filter( 'script_loader_tag', function( $tag, $handle ) use ( $config, $integrity ) {
                            if( $handle === 'kpf-' . $config['handle'] ) {
                                $tag = str_replace(
                                    ' src=',
                                    ' integrity="' . esc_attr( $integrity ) . '" crossorigin="anonymous" src=',
                                    $tag
                                );
                            }
                            return $tag;
                        }, 10, 2 );
                    }

                    // Load UIKit icons if UIKit
                    if( $framework === 'uikit' && isset( $config['cdn']['icons'] ) ) {
                        $icons_url = str_replace( '{version}', $version, $config['cdn']['icons'] );
                        wp_enqueue_script(
                            'kpf-uikit-icons',
                            $icons_url,
                            [ 'kpf-uikit' ],
                            null,
                            true
                        );
                    }
                }
            }

            // Fire action after framework is enqueued
            do_action( 'kpf_after_framework_enqueue', $framework, $config, $version );
        }

        /**
         * get_current_framework
         * 
         * Get the current selected framework
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access public
         * 
         * @return string Returns the framework name
         */
        public function get_current_framework(): string {
            return $this->settings['css_framework'];
        }

        /**
         * get_framework_config
         * 
         * Get framework configuration
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access public
         * 
         * @param string|null $framework Framework key (null for current)
         * @return array|null
         */
        public function get_framework_config( ?string $framework = null ): ?array {
            $framework = $framework ?? $this->settings['css_framework'];
            return $this->frameworks[ $framework ] ?? null;
        }

        /**
         * is_framework_active
         * 
         * Check if a specific framework is active
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access public
         * 
         * @param string $framework Framework key
         * @return bool Returns if the specific framework is active ot not
         */
        public function is_framework_active( string $framework ): bool {
            return $this->settings['css_framework'] === $framework;
        }

        /**
         * get_available_frameworks
         * 
         * Get all available frameworks
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access public
         * 
         * @return array Returns the array of all available frameworks
         */
        public function get_available_frameworks(): array {
            return array_keys( $this->frameworks );
        }

        /**
         * Initializes or retrieves the instance.
         * 
         * @author Kevin Pirnie <iam@kevinpirnie.com>
         * @copyright 2025 Kevin Pirnie
         * 
         * @since 1.0.1
         * @package KP Theme Framework
         * @access private
         * 
         * @return self Returns $this for method chaining
         * @internal
         */
        private function init(): self {

            // if we're already initialized
            if ($this->initialized) {
                return $this;
            }

            // load up the internal settings and the internal framework
            $this->load_settings( );
            $this->setup_frameworks( );

            // return the initialized object
            return $this;
        }

        /**
         * Load settings from database
         * 
         * @return void
         */
        private function load_settings(): void {

            $defaults = [
                'css_framework' => 'none',
                'framework_version' => 'latest',
                'load_from_cdn' => true,
                'load_framework_js' => true,
                'custom_cdn_url' => '',
            ];

            $this->settings = wp_parse_args(
                get_kpf_option( 'kpf_theme_settings', [] ),
                $defaults
            );
        }

        /**
         * Setup framework configurations
         * 
         * @return void
         */
        private function setup_frameworks(): void {
            $this->frameworks = [
                'bootstrap' => [
                    'name' => 'Bootstrap',
                    'handle' => 'bootstrap',
                    'versions' => [
                        'latest' => '5.3.3',
                        '5.3' => '5.3.3',
                        '5.2' => '5.2.3',
                        '5.1' => '5.1.3',
                        '5.0' => '5.0.2',
                    ],
                    'cdn' => [
                        'css' => 'https://cdn.jsdelivr.net/npm/bootstrap@{version}/dist/css/bootstrap.min.css',
                        'js' => 'https://cdn.jsdelivr.net/npm/bootstrap@{version}/dist/js/bootstrap.bundle.min.js',
                    ],
                    'integrity' => [
                        '5.3.3' => [
                            'css' => 'sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH',
                            'js' => 'sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz',
                        ],
                    ],
                    'dependencies' => [
                        'js' => [],
                    ],
                ],
                'uikit' => [
                    'name' => 'UIKit',
                    'handle' => 'uikit',
                    'versions' => [
                        'latest' => '3.21.6',
                        '3.21' => '3.21.6',
                        '3.20' => '3.20.8',
                        '3.19' => '3.19.4',
                    ],
                    'cdn' => [
                        'css' => 'https://cdn.jsdelivr.net/npm/uikit@{version}/dist/css/uikit.min.css',
                        'js' => 'https://cdn.jsdelivr.net/npm/uikit@{version}/dist/js/uikit.min.js',
                        'icons' => 'https://cdn.jsdelivr.net/npm/uikit@{version}/dist/js/uikit-icons.min.js',
                    ],
                    'dependencies' => [
                        'js' => [],
                    ],
                ],
                'tailwind' => [
                    'name' => 'Tailwind CSS',
                    'handle' => 'tailwindcss',
                    'versions' => [
                        'latest' => '3.4.17',
                        '3.4' => '3.4.17',
                        '3.3' => '3.3.6',
                    ],
                    'cdn' => [
                        // For development/CDN usage - uses the Play CDN
                        'js' => 'https://cdn.tailwindcss.com',
                        // For production, use local build
                        'css' => '', // Built locally via npm
                    ],
                    'play_cdn' => true, // Indicates this uses the Play CDN approach
                    'dependencies' => [
                        'js' => [],
                    ],
                ],
                'foundation' => [
                    'name' => 'Foundation',
                    'handle' => 'foundation',
                    'versions' => [
                        'latest' => '6.8.1',
                        '6.8' => '6.8.1',
                        '6.7' => '6.7.5',
                        '6.6' => '6.6.3',
                    ],
                    'cdn' => [
                        'css' => 'https://cdn.jsdelivr.net/npm/foundation-sites@{version}/dist/css/foundation.min.css',
                        'js' => 'https://cdn.jsdelivr.net/npm/foundation-sites@{version}/dist/js/foundation.min.js',
                    ],
                    'dependencies' => [
                        'js' => [ 'jquery' ],
                    ],
                ],
                'bulma' => [
                    'name' => 'Bulma',
                    'handle' => 'bulma',
                    'versions' => [
                        'latest' => '1.0.2',
                        '1.0' => '1.0.2',
                        '0.9' => '0.9.4',
                    ],
                    'cdn' => [
                        'css' => 'https://cdn.jsdelivr.net/npm/bulma@{version}/css/bulma.min.css',
                        'js' => '', // Bulma is CSS-only
                    ],
                    'dependencies' => [
                        'js' => [],
                    ],
                ],
				'materialize' => [
					'name' => 'Materialize',
					'handle' => 'materialize',
					'versions' => [
						'latest' => '1.0.0',
						'1.0' => '1.0.0',
						'0.100.2' => '0.100.2',
						
					],
					'cdn' => [
						'css' => 'https://cdn.jsdelivr.net/npm/materialize-css@{version}/dist/css/materialize.min.css',
						'js' => 'https://cdn.jsdelivr.net/npm/materialize-css@{version}/dist/js/materialize.min.js',
					],
					'integrity' => [
						'1.0.0' => [
							'css' => 'sha512-4Eb8jXMc9aCLcGPmH7YLpOO0f7C4RdJj5x8Y7hW8yPLgRGUA3M1dI5dczPqfvGOCTGp8m3UhIg5FY0GNWG0XHw==',
							'js' => 'sha512-O2RDsJcXfXVzplRMHm6zuGuW1YkXVl3KTNrXJN4ZY4H0rNk6Y3T4lLDn3ENYTI4r1NIedNzthVQN/0GwMN9CIg==',
						],
					],
					'dependencies' => [
						'js' => [],
					],
				],
            ];

            // Allow filtering of framework configurations
            $this->frameworks = apply_filters( 'kpf_framework_configurations', $this->frameworks );
        }

        /**
         * Enqueue Tailwind CSS
         * 
         * @param array $config Framework configuration
         * @param bool $use_cdn Whether to use CDN
         * @return void
         */
        private function enqueue_tailwind( array $config, bool $use_cdn ): void {

            if( $use_cdn ) {
                // Use Tailwind Play CDN for development
                wp_enqueue_script(
                    'kpf-tailwindcss-cdn',
                    'https://cdn.tailwindcss.com',
                    [],
                    null,
                    false // Load in head
                );

                // Add Tailwind config inline
                $tailwind_config = $this->get_tailwind_config();
                if( $tailwind_config ) {
                    wp_add_inline_script(
                        'kpf-tailwindcss-cdn',
                        'tailwind.config = ' . wp_json_encode( $tailwind_config ) . ';',
                        'after'
                    );
                }

                // Add warning for development usage
                if( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                    wp_add_inline_script(
                        'kpf-tailwindcss-cdn',
                        'console.warn("KPF: Tailwind CSS Play CDN is being used. For production, use the build process.");',
                        'after'
                    );
                }
            } else {
                // For production, expect a built CSS file
                $local_css = KPF_PATH . '/assets/css/tailwind.css';
                if( file_exists( $local_css ) ) {
                    wp_enqueue_style(
                        'kpf-tailwindcss',
                        KPF_ASSETS_URL . '/assets/css/tailwind.css',
                        [],
                        KPF_VERSION
                    );
                }
            }

            do_action( 'kpf_after_tailwind_enqueue', $use_cdn );
        }

        /**
         * Get Tailwind configuration for Play CDN
         * 
         * @return array
         */
        private function get_tailwind_config(): array {
            $config = [
                'theme' => [
                    'extend' => [],
                ],
            ];

            // Allow filtering of Tailwind config
            return apply_filters( 'kpf_tailwind_config', $config );
        }

        /**
         * Get resolved version number
         * 
         * @param string $framework Framework key
         * @return string
         */
        private function get_resolved_version( string $framework ): string {
            $requested = $this->settings['framework_version'];
            $versions = $this->frameworks[ $framework ]['versions'] ?? [];

            // If specific version requested and exists, use it
            if( isset( $versions[ $requested ] ) ) {
                return $versions[ $requested ];
            }

            // If 'latest' or not found, return latest
            return $versions['latest'] ?? '1.0.0';
        }

        /**
         * Get asset URL
         * 
         * @param array $config Framework configuration
         * @param string $type Asset type (css or js)
         * @param string $version Version number
         * @param string $custom_cdn Custom CDN URL
         * @param bool $use_cdn Whether to use CDN
         * @return string
         */
        private function get_asset_url( array $config, string $type, string $version, string $custom_cdn, bool $use_cdn ): string {
            if( empty( $config['cdn'][ $type ] ) ) {
                return '';
            }

            if( $use_cdn ) {
                if( $custom_cdn ) {
                    // Use custom CDN URL
                    $extension = $type === 'css' ? 'css' : 'js';
                    return trailingslashit( $custom_cdn ) . $config['handle'] . '.' . $extension;
                }

                // Use default CDN URL with version replacement
                return str_replace( '{version}', $version, $config['cdn'][ $type ] );
            }

            // Local files - check if they exist
            $local_path = KPF_PATH . '/assets/' . $type . '/' . $config['handle'] . '.' . $type;
            if( file_exists( $local_path ) ) {
                return KPF_ASSETS_URL . '/' . $type . '/' . $config['handle'] . '.' . $type;
            }

            return '';
        }

        /**
         * Get integrity hash for SRI
         * 
         * @param string $framework Framework key
         * @param string $version Version number
         * @param string $type Asset type (css or js)
         * @return string
         */
        private function get_integrity( string $framework, string $version, string $type ): string {
            return $this->frameworks[ $framework ]['integrity'][ $version ][ $type ] ?? '';
        }

    }

}