/**
 * Higher order component to fetch its data and pass it to our block as props.
 *
 * @since       1.0.0
 * @package     ifblocks
 */

/**
 * Internal block libraries
 */
const { withSelect } = wp.data;

/**
 * Generate block data.
 */
const applyWithSelect = withSelect( ( select, { clientId } ) => {
	const { getBlock } = select( 'core/block-editor' );

	const block = getBlock( clientId );

	return {
		hasInnerBlocks: !! ( block && block.innerBlocks.length ),
	};
} );

export default applyWithSelect;
