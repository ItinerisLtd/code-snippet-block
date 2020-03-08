import { registerBlockType } from '@wordpress/blocks';
import { PlainText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

console.log('bye block 222');

registerBlockType( 'code-snippet-block/code-snippet-block', {
  title: 'Code Snippet',
  // TODO: Icon.
	category: "formatting",
	attributes: {
		content: {
      type: "string",
		}
  },
  support: {
    html: false, // Not sure what it does; Copied from WP built-in code block.
  },

  edit: ({ attributes: { content }, setAttributes, className }) => {
    return (
      <div className={ className }>
        <PlainText
          value={ content }
          // TODO: Sanitizing & escaping?
          onChange={ ( content ) => setAttributes( { content }) }
          placeholder={ __( "echo 'Hello World';" ) }
          aria-label={ __( 'Code Snippet' ) }
        />
      </div>
    );
  }
});
