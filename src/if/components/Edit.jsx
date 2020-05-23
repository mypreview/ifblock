/**
 * External dependencies
 */
import applyWithSelect from './../utils/withSelect';

/**
 * WordPress dependencies
 */
const { Fragment, Component } = wp.element;
const { compose } = wp.compose;
const { InnerBlocks } = wp.blockEditor;

export default compose( applyWithSelect )(
	class Edit extends Component {
		render() {
			const { className, hasInnerBlocks } = this.props;

			return (
				<Fragment>
					<div className={ className }>
						<InnerBlocks
							templateLock={ false }
							renderAppender={ ! hasInnerBlocks && InnerBlocks.ButtonBlockAppender }
						/>
					</div>
				</Fragment>
			);
		}
	}
);
