<?php
/**
 * Ajax request handelar
 */

use WP_Background_Process as Background_Process;

class WooGool_Admin_Action extends Background_Process {
	/**
	 * @var string
	 */
	protected $action = 'example_process';

	function __construct() {
		
		parent::__construct();
		
		add_action( 'woocommerce_update_product', array( $this, 'product_update' ), 10 ); 
		add_filter( 'cron_schedules', array( $this,'cron_time'), 10, 1 );

		if ( ! wp_next_scheduled( 'woogool_feed_generate' ) ) {
			wp_schedule_event( time(), 'woogool_cron_time', 'woogool_feed_generate' );
		}

		add_action( 'woogool_feed_generate', array( $this, 'set_background_queue' ) );
	}

	public function cron_time( $schedules ) { 
		// $schedules stores all recurrence schedules within WordPress 
		$schedules['woogool_cron_time'] = array( 
			'interval' => 60, // Number of seconds, 600 in 10 minutes
			'display' => 'Once Every 1 Minutes'
		); 
		// Return our newly added schedule to be merged into the others 
		return (array)$schedules; 
	}

	public function set_background_queue() {
		$queue_records = get_option( 'woogool_queue_records', array() );

		foreach ( $queue_records as $product_id => $feeds ) {
			foreach ( $feeds as $key => $feed ) {
				if ( $feed['status'] != 'active' ) {
					continue;
				}

				$this->push_to_queue( array( 
					'product_id' => $product_id,
					'feed_id'    => $feed['feed_id']
				) );
			}
		}
		
		$this->save()->dispatch();
	}

	function product_update( $product_id ) {
		
		$queue_records = get_option( 'woogool_queue_records', array() );
		$feeds         = woogool_get_feeds();
		
		foreach ( $feeds->posts as $key => $feed ) {
			$queue_records[$product_id][$feed->ID] = array (
				'status'     => 'active',
				'feed_id'    => $feed->ID,
				'product_id' => $product_id
			); 
		}
		
		update_option( 'woogool_queue_records', $queue_records );
	}

	function task( $item ) {
		
		$queue_records = get_option( 'woogool_queue_records', array() );
		$product_id    = $item['product_id'];
		$feed_id       = $item['feed_id'];

		if ( empty( $product_id ) || empty( $feed_id ) ) {
			return false;
		}
		
		$admin_feed = WooGool_Admin_Feed::instance();
		$admin_feed->update_feed_file_by_product( $product_id, $feed_id );

		unset( $queue_records[$product_id][$feed_id] );

		if ( empty( $queue_records[$product_id] ) ) {
			unset( $queue_records[$product_id] );
		}

		update_option( 'woogool_queue_records', $queue_records );
		
		return false;
	}

	/**
	 * Complete function for WP_Background_Process
	 *
	 */
	function complete() {
		parent::complete();
		
	}
}