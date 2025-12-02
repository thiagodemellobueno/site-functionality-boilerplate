<?php
/**
 * Content Post_Types
 *
 * @since   1.0.0
 * @package Site_Functionality
 */
namespace Site_Functionality\App\Post_Types;

use Site_Functionality\Common\Abstracts\Base;
use Site_Functionality\App\Post_Types\Collective;
use Site_Functionality\App\Post_Types\Program;
use Site_Functionality\App\Post_Types\Article;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Post_Types extends Base {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $settings ) {
		parent::__construct( $settings );
		$this->init();
	}

	/**
	 * Init
	 *
	 * @return void
	 */
	public function init(): void {
		new Collective( $this->settings );
		new Program( $this->settings );
		new Event( $this->settings );
		new Article( $this->settings );
		\add_filter( 'allowed_block_types_all', array( $this, 'allowed_post_type_blocks'), 10, 2 );
	}

	/**
	 * Allowed Post Type Blocks
	 * Limits which blocks can be added to which post types
	 *
	 * @param array $post_types
	 * @return array
	 */
	function allowed_post_type_blocks( $allowed_block_types, $editor_context ) {
		if ( in_array( $editor_context, array( 'collective', 'program', 'event' ), true ) ) {
			return array(
				'core/paragraph',
				'core/list',
				'core/list-item',
				'core/image',
				'core/buttons',
				'core/quote',
				'core/gallery'
			);
		} else {
			return true;
		}
	}
}



