<?php

use WP_CLI\Formatter;
use WP_CLI\Utils;

/**
 * Shows WordPress Health Check.
 *
 * ## EXAMPLES
 *
 *     # Output the site health.
 *     $ wp site-health check
 *     +----------------------------------+-------------+-------------+
 *     | check                            | type        | status      |
 *     +----------------------------------+-------------+-------------+
 *     | WordPress Version                | Performance | good        |
 *     | Plugin Version                   | Security    | good        |
 *     | REST API Availability            | Performance | recommended |
 *     | Communication with WordPress.org | Security    | good        |
 *     +----------------------------------+-------------+-------------+
 *
 *     # Output the health status.
 *     $ wp site-health status
 *
 * @package wp-cli
 *
 */
class Site_Health_Command extends WP_CLI_Command {

	/**
	 * WP Site Health instance.
	 *
	 * @var WP_Site_Health
	 */
	protected $fetcher;

	/**
	 * Site_Health_Command constructor.
	 */
	public function __construct() {
		$this->fetcher = WP_Site_Health::get_instance();
	}

	/**
	 * Runs checks on WordPress.
	 *
	 * [--field=<field>]
	 * : Only show the provided field.
	 *
	 * [--format=<format>]
	 * : Render output in a particular format.
	 * ---
	 * default: table
	 * options:
	 *   - table
	 *   - csv
	 *   - json
	 *   - yaml
	 *   - count
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *     # Runs a health check and outputs the result.
	 *     $ wp site-health check
	 *     +----------------------------------+-------------+-------------+
	 *     | check                            | type        | status      |
	 *     +----------------------------------+-------------+-------------+
	 *     | WordPress Version                | Performance | good        |
	 *     | Plugin Version                   | Security    | good        |
	 *     | REST API Availability            | Performance | recommended |
	 *     | Communication with WordPress.org | Security    | good        |
	 *     +----------------------------------+-------------+-------------+
	 */
	public function check( $_, $assoc_args ) {
		$instance = $this->fetcher;

		$wordpress_version = $instance->get_test_wordpress_version();

		$results[] = [
			'check'   => 'WordPress Version',
			'type'   => $wordpress_version['badge']['label'],
			'status' => $wordpress_version['status']
		];

		$plugins_version = $instance->get_test_plugin_version();

		$results[] = [
			'check'   => 'Plugin Version',
			'type'   => $plugins_version['badge']['label'],
			'status' => $plugins_version['status']
		];

		$rest_availability = $instance->get_test_rest_availability();

		$results[] = [
			'check'   => 'REST API Availability',
			'type'   => $rest_availability['badge']['label'],
			'status' => $rest_availability['status']
		];

		$dotorg_communication = $instance->get_test_dotorg_communication();

		$results[] = [
			'check'   => 'Communication with WordPress.org',
			'type'   => $dotorg_communication['badge']['label'],
			'status' => $dotorg_communication['status']
		];

		$formatter = new Formatter( $assoc_args, [ 'check', 'type', 'status' ] );
		$formatter->display_items( $results );
	}
}