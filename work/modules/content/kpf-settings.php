<?php
/**
 * Content Module Settings
 * 
 * Handles the content settings tab
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
if( ! class_exists( 'KPF_Module_Content_Settings' ) ) {

    /**
     * Class KPF_Module_Content_Settings
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_Module_Content_Settings extends KPF_Module_Base {

        /**
         * get_tab_config
         * 
         * Returns the tab configuration for the content module
         * 
         * @return array The tab configuration
         */
        public function get_tab_config( ): array {

            return [
                'title'    => __( 'Content', 'kpf' ),
                'sections' => [
                    'content' => [
                        'fields' => $this->get_fields( ),
                    ],
                ],
            ];

        }

        /**
         * get_fields
         * 
         * Returns the content settings fields
         * 
         * @access private
         * 
         * @return array The fields configuration
         */
        private function get_fields( ): array {

            return [
                $this->get_search_type_field( ),
                $this->get_revisions_field( ),
                $this->get_inline_css_field( ),
                $this->get_inline_css_posttypes_field( ),
                $this->get_inline_js_field( ),
                $this->get_inline_js_posttypes_field( ),
            ];

        }

        /**
         * get_search_type_field
         * 
         * Returns the search type field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_search_type_field( ): array {

            return [
                'id'      => 'kpf_cont_search_type',
                'type'    => 'radio',
                'label'   => __( 'Search Type', 'kpf' ),
                'inline'  => true,
                'options' => [
                    0 => __( 'Loose (default)', 'kpf' ),
                    1 => __( 'Exact', 'kpf' ),
                    2 => __( 'Sentence', 'kpf' ),
                ],
                'default' => 0,
            ];

        }

        /**
         * get_revisions_field
         * 
         * Returns the revisions field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_revisions_field( ): array {

            return [
                'id'          => 'kpf_cont_revisions',
                'label'       => __( 'Revisions', 'kpf' ),
                'description' => __( 'How many revisions should be kept?', 'kpf' ),
                'type'        => 'number',
                'default'     => 3,
            ];

        }

        /**
         * get_inline_css_field
         * 
         * Returns the inline CSS toggle field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_inline_css_field( ): array {

            return [
                'id'        => 'kpf_cont_allow_inline_css',
                'type'      => 'switch',
                'label'     => __( 'Allow Inline CSS?', 'kpf' ),
                'on_label'  => __( 'Yes', 'kpf' ),
                'off_label' => __( 'No', 'kpf' ),
                'default'   => false,
            ];

        }

        /**
         * get_inline_css_posttypes_field
         * 
         * Returns the inline CSS post types field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_inline_css_posttypes_field( ): array {

            return [
                'id'          => 'kpf_cont_inline_css_posttypes',
                'type'        => 'multiselect',
                'label'       => __( 'Post Types', 'kpf' ),
                'description' => __( 'This will add a textarea to the post types you select, that will allow you to input inlined CSS.', 'kpf' ),
                'options'     => $this->get_all_post_types( ),
                'size'        => 100,
                'conditional' => [
                    'field'     => 'kpf_cont_allow_inline_css',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

        /**
         * get_inline_js_field
         * 
         * Returns the inline JavaScript toggle field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_inline_js_field( ): array {

            return [
                'id'        => 'kpf_cont_allow_inline_js',
                'type'      => 'switch',
                'label'     => __( 'Allow Inline Javascript?', 'kpf' ),
                'on_label'  => __( 'Yes', 'kpf' ),
                'off_label' => __( 'No', 'kpf' ),
                'default'   => false,
            ];

        }

        /**
         * get_inline_js_posttypes_field
         * 
         * Returns the inline JavaScript post types field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_inline_js_posttypes_field( ): array {

            return [
                'id'          => 'kpf_cont_inline_js_posttypes',
                'type'        => 'multiselect',
                'label'       => __( 'Post Types', 'kpf' ),
                'description' => __( 'This will add a textarea to the post types you select, that will allow you to input inlined javascript.', 'kpf' ),
                'options'     => $this->get_all_post_types( ),
                'size'        => 100,
                'conditional' => [
                    'field'     => 'kpf_cont_allow_inline_js',
                    'value'     => true,
                    'condition' => '==',
                ],
            ];

        }

    }

}