/**
 * Block dependencies
 */
import './style.css';
import './utils/category';
import forEach from 'lodash/forEach';

const { registerBlockType } = wp.blocks;

/**
 * Import custom/built-in editor blocks.
 */
import * as innerIf from './if/';
import * as innerElse from './else/';
import * as ifBlock from './ifblock/';

export function registerBlocks() {
	forEach( [ innerIf, innerElse, ifBlock ], ( block ) => {
		if ( ! block ) {
			return;
		} // End If Statement

		const { name, category, icon, settings } = block;

		registerBlockType( `mypreview/${ name }`, {
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
