<?php
/**
 * Event Post_Type
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

class Event extends Post_Type {

	/**
	 * Post_Type data
	 */
	public static $post_type = array(
		'id'          => 'abcnr-event',
		'slug'        => 'event',
		'menu'        => 'Events',
		'title'       => 'Events',
		'singular'    => 'Event',
		'menu_icon'   => 'dashicons-calendar',
		'has_archive' => false,
		'with_front'  => false,
		'rest_base'   => 'events',
		'supports'    => array(
			'title',
			'editor',
			'excerpt',
			'author',
			'thumbnail',
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
		\add_action( 'acf/init', array( $this, 'register_fields' ), 9 );
		\add_action( 'init', array( $this, 'register_meta' ) );
		\add_action( 'acf/prepare_field/type=date_picker', array( $this, 'modify_date_picker' ) );
	}


	/**
	 * Register Custom Fields
	 *
	 * @return void
	 */
	public function register_fields(): void {

		static::$fields = array(

			array(
				'name'      => 'start',
				'label'     => __( 'Start', 'site-functionality' ),
				'acf_type'  => 'date_time_picker',
				'meta_type' => 'DATETIME',
				'prepend'   => '',
			),
			array(
				'name'      => 'end',
				'label'     => __( 'End', 'site-functionality' ),
				'acf_type'  => 'date_time_picker',
				'meta_type' => 'DATETIME',
				'prepend'   => '',
			),
			array(
				'name'      => 'location',
				'label'     => __( 'Location', 'site-functionality' ),
				'acf_type'  => 'text',
				'meta_type' => 'string',
				'prepend'   => '',
			),
			array(
				'name'      => 'organizer_name',
				'label'     => __( 'Organizer Name', 'site-functionality' ),
				'acf_type'  => 'text',
				'meta_type' => 'string',
				'prepend'   => '',
			),
			array(
				'name'      => 'organizer_email',
				'label'     => __( 'Email', 'site-functionality' ),
				'acf_type'  => 'email',
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
			'key'                   => 'abcnr-event-fields',
			'title'                 => __( 'Event', 'site-functionality' ),
			'fields'                => static::$fields,
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'abcnr-event',
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
			'description'           => esc_html__( 'Please add details about this Event.', 'site-functionality' ),
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
	 * Modify Date Picker Field
	 *
	 * @see https://www.advancedcustomfields.com/resources/acf-prepare_field/
	 *
	 * @param  array $field
	 * @return array $field
	 */
	public function modify_date_picker( array $field ) : array {
		$field['display_format'] = 'm/d/Y';
		$field['return_format']  = 'm/d/Y';
		return $field;
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
