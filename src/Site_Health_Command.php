<?php

use WP_CLI\Formatter;
use WP_CLI\Utils;

/**
 * Shows WordPress Health Check data.
 *
 * ## EXAMPLES
 *
 *     # Output the site health.
 *     $ wp site-health check
 *     Success: Database created.
 *
 *     # Output the health status.
 *     $ wp site-health status
 *     Success: Database dropped.
 *
 *
 * @when after_wp_config_load
 */
class Site_Health_Command extends WP_CLI_Command {
	public function check( $_, $assoc_args ) {
		WP_CLI::success( 'Health Check!.' );
	}
}