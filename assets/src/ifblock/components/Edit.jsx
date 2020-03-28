/**
 * Edit component
 *
 * @since       1.0.0
 * @package     ifblocks
 */

/**
 * Block dependencies
 */
import applyWithSelect from './../../utils/withSelect';

/**
 * Internal block libraries
 */
const { _x } = wp.i18n;
const { Fragment, Component } = wp.element;
const { compose } = wp.compose;
const { InnerBlocks } = wp.blockEditor;
const { Dashicon } = wp.components;
const TEMPLATE = [
	[ 'mypreview/ifblocks-inner-if' ],
	[ 'mypreview/ifblocks-inner-else' ],
];

export default compose( applyWithSelect )(
	class Edit extends Component {
		render() {
			const { className } = this.props;

			return (
				<Fragment>
					<div className={ className }>
						<header className={ `${ className }__header` }>
							<span className={ `${ className }__icon` }>
								<Dashicon icon="lock" />
							</span>
							<span className={ `${ className }__desc` }>
								<span>
									{ _x(
										'Content shown if the conditions of the if-block are not met.',
										'help',
										'ifblocks'
									) }
								</span>
							</span>
						</header>
						<InnerBlocks
							templateLock="all"
							template={ TEMPLATE }
							allowedBlocksExample={ TEMPLATE }
						/>
						<footer className={ `${ className }__footer` }>
							{ _x( 'End If Statement', 'help', 'ifblocks' ) }
						</footer>
					</div>
				</Fragment>
			);
		}
	}
);
