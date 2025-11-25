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
class Collective_Relation extends Taxonomy {

	/**
	 * Taxonomy data
	 */
	public static $taxonomy = array(
		'id'          => 'abcnr-collective-relation',
		'title'       => 'Collectives',
		'singular'    => 'Collective',
		'menu'        => 'Collectives',
		'post_types'  => array(
			'abcnr-program',
			'abcnr-event',
			'abcnr-article'
		),
		'has_archive' => false,
		'archive'     => false,
		'with_front'  => false,
		'rest'        => 'collectives',
	);

	function register_terms() {

		$terms = array(
			array(
				'name'=> 'Punk/Hardcore',
				'args' => array(
					'description'=> '',
					'slug' => 'punk-hc',
				)
			),
			array(
				'name'=>'Visual Arts',
				'args' => array(
					'description'=> '',
					'slug' => 'visual-arts'
				)
			),
			array(
				'name' => 'Silkscreen PrintShop',
				'args' => array(
					'slug' => 'silkscreen',
					'description'=> '',
				),
			),
			array(
				'name' => 'Zine Library',
				'args' => array(
					'description'=> '',
					'slug' => 'zine',
				),
			),
			array(
				'name' => 'Darkroom',
				'args' => array(
					'description'=> '',
					'slug' => 'darkroom',
				),
			),
			array(
				'name' => 'Computer Center',
				'args' => array(
					'description'=> '',
					'slug' => 'computer-center',
				),
			));

		foreach($terms as $term ){
			if ( !term_exists($term['args']['slug'], static::$taxonomy['id']) ) {
				wp_insert_term( $term['name'], static::$taxonomy['id'], $term['args']);
			};
		}
	}


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $settings ) {
		parent::__construct( $settings );

//		\add_action( 'init', array( $this, 'register_terms' ) );
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
