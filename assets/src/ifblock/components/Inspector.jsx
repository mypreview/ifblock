/**
 * Block dependencies
 */
import applyWithSelect from './../utils/withSelect';

/**
 * Internal block libraries
 */
const { apiFetch } = wp;
const { _x, __, sprintf } = wp.i18n;
const { Fragment, Component } = wp.element;
const { compose } = wp.compose;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, SelectControl, Spinner } = wp.components;
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

export default compose( applyWithSelect )(
	class Inspector extends Component {
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
			const { className, attributes, setAttributes } = this.props;
			const { role, browser } = attributes;

			return (
				<Fragment>
					<InspectorControls>
						<PanelBody initialOpen={ true }>
							{ !!! ( roles.length || browsers.length ) ? (
								<p className={ `${ className }__loading` }>
									<Spinner />
									{ sprintf(
										__( 'Fetching Data %s', 'ifblock' ),
										'…'
									) }
								</p>
							) : (
								<Fragment>
									<SelectControl
										label={ _x(
											'User Role',
											'control label',
											'ifblock'
										) }
										help={ _x(
											'The block content will be shown to users that are logged-in and in the following role.',
											'control help',
											'ifblock'
										) }
										value={ role }
										options={ roles }
										onChange={ ( value ) =>
											setAttributes( {
												role: value || undefined,
											} )
										}
									/>
									<SelectControl
										label={ _x(
											'Browser',
											'control label',
											'ifblock'
										) }
										help={ _x(
											'The block content will be shown to visitors with.',
											'control help',
											'ifblock'
										) }
										value={ browser }
										options={ browsers }
										onChange={ ( value ) =>
											setAttributes( {
												browser: value || undefined,
											} )
										}
									/>
								</Fragment>
							) }
						</PanelBody>
					</InspectorControls>
				</Fragment>
			);
		}
	}
);
