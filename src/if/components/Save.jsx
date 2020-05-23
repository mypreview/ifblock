/**
 * Save component
 *
 * @since       1.0.0
 * @package
 */

/**
 * Internal block libraries
 */
const { Component } = wp.element;
const { InnerBlocks } = wp.blockEditor;

export default class Save extends Component {
	render() {
		return (
			<div>
				<InnerBlocks.Content />
			</div>
		);
	}
}
