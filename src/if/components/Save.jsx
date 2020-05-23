/**
 * WordPress dependencies
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
