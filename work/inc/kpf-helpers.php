<?php
/**
 * Helper Functions
 * 
 * Global helper functions for the theme framework
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package KP Framework
 * 
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

if( ! function_exists( 'kpf_get_option' ) ) {
    /**
     * Get a theme framework option
     * 
     * @param string $key Option key
     * @param mixed $default Default value
     * @return mixed
     */
    function kpf_get_option( string $key, mixed $default = null ): mixed {
        return KPF_Main::get_option( $key, $default );
    }
}

if( ! function_exists( 'kpf_get_framework' ) ) {
    /**
     * Get the current CSS framework
     * 
     * @return string
     */
    function kpf_get_framework(): string {
        if( class_exists( 'KPF_Framework_Loader' ) ) {
            return KPF_Framework_Loader::instance()->get_current_framework();
        }
        return 'none';
    }
}

if( ! function_exists( 'kpf_is_framework' ) ) {
    /**
     * Check if a specific framework is active
     * 
     * @param string $framework Framework key (bootstrap, uikit, tailwind, foundation, bulma)
     * @return bool
     */
    function kpf_is_framework( string $framework ): bool {
        if( class_exists( 'KPF_Framework_Loader' ) ) {
            return KPF_Framework_Loader::instance()->is_framework_active( $framework );
        }
        return false;
    }
}

if( ! function_exists( 'kpf_framework_class' ) ) {
    /**
     * Get framework-specific CSS classes
     * 
     * Maps common class purposes to framework-specific class names
     * 
     * @param string $purpose Class purpose (container, row, col, btn, etc.)
     * @param array $options Additional options
     * @return string
     */
    function kpf_framework_class( string $purpose, array $options = [] ): string {
        $framework = kpf_get_framework();
        
        $class_map = [
            'bootstrap' => [
                'container' => 'container',
                'container-fluid' => 'container-fluid',
                'row' => 'row',
                'col' => 'col',
                'col-12' => 'col-12',
                'col-6' => 'col-md-6',
                'col-4' => 'col-md-4',
                'col-3' => 'col-md-3',
                'btn' => 'btn',
                'btn-primary' => 'btn btn-primary',
                'btn-secondary' => 'btn btn-secondary',
                'card' => 'card',
                'card-body' => 'card-body',
                'form-control' => 'form-control',
                'form-group' => 'mb-3',
                'nav' => 'nav',
                'nav-item' => 'nav-item',
                'nav-link' => 'nav-link',
                'alert' => 'alert',
                'alert-success' => 'alert alert-success',
                'alert-danger' => 'alert alert-danger',
                'alert-warning' => 'alert alert-warning',
                'hidden' => 'd-none',
                'text-center' => 'text-center',
                'text-left' => 'text-start',
                'text-right' => 'text-end',
            ],
            'uikit' => [
                'container' => 'uk-container',
                'container-fluid' => 'uk-container uk-container-expand',
                'row' => 'uk-grid',
                'col' => 'uk-width-1-1',
                'col-12' => 'uk-width-1-1',
                'col-6' => 'uk-width-1-2@m',
                'col-4' => 'uk-width-1-3@m',
                'col-3' => 'uk-width-1-4@m',
                'btn' => 'uk-button uk-button-default',
                'btn-primary' => 'uk-button uk-button-primary',
                'btn-secondary' => 'uk-button uk-button-secondary',
                'card' => 'uk-card uk-card-default',
                'card-body' => 'uk-card-body',
                'form-control' => 'uk-input',
                'form-group' => 'uk-margin',
                'nav' => 'uk-nav',
                'nav-item' => '',
                'nav-link' => '',
                'alert' => 'uk-alert',
                'alert-success' => 'uk-alert uk-alert-success',
                'alert-danger' => 'uk-alert uk-alert-danger',
                'alert-warning' => 'uk-alert uk-alert-warning',
                'hidden' => 'uk-hidden',
                'text-center' => 'uk-text-center',
                'text-left' => 'uk-text-left',
                'text-right' => 'uk-text-right',
            ],
            'tailwind' => [
                'container' => 'container mx-auto px-4',
                'container-fluid' => 'w-full px-4',
                'row' => 'flex flex-wrap -mx-4',
                'col' => 'w-full px-4',
                'col-12' => 'w-full px-4',
                'col-6' => 'w-full md:w-1/2 px-4',
                'col-4' => 'w-full md:w-1/3 px-4',
                'col-3' => 'w-full md:w-1/4 px-4',
                'btn' => 'px-4 py-2 rounded',
                'btn-primary' => 'px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700',
                'btn-secondary' => 'px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700',
                'card' => 'bg-white rounded-lg shadow',
                'card-body' => 'p-6',
                'form-control' => 'w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500',
                'form-group' => 'mb-4',
                'nav' => 'flex',
                'nav-item' => '',
                'nav-link' => 'px-3 py-2',
                'alert' => 'p-4 rounded',
                'alert-success' => 'p-4 bg-green-100 text-green-800 rounded',
                'alert-danger' => 'p-4 bg-red-100 text-red-800 rounded',
                'alert-warning' => 'p-4 bg-yellow-100 text-yellow-800 rounded',
                'hidden' => 'hidden',
                'text-center' => 'text-center',
                'text-left' => 'text-left',
                'text-right' => 'text-right',
            ],
            'foundation' => [
                'container' => 'grid-container',
                'container-fluid' => 'grid-container fluid',
                'row' => 'grid-x grid-margin-x',
                'col' => 'cell',
                'col-12' => 'cell small-12',
                'col-6' => 'cell small-12 medium-6',
                'col-4' => 'cell small-12 medium-4',
                'col-3' => 'cell small-12 medium-3',
                'btn' => 'button',
                'btn-primary' => 'button primary',
                'btn-secondary' => 'button secondary',
                'card' => 'card',
                'card-body' => 'card-section',
                'form-control' => '',
                'form-group' => '',
                'nav' => 'menu',
                'nav-item' => '',
                'nav-link' => '',
                'alert' => 'callout',
                'alert-success' => 'callout success',
                'alert-danger' => 'callout alert',
                'alert-warning' => 'callout warning',
                'hidden' => 'hide',
                'text-center' => 'text-center',
                'text-left' => 'text-left',
                'text-right' => 'text-right',
            ],
            'bulma' => [
                'container' => 'container',
                'container-fluid' => 'container is-fluid',
                'row' => 'columns',
                'col' => 'column',
                'col-12' => 'column is-12',
                'col-6' => 'column is-6',
                'col-4' => 'column is-4',
                'col-3' => 'column is-3',
                'btn' => 'button',
                'btn-primary' => 'button is-primary',
                'btn-secondary' => 'button is-link',
                'card' => 'card',
                'card-body' => 'card-content',
                'form-control' => 'input',
                'form-group' => 'field',
                'nav' => 'navbar-menu',
                'nav-item' => 'navbar-item',
                'nav-link' => '',
                'alert' => 'notification',
                'alert-success' => 'notification is-success',
                'alert-danger' => 'notification is-danger',
                'alert-warning' => 'notification is-warning',
                'hidden' => 'is-hidden',
                'text-center' => 'has-text-centered',
                'text-left' => 'has-text-left',
                'text-right' => 'has-text-right',
            ],
            'materialize' => [
                'container'    => 'container',
                'row'          => 'row',
                'col'          => 'col',
                'btn'          => 'btn',
                'btn-primary'  => 'btn',
                'btn-secondary'=> 'btn grey',
                'btn-success'  => 'btn green',
                'btn-danger'   => 'btn red',
                'btn-warning'  => 'btn orange',
                'btn-info'     => 'btn blue',
                'card'         => 'card',
                'card-body'    => 'card-content',
                'card-title'   => 'card-title',
                'form-control' => 'input-field',
                'form-group'   => 'input-field',
                'alert'        => 'card-panel',
                'alert-success'=> 'card-panel green lighten-4',
                'alert-danger' => 'card-panel red lighten-4',
                'alert-warning'=> 'card-panel orange lighten-4',
                'alert-info'   => 'card-panel blue lighten-4',
                'nav'          => 'nav-wrapper',
                'navbar'       => 'navbar-fixed',
                'modal'        => 'modal',
                'modal-dialog' => '',
                'modal-content'=> 'modal-content',
                'modal-header' => '',
                'modal-body'   => 'modal-content',
                'modal-footer' => 'modal-footer',
                'table'        => 'striped',
                'img-fluid'    => 'responsive-img',
                'text-center'  => 'center-align',
                'text-left'    => 'left-align',
                'text-right'   => 'right-align',
                'd-none'       => 'hide',
                'd-block'      => 'show',
            ],
            'none' => [
                // Return empty strings for no framework
                'container' => '',
                'container-fluid' => '',
                'row' => '',
                'col' => '',
                'col-12' => '',
                'col-6' => '',
                'col-4' => '',
                'col-3' => '',
                'btn' => '',
                'btn-primary' => '',
                'btn-secondary' => '',
                'card' => '',
                'card-body' => '',
                'form-control' => '',
                'form-group' => '',
                'nav' => '',
                'nav-item' => '',
                'nav-link' => '',
                'alert' => '',
                'alert-success' => '',
                'alert-danger' => '',
                'alert-warning' => '',
                'hidden' => '',
                'text-center' => '',
                'text-left' => '',
                'text-right' => '',
            ],
        ];

        // Allow filtering of class map
        $class_map = apply_filters( 'kpf_framework_class_map', $class_map, $framework );

        return $class_map[ $framework ][ $purpose ] ?? '';
    }
}

if( ! function_exists( 'kpf_container' ) ) {
    /**
     * Output a container opening tag
     * 
     * @param bool $fluid Whether to use fluid container
     * @param string $extra_classes Additional classes
     * @param bool $echo Whether to echo or return
     * @return string
     */
    function kpf_container( bool $fluid = false, string $extra_classes = '', bool $echo = true ): string {
        $class = $fluid ? kpf_framework_class( 'container-fluid' ) : kpf_framework_class( 'container' );
        $class .= $extra_classes ? ' ' . $extra_classes : '';
        $class = trim( $class );
        
        $html = '<div' . ( $class ? ' class="' . esc_attr( $class ) . '"' : '' ) . '>';
        
        if( $echo ) {
            echo $html;
        }
        
        return $html;
    }
}

if( ! function_exists( 'kpf_container_end' ) ) {
    /**
     * Output a container closing tag
     * 
     * @param bool $echo Whether to echo or return
     * @return string
     */
    function kpf_container_end( bool $echo = true ): string {
        $html = '</div>';
        
        if( $echo ) {
            echo $html;
        }
        
        return $html;
    }
}

if( ! function_exists( 'kpf_row' ) ) {
    /**
     * Output a row opening tag
     * 
     * @param string $extra_classes Additional classes
     * @param bool $echo Whether to echo or return
     * @return string
     */
    function kpf_row( string $extra_classes = '', bool $echo = true ): string {
        $class = kpf_framework_class( 'row' );
        $class .= $extra_classes ? ' ' . $extra_classes : '';
        $class = trim( $class );

        // UIKit needs uk-grid attribute
        $attrs = '';
        if( kpf_is_framework( 'uikit' ) ) {
            $attrs = ' uk-grid';
        }
        
        $html = '<div' . ( $class ? ' class="' . esc_attr( $class ) . '"' : '' ) . $attrs . '>';
        
        if( $echo ) {
            echo $html;
        }
        
        return $html;
    }
}

if( ! function_exists( 'kpf_row_end' ) ) {
    /**
     * Output a row closing tag
     * 
     * @param bool $echo Whether to echo or return
     * @return string
     */
    function kpf_row_end( bool $echo = true ): string {
        $html = '</div>';
        
        if( $echo ) {
            echo $html;
        }
        
        return $html;
    }
}

if( ! function_exists( 'kpf_col' ) ) {
    /**
     * Output a column opening tag
     * 
     * @param int $size Column size (12, 6, 4, 3, or 0 for auto)
     * @param string $extra_classes Additional classes
     * @param bool $echo Whether to echo or return
     * @return string
     */
    function kpf_col( int $size = 0, string $extra_classes = '', bool $echo = true ): string {
        $class_key = $size > 0 ? 'col-' . $size : 'col';
        $class = kpf_framework_class( $class_key );
        $class .= $extra_classes ? ' ' . $extra_classes : '';
        $class = trim( $class );
        
        $html = '<div' . ( $class ? ' class="' . esc_attr( $class ) . '"' : '' ) . '>';
        
        if( $echo ) {
            echo $html;
        }
        
        return $html;
    }
}

if( ! function_exists( 'kpf_col_end' ) ) {
    /**
     * Output a column closing tag
     * 
     * @param bool $echo Whether to echo or return
     * @return string
     */
    function kpf_col_end( bool $echo = true ): string {
        $html = '</div>';
        
        if( $echo ) {
            echo $html;
        }
        
        return $html;
    }
}

if( ! function_exists( 'kpf_btn_class' ) ) {
    /**
     * Get button classes
     * 
     * @param string $type Button type (primary, secondary, etc.)
     * @param string $extra_classes Additional classes
     * @return string
     */
    function kpf_btn_class( string $type = 'primary', string $extra_classes = '' ): string {
        $class = kpf_framework_class( 'btn-' . $type );
        if( ! $class ) {
            $class = kpf_framework_class( 'btn' );
        }
        $class .= $extra_classes ? ' ' . $extra_classes : '';
        return trim( $class );
    }
}

if( ! function_exists( 'kpf_alert' ) ) {
    /**
     * Output an alert/notification
     * 
     * @param string $message Alert message
     * @param string $type Alert type (success, danger, warning)
     * @param bool $dismissible Whether alert is dismissible
     * @param bool $echo Whether to echo or return
     * @return string
     */
    function kpf_alert( string $message, string $type = 'success', bool $dismissible = true, bool $echo = true ): string {
        $class = kpf_framework_class( 'alert-' . $type );
        $framework = kpf_get_framework();
        
        $html = '<div class="' . esc_attr( $class ) . '"';
        
        // Framework-specific attributes
        if( $framework === 'uikit' && $dismissible ) {
            $html .= ' uk-alert';
        }
        
        $html .= '>';
        
        // Dismissible button
        if( $dismissible ) {
            switch( $framework ) {
                case 'bootstrap':
                    $html .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    break;
                case 'uikit':
                    $html .= '<a href class="uk-alert-close" uk-close></a>';
                    break;
                case 'bulma':
                    $html .= '<button class="delete"></button>';
                    break;
            }
        }
        
        $html .= wp_kses_post( $message );
        $html .= '</div>';
        
        if( $echo ) {
            echo $html;
        }
        
        return $html;
    }
}