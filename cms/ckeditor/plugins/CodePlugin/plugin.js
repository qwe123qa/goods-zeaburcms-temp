CKEDITOR.plugins.add('CodePlugin', {
	init: function(editor) {
		editor.addCommand('CodePlugin', new CKEDITOR.dialogCommand('CodePluginDialog'));
		editor.ui.addButton('CodePlugin', {
			label: '產品資訊',
			icon: this.path + 'images/icon.svg',
			command: 'CodePlugin',
		})
		CKEDITOR.dialog.add('CodePluginDialog', this.path + 'dialogs/codeplugin.js');
	}
})
