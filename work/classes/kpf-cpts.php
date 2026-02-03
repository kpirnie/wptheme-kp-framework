<?php

/**
 * Custom Post Types
 * 
 * Handles the custom post type creation
 * 
 * @author Kevin Pirnie <iam@kevinpirnie.com>
 * @copyright 2025 Kevin Pirnie
 * 
 * @since 1.0.1
 * @package KP Theme Framework
 * 
 */

// We don't want to allow direct access to this
defined('ABSPATH') || die('No direct script access allowed');

// pull our field framework
use \KP\WPFieldFramework\Loader;

// make sure we aren't loading in the class multiple times
if (! class_exists('KPF_CPTs')) {

    /**
     * Class KPF_CPTs
     * 
     * @author Kevin Pirnie <iam@kevinpirnie.com>
     * @copyright 2025 Kevin Pirnie
     * 
     * @since 1.0.1
     * @package KP Theme Framework
     * @access public
     * 
     */
    class KPF_CPTs
    {

        /**
         * The field framework instance
         * 
         * @var \KP\WPFieldFramework\Framework|null
         */
        private ?\KP\WPFieldFramework\Framework $fw = null;

        /**
         * Class constructor
         * 
         * Setup the object
         * 
         * @internal
         */
        public function __construct()
        {

            // load up our framework
            $this->fw = Loader::init();
        }


        private function add_heroes(): void {}


        private function add_ctas(): void {}


        private function add_(): void {}
    }
}
