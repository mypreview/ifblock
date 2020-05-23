/**
 * Higher order component to fetch its data and pass it to our block as props.
 *
 * @since       1.0.0
 * @package
 */

/**
 * Internal block libraries
 */
const { withSelect } = wp.data;

/**
 * Generate block data.
 */
const applyWithSelect = withSelect( ( select, props ) => {
	const { clientId } = props;
	const { getBlock, getBlockHierarchyRootClientId, getSelectedBlockClientId } = select( 'core/block-editor' );

	// Get clientID of the parent block.
	const rootClientId = getBlockHierarchyRootClientId( clientId ),
		selectedRootClientId = getBlockHierarchyRootClientId( getSelectedBlockClientId() ),
		block = getBlock( clientId );

	return {
		hasInnerBlocks: !! ( block && block.innerBlocks.length ),
		isSelected: props.isSelected || rootClientId === selectedRootClientId,
	};
} );

export default applyWithSelect;
