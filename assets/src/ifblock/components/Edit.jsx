/**
 * Edit component
 *
 * @since       1.0.0
 * @package     ifblock
 */

/**
 * Block dependencies
 */
import applyWithSelect from './../utils/withSelect';

/**
 * Internal block libraries
 */
const { _x } = wp.i18n;
const { Fragment, Component } = wp.element;
const { compose } = wp.compose;
const { InnerBlocks } = wp.blockEditor;
const { Dashicon } = wp.components;
const TEMPLATE = [
	[ 'mypreview/ifblock-inner-if' ],
	[ 'mypreview/ifblock-inner-else' ],
];

export default compose( applyWithSelect )(
	class Edit extends Component {
		render() {
			const { isSelected, className } = this.props;

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
										'ifblock'
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
							{ _x( 'End If Statement', 'help', 'ifblock' ) }
						</footer>
					</div>
				</Fragment>
			);
		}
	}
);
