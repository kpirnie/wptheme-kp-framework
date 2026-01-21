<?php
/**
 * Imagery Module Settings
 * 
 * Handles the imagery settings tab
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
if( ! class_exists( 'KPF_Module_Imagery_Settings' ) ) {

    /**
     * Class KPF_Module_Imagery_Settings
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_Module_Imagery_Settings extends KPF_Module_Base {

        /**
         * get_tab_config
         * 
         * Returns the tab configuration for the imagery module
         * 
         * @return array The tab configuration
         */
        public function get_tab_config( ): array {

            return [
                'title'    => __( 'Imagery', 'kpf' ),
                'sections' => [
                    'imagery' => [
                        'fields' => $this->get_fields( ),
                    ],
                ],
            ];

        }

        /**
         * get_fields
         * 
         * Returns the imagery settings fields
         * 
         * @access private
         * 
         * @return array The fields configuration
         */
        private function get_fields( ): array {

            return [
                $this->get_svg_field( ),
                $this->get_webp_field( ),
                $this->get_convert_field( ),
                $this->get_extra_sizes_field( ),
            ];

        }

        /**
         * get_svg_field
         * 
         * Returns the SVG upload field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_svg_field( ): array {

            return [
                'id'          => 'kpf_img_allow_svg',
                'type'        => 'switch',
                'label'       => __( 'Allow SVGs?', 'kpf' ),
                'description' => __( 'Should we allow SVG images to be uploaded to the media library?', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => true,
            ];

        }

        /**
         * get_webp_field
         * 
         * Returns the WEBP upload field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_webp_field( ): array {

            return [
                'id'          => 'kpf_img_allow_webp',
                'type'        => 'switch',
                'label'       => __( 'Allow WEBPs?', 'kpf' ),
                'description' => __( 'Should we allow WEBP images to be uploaded to the media library?', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => true,
            ];

        }

        /**
         * get_convert_field
         * 
         * Returns the image conversion field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_convert_field( ): array {

            return [
                'id'          => 'kpf_img_allow_convert',
                'type'        => 'switch',
                'label'       => __( 'Convert Images?', 'kpf' ),
                'description' => __( 'Should we attempt to convert images uploaded to webp format?', 'kpf' ),
                'on_label'    => __( 'Yes', 'kpf' ),
                'off_label'   => __( 'No', 'kpf' ),
                'default'     => false,
            ];

        }

        /**
         * get_extra_sizes_field
         * 
         * Returns the extra image sizes repeater field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_extra_sizes_field( ): array {

            return [
                'id'          => 'kpf_img_extra_image_sizes',
                'type'        => 'repeater',
                'label'       => __( 'Extra Image Sizes', 'kpf' ),
                'sublabel'    => __( 'Existing Sizes:<br />' . $this->get_current_image_sizes( ), 'kpf' ),
                'description' => __( 'This will add additional image sizes. WordPress will automagically create them on upload.<br /><strong>NOTE: </strong>If you already have images uploaded, you will need to regenerate your thumbnails.', 'kpf' ),
                'fields'      => [
                    $this->get_size_name_field( ),
                    $this->get_dimensions_group_field( ),
                ],
            ];

        }

        /**
         * get_size_name_field
         * 
         * Returns the size name field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_size_name_field( ): array {

            return [
                'id'    => 'kpf_img_size_name',
                'type'  => 'text',
                'label' => __( 'Size Name', 'kpf' ),
            ];

        }

        /**
         * get_dimensions_group_field
         * 
         * Returns the dimensions group field configuration
         * 
         * @access private
         * 
         * @return array The field configuration
         */
        private function get_dimensions_group_field( ): array {

            return [
                'id'     => 'kpf_img_dimensions',
                'type'   => 'group',
                'fields' => [
                    [
                        'id'       => 'kpf_img_width',
                        'type'     => 'text',
                        'label'    => __( 'Image Width', 'kpf' ),
                        'sublabel' => __( 'in pixels', 'kpf' ),
                    ],
                    [
                        'id'       => 'kpf_img_height',
                        'type'     => 'text',
                        'label'    => __( 'Image Height', 'kpf' ),
                        'sublabel' => __( 'in pixels', 'kpf' ),
                    ],
                    [
                        'id'      => 'kpf_img_crop_vert',
                        'type'    => 'radio',
                        'label'   => __( 'Crop Vertical', 'kpf' ),
                        'options' => [
                            0 => __( 'None', 'kpf' ),
                            1 => __( 'Top', 'kpf' ),
                            2 => __( 'Center', 'kpf' ),
                            3 => __( 'Bottom', 'kpf' ),
                        ],
                        'default' => 0,
                    ],
                    [
                        'id'      => 'kpf_img_crop_horz',
                        'type'    => 'radio',
                        'label'   => __( 'Crop Horizontal', 'kpf' ),
                        'options' => [
                            0 => __( 'None', 'kpf' ),
                            1 => __( 'Left', 'kpf' ),
                            2 => __( 'Center', 'kpf' ),
                            3 => __( 'Right', 'kpf' ),
                        ],
                        'default' => 0,
                    ],
                ],
            ];

        }

    }

}