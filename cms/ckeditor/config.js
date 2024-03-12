/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function(config) {

	// config.removeButtons = 'NewPage,Print,SelectAll,Scayt,Form,Checkbox,Textarea,TextField,Radio,Select,Button,HiddenField,ImageButton,Strike,Subscript,Superscript,NumberedList,BulletedList,Outdent,Indent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,Table,HorizontalRule,PageBreak,Iframe,Format,About';

	// 移除更多不是那麼必要的 ex:樣式,字型...
	config.removeButtons = 'NewPage,Print,SelectAll,Scayt,Form,Checkbox,Textarea,TextField,Radio,Select,Button,HiddenField,ImageButton,Strike,Subscript,Superscript,NumberedList,BulletedList,Outdent,Indent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,Table,HorizontalRule,PageBreak,Iframe,Format,About,Styles,Format,Font,FontSize,TextColor,BGColor,CopyFormatting,RemoveFormat,Save,Smiley,SpecialChar,Templates';

	config.language = 'zh';

	config.removeDialogTabs = 'image:advanced;image:Upload;link:advanced;link:upload';
	config.image_previewText = ' ';

	config.extraPlugins = 'dragresize,youtube,autogrow,autolink';

	config.height = 400;
	config.autoGrow_minHeight = 400;
	config.autoGrow_maxHeight = 700;
};


// remove image attributes (width +  height + style)
CKEDITOR.on('instanceReady', function(ev) {
	ev.editor.dataProcessor.htmlFilter.addRules({
		elements: {
			$: function(element) {
				// check for the tag name
				if (element.name == 'img') {

					delete element.attributes.width;
					delete element.attributes.height;
					delete element.attributes.style;

					// var style = element.attributes.style;

					// // Get the height from the style.
					// var match = /(?:^|\s)height\s*:\s*(\d+)px/i.exec(style);
					// var height = match && match[1];

					// // Replace the height
					// if (height) {
					// 	element.attributes.style = element.attributes.style.replace(/(?:^|\s)height\s*:\s*(\d+)px;?/i, '');
					// }
				}

				if (element.name == 'a') {
					element.attributes.style = "text-decoration: underline; color: var(--cmsLinkColor);";
				}

				// return element
				return element;
			}
		}
	});
});