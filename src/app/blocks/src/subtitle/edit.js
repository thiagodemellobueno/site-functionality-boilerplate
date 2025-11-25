/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';

import { useEntityProp } from '@wordpress/core-data';

import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( {
	attributes,
	setAttributes,
	context: { postType, postId },
} ) {
	const [ meta, updateMeta ] = useEntityProp(
		'postType',
		postType,
		'meta',
		postId
	);

	const { subtitle, brief_number } = meta;

	return (
		<div { ...useBlockProps() }>
			<RichText
				tagName="h3"
				placeholder={ __( 'Subtitle', 'site-functionality' ) }
				allowedFormats={ [ 'core/bold', 'core/italic' ] }
				value={ subtitle }
				onChange={ ( value ) =>
					updateMeta( {
						...meta,
						subtitle: value,
					} )
				}
			/>
			<RichText
				tagName="h3"
				placeholder={ __( '#', 'site-functionality' ) }
				allowedFormats={ [ 'core/bold', 'core/italic' ] }
				disableLineBreaks
				value={ brief_number }
				onChange={ ( value ) =>
					updateMeta( {
						...meta,
						brief_number: value,
					} )
				}
			/>
		</div>
	);
}
