/**
 * Block settings and meta-data
 *
 * @since       1.0.0
 * @package     ifblocks
 */

/**
 * Block dependencies
 */
import edit from './components/Edit.jsx';
import save from './components/Save.jsx';
import icons from './../utils/icons';

/**
 * Internal block libraries
 */
const { _x } = wp.i18n;

/**
 * Meta-data for registering block type
 */
const name = 'inner-if';
const title = _x( 'If', 'block title', 'ifblocks' );
const category = 'mypreview';
const icon = icons.lock;

/**
 * Block settings
 */
const settings = {
	title,
	supports: {
		inserter: false,
		html: false,
	},
	edit,
	save,
};

export { name, title, category, icon, settings };
