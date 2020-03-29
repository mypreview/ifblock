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
const { InspectorControls } = wp.blockEditor;
const { PanelBody, SelectControl } = wp.components;

export default compose( applyWithSelect )(
	class Inspector extends Component {
		render() {
			const {
				className,
				attributes,
				setAttributes,
				roles,
				browsers,
			} = this.props;
			const { role, browser } = attributes;

			return (
				<Fragment>
					<InspectorControls>
						<PanelBody initialOpen={ true }>
							<SelectControl
								label={ _x(
									'User Role',
									'control label',
									'ifblock'
								) }
								help={ _x(
									'The block content will be shown to users that are logged-in and in the selected role.',
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
									'The block content will be shown to users that are browsing the page via the selected browser.',
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
						</PanelBody>
					</InspectorControls>
				</Fragment>
			);
		}
	}
);
