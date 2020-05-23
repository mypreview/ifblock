/**
 * Block dependencies
 */
import './style.css';
import './utils/category';

/**
 * Import custom/built-in editor blocks.
 */
import * as innerIf from './if/';
import * as innerElse from './else/';
import * as ifBlock from './ifblock/';

export function registerBlocks() {
	[ innerIf, innerElse, ifBlock ].forEach( ( block ) => {
		if ( ! block ) {
			return;
		} // End If Statement

		const { name, category, icon, settings } = block;

		wp.blocks.registerBlockType( `mypreview/${ name }`, {
			category,
			icon: {
				src: icon,
				foreground: '#007CBA',
			},
			...settings,
		} );
	} );
}

registerBlocks();
