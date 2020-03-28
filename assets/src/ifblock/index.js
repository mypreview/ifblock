/**
 * Block settings and meta-data
 *
 * @since       1.0.0
 * @package     ifblock
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
const icon = 'admin-generic';

/**
 * Block settings
 */
const settings = {
	title,
	supports: {
		html: false,
		anchor: true,
		customClassName: false,
	},
	attributes,
	edit,
	save,
};

export { name, title, category, icon, settings };
