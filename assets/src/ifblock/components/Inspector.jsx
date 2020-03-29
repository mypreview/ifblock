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
const {
	PanelBody,
	BaseControl,
	ButtonGroup,
	Button,
	SelectControl,
} = wp.components;

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
			const { operator, role, browser } = attributes;

			return (
				<Fragment>
					<InspectorControls>
						<PanelBody initialOpen={ true }>
							{ !! role && !! browser && (
								<BaseControl
									id={ `${ className }-conditional-operator` }
									label={ _x(
										'Operator',
										'control label',
										'ifblock'
									) }
									help={
										'and' === operator
											? _x(
													'The block will be shown if all conditions defined below are true or match.',
													'control label',
													'ifblock'
											  )
											: _x(
													'The block will be shown if either of the conditions defined below is true or a match.',
													'control label',
													'ifblock'
											  )
									}
								>
									<ButtonGroup
										aria-label={ _x(
											'Conditional operator',
											'aria label',
											'ifblock'
										) }
									>
										<Button
											isSmall
											isPrimary={
												'and' === operator
													? true
													: false
											}
											onClick={ () =>
												setAttributes( {
													operator: 'and',
												} )
											}
										>
											{ _x(
												'AND',
												'operator',
												'ifblock'
											) }
										</Button>
										<Button
											isSmall
											isPrimary={
												'or' === operator ? true : false
											}
											onClick={ () =>
												setAttributes( {
													operator: 'or',
												} )
											}
										>
											{ _x(
												'OR',
												'operator',
												'ifblock'
											) }
										</Button>
									</ButtonGroup>
								</BaseControl>
							) }
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
