<?php
/**
 * Performance Module Settings
 * 
 * Handles the performance settings tab
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
if( ! class_exists( 'KPF_Module_Performance_Settings' ) ) {

    /**
     * Class KPF_Module_Performance_Settings
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_Module_Performance_Settings extends KPF_Module_Base {

        /**
         * get_tab_config
         * 
         * Returns the tab configuration for the performance module
         * 
         * @return array The tab configuration
         */
        public function get_tab_config( ): array {

            return [
                'title'    => __( 'Performance', 'kpf' ),
                'sections' => [
                    'performance' => [
                        'fields' => $this->get_fields( ),
                    ],
                ],
            ];

        }

        /**
         * get_fields
         * 
         * Returns the performance settings fields
         * 
         * @access private
         * 
         * @return array The fields configuration
         */
        private function get_fields( ): array {

            return [
                $this->get_querystrings_field( ),
                $this->get_js_footer_field( ),
                $this->get_defer_js_field( ),
                $this->get_preload_field( ),
                $this->get_instant_page_field( ),
                $this->get_heartbeat_field( ),
                $this->get_emojis_field( ),
            ];

        }

        /**
         * get_querystrings_field
         * 
         * Returns the querystrings removal field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_querystrings_field( ): array {

            return [
                'id'          => 'kpf_perf_remove_qs',
                'type'        => 'switch',
                'label'       => __( 'Remove Querystrings?', 'kpf' ),
                'description' => __( 'This will attempt to remove querystrings from all static resources.', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
            ];

        }

        /**
         * get_js_footer_field
         * 
         * Returns the JS to footer field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_js_footer_field( ): array {

            return [
                'id'          => 'kpf_perf_force_js_footer',
                'type'        => 'switch',
                'label'       => __( 'JS to Footer?', 'kpf' ),
                'description' => __( 'This will attempt to force all javascript resources to load in the site footer.', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
            ];

        }

        /**
         * get_defer_js_field
         * 
         * Returns the defer JS field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_defer_js_field( ): array {

            return [
                'id'          => 'kpf_perf_defer_js',
                'type'        => 'switch',
                'label'       => __( 'Defer JS?', 'kpf' ),
                'description' => __( 'This will attempt to mark all javascript resources as deferred.', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
            ];

        }

        /**
         * get_preload_field
         * 
         * Returns the preload/prerender/prefetch field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_preload_field( ): array {

            return [
                'id'          => 'kpf_perf_apply_pre',
                'type'        => 'switch',
                'label'       => __( 'Apply the Pre\'s?', 'kpf' ),
                'sublabel'    => __( 'Pre-Load, Pre-Render, and Pre-Fetch', 'kpf' ),
                'description' => __( 'This will attempt to inject pre-load, pre-render, and pre-fetch meta-tags for all external resources.', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
            ];

        }

        /**
         * get_instant_page_field
         * 
         * Returns the instant.page field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_instant_page_field( ): array {

            return [
                'id'          => 'kpf_perf_apply_ip',
                'type'        => 'switch',
                'label'       => __( 'Apply instant.page?', 'kpf' ),
                'description' => __( 'This will attempt to inject the instant.page library. See here for more info: <a href="https://instant.page/" target="_blank">https://instant.page/</a>', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
            ];

        }

        /**
         * get_heartbeat_field
         * 
         * Returns the heartbeat field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_heartbeat_field( ): array {

            return [
                'id'          => 'kpf_perf_slow_hb',
                'type'        => 'switch',
                'label'       => __( 'Slow Down Heartbeat?', 'kpf' ),
                'description' => __( 'This will attempt to slow down WordPress\'s heartbeat. This will change it from the default 15 seconds to 300 seconds.', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
            ];

        }

        /**
         * get_emojis_field
         * 
         * Returns the emojis removal field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_emojis_field( ): array {

            return [
                'id'          => 'kpf_perf_remove_emojis',
                'type'        => 'switch',
                'label'       => __( 'Remove Emojis?', 'kpf' ),
                'description' => __( 'This will attempt to remove all WordPress default emoji scripts and stylesheets.', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
            ];

        }

    }

}