/**
 * External dependencies
 */
import classnames from 'classnames';
import applyWithSelect from './../utils/withSelect';

/**
 * WordPress dependencies
 */
const { _x } = wp.i18n;
const { Fragment, Component } = wp.element;
const { compose } = wp.compose;
const { InnerBlocks } = wp.blockEditor;
const { Dashicon } = wp.components;

export default compose( applyWithSelect )(
	class Edit extends Component {
		render() {
			const { className, hasInnerBlocks } = this.props;

			return (
				<Fragment>
					<div
						className={ classnames( className, {
							[ `${ className }--is-empty` ]: ! hasInnerBlocks,
						} ) }
					>
						<header className={ `${ className }__header` }>
							<span className={ `${ className }__icon` }>
								<Dashicon icon="unlock" />
							</span>
							<span className={ `${ className }__desc` }>
								<span>
									{ _x(
										'Content shown if the conditions of the above block are not met.',
										'help',
										'ifblock'
									) }
								</span>
							</span>
						</header>
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
