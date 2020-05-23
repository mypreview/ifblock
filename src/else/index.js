/**
 * Internal dependencies & components
 */
import edit from './components/Edit.jsx';
import save from './components/Save.jsx';

/**
 * WordPress dependencies
 */
const { _x } = wp.i18n;

/**
 * Meta-data for registering block type
 */
const name = 'ifblock-inner-else';
const title = _x( 'Else', 'block title', 'ifblock' );
const category = 'mypreview';
const icon = 'admin-generic';

/**
 * Block settings
 */
const settings = {
	title,
	parent: [ 'mypreview/ifblock' ],
	supports: {
		html: false,
		anchor: true,
		inserter: false,
		customClassName: false,
	},
	edit,
	save,
};

export { name, title, category, icon, settings };
