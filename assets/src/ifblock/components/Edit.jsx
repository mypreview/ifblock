/**
 * Edit component
 *
 * @since       1.0.0
 * @package     ifblock
 */

/**
 * Block dependencies
 */
import classnames from 'classnames';
import findIndex from 'lodash/findIndex';
import isEmpty from 'lodash/isEmpty';
import Inspector from './Inspector.jsx';
import applyWithSelect from './../utils/withSelect';

/**
 * Internal block libraries
 */
const { apiFetch } = wp;
const { __, _x, sprintf } = wp.i18n;
const { Fragment, Component } = wp.element;
const { compose } = wp.compose;
const { InnerBlocks } = wp.blockEditor;
const { Dashicon, Spinner } = wp.components;
const TEMPLATE = [
	[ 'mypreview/ifblock-inner-if' ],
	[ 'mypreview/ifblock-inner-else' ],
];
let API_NAMESPACE = 'ifblock/v1';

function getRoles() {
	return apiFetch( {
		path: `${ API_NAMESPACE }/user-roles`,
	} )
		.then( ( data ) => data )
		.catch( ( error ) => error );
}

function getBrowsers() {
	return apiFetch( {
		path: `${ API_NAMESPACE }/browsers`,
	} )
		.then( ( data ) => data )
		.catch( ( error ) => error );
}

function getLabel( arr, val ) {
	if ( !!! Array.isArray( arr ) || !!! arr || !!! val ) return;

	const index = _.findIndex( arr, { value: val } );

	return arr[ index ] !== void 0 ? arr[ index ][ 'label' ] : null;
}

function isEmptyVar( value = null ) {
	return !! value && null !== value && undefined !== value && '' !== value
		? true
		: false;
}

export default compose( applyWithSelect )(
	class Edit extends Component {
		state = {
			roles: [],
			browsers: [],
		};

		async componentDidMount() {
			const roles = await getRoles(),
				browsers = await getBrowsers();
			this.setState( {
				roles,
				browsers,
			} );
		}

		render() {
			const { roles, browsers } = this.state;
			const { isSelected, className, attributes } = this.props;
			const { role, browser } = attributes;
			const roleNotice = !!! _.isEmpty( role )
				? sprintf(
						_x(
							'logged-in with the following role: %s',
							'notice',
							'ifblock'
						),
						role
				  )
				: '';
			const browserNotice = !!! _.isEmpty( browser )
				? sprintf(
						_x( 'visiting via %s', 'notice', 'ifblock' ),
						getLabel( browsers, browser )
				  )
				: '';
			const notice = sprintf(
				sprintf(
					_x(
						'Content shown to users that are %s %s',
						'notice',
						'ifblock'
					),
					browserNotice,
					browserNotice && roleNotice
						? sprintf(
								_x( 'and %s', 'notice', 'ifblock' ),
								roleNotice
						  )
						: roleNotice
				)
			);

			return (
				<Fragment>
					{ !!! ( roles.length || browsers.length ) ? (
						<p className={ `${ className }__loading` }>
							<Spinner />
							{ sprintf(
								__( 'Fetching Data%s', 'ifblock' ),
								'…'
							) }
						</p>
					) : (
						<Fragment>
							{ isSelected && (
								<Inspector
									{ ...this.props }
									roles={ roles }
									browsers={ browsers }
								/>
							) }
							<div
								className={ classnames( className, {
									[ `${ className }--selected` ]: isSelected,
								} ) }
							>
								<header className={ `${ className }__header` }>
									<span className={ `${ className }__icon` }>
										<Dashicon icon="lock" />
									</span>
									<span className={ `${ className }__desc` }>
										<span>
											{ !! roleNotice || !! browserNotice
												? notice
												: _x(
														'Mix and match different conditional statements from the right-hand sidebar panel.',
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
									{ _x(
										'End If Statement',
										'help',
										'ifblock'
									) }
								</footer>
							</div>
						</Fragment>
					) }
				</Fragment>
			);
		}
	}
);
