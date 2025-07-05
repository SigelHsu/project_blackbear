//監聽鍵盤的事件
function fun_listenEvent(ipt_listenType = "") {
	if (!ipt_listenType) {
		return 0;
	}
		
	document.addEventListener('keydown', function(event) {
		//當使用者同時按下 CTRL + ENTER時，會觸發下列行動
		if (event.ctrlKey && event.key === 'Enter') {
			switch(ipt_listenType) {
			
				// 主要觸發的是 caption_subtitle.php裡面會有的功能
				case "CaptionSubtitle":
					{
						var focusedElement = document.activeElement;
						if (focusedElement.name === 'text[Subtitle][Info][New]') {		//將新增的資料送出，ajax_addNewSubtitles()功能
							ajax_addNewSubtitles();
						} 
						else if (focusedElement.name === 'input[Subtitle][Info][]') {	//將修改的資料送出，執行ajax_chgthisSubtitles()功能
							var subtitleId = focusedElement.closest('.form-group').id.split('_')[1];
							ajax_chgthisSubtitles(subtitleId);
						}
					}
					break
				
				// 主要觸發的是 public_subtitle.php裡面會有的功能，將最上方一筆資料送出，執行ajax_publishthisSubtitles()功能
				case "PublicSubtitle":
					{
						var firstSubtitle = document.querySelector('#div_subtitleList .form-group');
						if (firstSubtitle) {
								var subtitleId = firstSubtitle.id.split('_')[1];
								ajax_publishthisSubtitles(subtitleId);
						}
					}
					break;
				default:
					{
					}
					break;
			}
		}
	});
}

function fun_listenEventviaCKEditor(ipt_listenType = "") {
	CKEDITOR.on('instanceReady', function(evt) {
		//console.log("instanceReady ", ipt_listenType);
		var editor = evt.editor;

		editor.editable().attachListener(editor.document, 'keydown', function(event) {
			// 當使用者同時按下 CTRL + ENTER 時，會觸發下列行動
			//console.log("keydown: ", event.data.$.ctrlKey, "+ ", event.data.$.key );
			if (event.data.$.ctrlKey && event.data.$.key === 'Enter') {
				switch (ipt_listenType) {
					case "CaptionSubtitle":
						{
							var editorName = editor.name;
							//console.log("editorName:", editorName);
							if (editorName === 'ipt_editor_New') {
								ajax_addNewSubtitles();
							} 
							else if (editorName.split('_')[1] === 'editor') {
								var subtitleId = editorName.split('_')[2];
								ajax_chgthisSubtitles(subtitleId);
							}
						}
						break;

					case "PublicSubtitle":
						{
							var firstSubtitle = document.querySelector('#div_subtitleList .form-group');
							if (firstSubtitle) {
								var subtitleId = firstSubtitle.id.split('_')[1];
								ajax_publishthisSubtitles(subtitleId);
							}
						}
						break;

					default:
						break;
				}
			}
		});
	});
}