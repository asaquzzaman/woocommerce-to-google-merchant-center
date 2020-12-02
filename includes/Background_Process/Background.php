<?php
namespace WOOGOOL\Includes\Background_Process;

use WP_Background_Process;


class Background extends WP_Background_Process {
	/**
	 * Class instance.
	 *
	 * @var Object
	 */
	private static $instance;

	/**
	 * @var string
	 */
	protected $action = 'example_request';

	/**
	 * Instance
	 *
	 * @since 0.1
	 * @return  Object
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function __construct() {
        parent::__construct();
    }

	public static function process_items( $items ) {

		$self = self::instance();

		$self->push_to_queue( array( 'value1' => $value1, 'value2' => $value2 ) );
        $self->save()->dispatch();
	}

	/**
     * task funciotn run on background over time
     * comes form WP_Background_Process abstruct    
     * @param   $item 
     * @return 
     */
    function task( $item ) {
        
    	pm_log('task', $item);
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