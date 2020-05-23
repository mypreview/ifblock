/**
 * Block settings and meta-data
 *
 * @since       1.0.0
 * @package
 */

/**
 * Block dependencies
 */
import edit from './components/Edit.jsx';
import save from './components/Save.jsx';
import attributes from './utils/attributes';

/**
 * Internal block libraries
 */
const { _x } = wp.i18n;

/**
 * Meta-data for registering block type
 */
const name = 'ifblock';
const title = _x( 'If Block', 'block title', 'ifblock' );
const category = 'mypreview';
const icon = 'lock';

/**
 * Block settings
 */
const settings = {
	title,
	description: _x(
		'This block enables you to configure certain content to appear only if specified conditions are met (or be hidden) by setting different visibility rules.',
		'block description',
		'ifblock'
	),
	keywords: [
		_x( 'Protected', 'block keyword', 'ifblock' ),
		_x( 'Visibility', 'block keyword', 'ifblock' ),
		_x( 'Show Hide', 'block keyword', 'ifblock' ),
	],
	supports: {
		html: false,
		anchor: true,
		align: true,
		alignWide: true,
		alignFull: true,
		customClassName: false,
	},
	attributes,
	edit,
	save,
};

export { name, title, category, icon, settings };
