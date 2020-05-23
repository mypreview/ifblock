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

/**
 * Internal block libraries
 */
const { _x } = wp.i18n;

/**
 * Meta-data for registering block type
 */
const name = 'ifblock-inner-if';
const title = _x( 'If', 'block title', 'ifblock' );
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