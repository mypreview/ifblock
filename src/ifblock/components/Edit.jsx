/**
 * External dependencies
 */
import classnames from 'classnames';
import isArray from 'lodash/isArray';
import findIndex from 'lodash/findIndex';
import isEmpty from 'lodash/isEmpty';
import Inspector from './Inspector.jsx';
import applyWithSelect from './../utils/with-select';

/**
 * WordPress dependencies
 */
const { apiFetch } = wp;
const { __, _x, sprintf } = wp.i18n;
const { Fragment, Component } = wp.element;
const { compose } = wp.compose;
const { InnerBlocks } = wp.blockEditor;
const { Dashicon, Spinner } = wp.components;
const TEMPLATE = [ [ 'mypreview/ifblock-inner-if' ], [ 'mypreview/ifblock-inner-else' ] ];
const API_NAMESPACE = 'ifblock/v1';

export default compose( applyWithSelect )(
	class Edit extends Component {
		state = {
			roles: [],
			browsers: [],
		};

		async componentDidMount() {
			const roles = await this.fetchData( 'user-roles' ),
				browsers = await this.fetchData( 'browsers' );

			this.setState( {
				roles,
				browsers,
			} );
		}

		fetchData = ( endpoint ) => {
			return apiFetch( {
				path: `${ API_NAMESPACE }/${ endpoint }`,
			} )
				.then( ( data ) => data )
				.catch( ( error ) => error );
		};

		getLabel = ( arr, val ) => {
			if ( !!! isArray( arr ) || !!! arr || !!! val ) return;
			const index = findIndex( arr, { value: val } );
			return arr[ index ] !== void 0 ? arr[ index ].label : null;
		};

		render() {
			const { roles, browsers } = this.state;
			const { isSelected, className, attributes } = this.props;
			const { operator, role, browser } = attributes;
			const roleNotice = !!! isEmpty( role )
				? sprintf(
						/* translators: %s: User role. */
						_x( 'logged-in with the following role: %s', 'notice', 'ifblock' ),
						this.getLabel( roles, role )
				  )
				: '';
			const browserNotice = !!! isEmpty( browser )
				? sprintf(
						/* translators: %s: Browser name. */
						_x( 'visiting via %s', 'notice', 'ifblock' ),
						this.getLabel( browsers, browser )
				  )
				: '';
			const notice = sprintf(
				/* translators: 1: First condition, 2: Second condition. */
				_x( 'Content shown to users that are %1$s %2$s', 'notice', 'ifblock' ),
				browserNotice,
				browserNotice && roleNotice ? sprintf( '%1$s %2$s', operator, roleNotice ) : roleNotice
			);

			return (
				<Fragment>
					{ !!! ( ! isEmpty( roles ) || ! isEmpty( browsers ) ) ? (
						<p className={ `${ className }__loading` }>
							<Spinner />
							{ sprintf(
								/* translators: %s: Horizontal ellipsis. */
								__( 'Fetching Data%s', 'ifblock' ),
								'…'
							) }
						</p>
					) : (
						<Fragment>
							{ isSelected && (
								<Inspector { ...this.props } rolesList={ roles } browsersList={ browsers } />
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
									{ _x( 'End If Statement', 'help', 'ifblock' ) }
								</footer>
							</div>
						</Fragment>
					) }
				</Fragment>
			);
		}
	}
);
