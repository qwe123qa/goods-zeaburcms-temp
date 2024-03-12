CKEDITOR.dialog.add('CodePluginDialog', function(editor) {
	return {
		title: '產品資訊',
		minWidth: 600,
		minHeight: 200,
		contents: [{
			id: 'tab-1',
			label: '其本設定',
			elements: [{
				type: 'text',
				id: 'title',
				label: '標題'
			}, {
				type: 'textarea',
				id: 'content',
				label: '內容'
			}]
		}],
		onOk: function() {
			var inserted = `
				<div class='pd-custom-1'>
					<div class='title'>${this.getValueOf('tab-1', 'title')}</div>
					<div class='content'>${this.getValueOf('tab-1', 'content')}</div>
				</div>
			`;
			editor.insertHtml(inserted);
		}
	};
});