<?php
/*
Plugin Name: Atomic Smash | Generate Content
Plugin URI: http://www.atomicsmash.co.uk
Description: Generate dummy content
Version: 0.0.1
Author: Atomic Smash
Author URI: http://www.atomicsmash.co.uk
*/
// namespace Faker\Test\Provider;
// namespace Faker\Provider;

require( dirname( __FILE__ ) . '/vendor/autoload.php' );

if (!defined('ABSPATH'))exit; //Exit if accessed directly

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    require __DIR__ . '/lib/generate_posts.php';
    require __DIR__ . '/lib/generate_fields.php';
    require __DIR__ . '/lib/cli.php';

    WP_CLI::add_command( 'generate', 'Generate_Cli' );
}
