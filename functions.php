<?php
/** 
 * KP Theme Framework
 * 
 * A modern WordPress parent theme framework with CSS framework selection
 * 
 * @author Kevin Pirnie <iam@kevinpirnie.com>
 * @copyright 2025 Kevin Pirnie
 * 
 * @since 1.0.1
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package KP Theme Framework
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// include the autoloader
include_once dirname( __FILE__ ) . '/vendor/autoload.php';

// initialize the them
KPF_Main::init( );
