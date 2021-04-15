<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/Merchans/chi-make-certificate
 * @since      1.0.0
 *
 * @package    Chi_Make_Certificate
 * @subpackage Chi_Make_Certificate/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Chi_Make_Certificate
 * @subpackage Chi_Make_Certificate/includes
 * @author     Richard Markovič <addmarkovic@gmail.com>
 */
class Chi_Make_Certificate_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'chi-make-certificate',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
