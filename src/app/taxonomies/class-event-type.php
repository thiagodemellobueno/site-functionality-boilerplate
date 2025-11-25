<?php
/**
 * Taxonomy
 *
 * @since   1.0.0
 *
 * @package   Site_Functionality
 */
namespace Site_Functionality\App\Taxonomies;

use Site_Functionality\Common\Abstracts\Taxonomy;

/**
 * Class Taxonomies
 *
 * @package Site_Functionality\App\Taxonomies
 * @since 1.0.0
 */
class Event_Type extends Taxonomy {

	/**
	 * Taxonomy data
	 */
	public static $taxonomy = array(
		'id'          => 'abcnr-event-type',
		'title'       => 'Event Types',
		'singular'    => 'Event Type',
		'menu'        => 'Types',
		'post_types'  => array( 
			'abcnr-event'
		),
		'has_archive' => false,
		'archive'     => false,
		'with_front'  => false,
		'rest'        => 'event-types',
	);

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $settings ) {
		parent::__construct( $settings );

		\add_action( 'init', array( $this, 'rewrite_rules' ), 10, 0 );
	}

	/**
	 * Add rewrite rules
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_rewrite_rule/
	 *
	 * @return void
	 */
	public function rewrite_rules(): void {}

}