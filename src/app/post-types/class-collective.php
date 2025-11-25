<?php
/**
 * Publication Post_Type
 *
 * @since   1.0.0
 * @package Site_Functionality
 */
namespace Site_Functionality\App\Post_Types;
use Site_Functionality\Common\Abstracts\Post_Type;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Collective extends Post_Type {

	static $post_type = array(
		'id'          => 'abcnr-collective',
		'slug'        => 'collective',
		'menu'        => 'Collectives',
		'title'       => 'Collectives',
		'singular'    => 'Collective',
		'menu_icon'   => 'dashicons-groups',
		'has_archive' => false,
		'with_front'  => false,
		'rest_base'   => 'collectives',
		'supports'    => array(
			'title',
			'editor',
			'excerpt',
			'author',
			'thumbnail',
			'revisions',
			'custom-fields',
			'external-links',
		),
	);

	/**
	 * Init
	 *
	 * @return void
	 */
	public function init(): void {

		parent::init();

		/**
		 * Post_Type data
		 */

		// \add_action( 'init', array( $this, 'register_fields') );
		// \add_action( 'init', array( $this, 'register_meta' ) );
		// \add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_filter( 'relevanssi_index_custom_fields', array( $this, 'index_meta' ), 10, 2 );
	}


	/**
	 * Register Custom Fields
	 *
	 * @return void
	 */
	public function register_fields(): void {

		static::$fields = array(
			array(
				'name'      => 'collective_location',
				'label'     => __( 'Location', 'site-functionality' ),
				'acf_type'  => 'text',
				'meta_type' => 'string',
				'prepend'   => '',
			),
		);

		static::$fields = array_map(
			function( $field ) {
				$array = array(
					'key'               => 'field_' . $field['name'],
					'label'             => $field['label'],
					'name'              => $field['name'],
					'aria-label'        => '',
					'type'              => $field['acf_type'],
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'maxlength'         => '',
					'placeholder'       => '',
					'prepend'           => $field['prepend'],
					'append'            => '',
				);
				if ( 'number' === $field['acf_type'] && isset( $field['step'] ) ) {
					$array['step'] = $field['step'];
				}
				return $array;
			},
			static::$fields
		);

		$args = array(
			'key'                   => 'abcnr-collective-fields',
			'title'                 => __( 'Event', 'site-functionality' ),
			'fields'                => static::$fields,
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'abcnr-collective',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'side',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => esc_html__( 'Please add details about this book.', 'site-functionality' ),
			'show_in_rest'          => 1,
		);

		acf_add_local_field_group( $args );
	}

	/**
	 * Register Meta
	 *
	 * @return void
	 */
	public function register_meta(): void {
		foreach ( self::$fields as $field ) {
			register_post_meta(
				static::$post_type['id'],
				$field['name'],
				array(
					'type'         => $field['type'],
					'single'       => true,
					'show_in_rest' => true,
				)
			);
		}

	}

	/**
	 * Add custom fields to search index
	 *
	 * @link https://www.relevanssi.com/user-manual/filter-hooks/relevanssi_index_custom_fields/
	 *
	 * @param array   $custom_fields
	 * @param integer $post_id
	 * @return array
	 */
	public function index_meta( array $custom_fields, int $post_id ): array {
		$custom_fields = array_keys( $this->fields );
		return $custom_fields;
	}

	/**
	 * Register custom query vars
	 *
	 * @link https://developer.wordpublication.org/reference/hooks/query_vars/
	 *
	 * @param array $vars The array of available query variables
	 */
	public function register_query_vars( $vars ): array {
		return $vars;
	}
}
