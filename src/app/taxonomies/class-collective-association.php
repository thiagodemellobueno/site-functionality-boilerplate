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
class Collective_Association extends Taxonomy {

	/**
	 * Taxonomy data
	 */
	public static $taxonomy = array(
		'id'          => 'abcnr-collective-association',
		'title'       => 'Collective Associations',
		'singular'    => 'Collective Association',
		'menu'        => 'Collectives Association',
		'post_types'  => array(
			'abcnr-program',
			'abcnr-event',
			'abcnr-article'
		),
		'has_archive' => false,
		'archive'     => false,
		'with_front'  => false,
		'rest'        => 'collective-associations',
		'capabilities' => array(
			'manage_terms' => 'manage_collective_association',
			'edit_terms' => 'edit_collective_association',
			'delete_terms' => 'delete_collective_association',
			'assign_terms' => 'assign_collective_assication',
		),
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
		\register_activation_hook( __FILE__, array( $this, 'register_terms' ) );
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
