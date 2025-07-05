<!DOCTYPE html>
<html lang="en">
	<head>
		<?php require_once("./pages/common/headbar.php"); ?>
	</head>
	<body>
		<textarea class="ipt_cke" id="editor1">ABC 123 456</textarea>
		<textarea class="ipt_cke" id="editor2">DEF 123 456</textarea>
		<textarea class="ipt_cke" id="editor3">GHI 123 456</textarea>
		<textarea class="ipt_cke" id="editor4">JKL 123 456</textarea>
		<textarea class="ipt_cke" id="editor5">MNO 123 456</textarea>
		<?php include_once("./pages/common/toast.php"); ?>
	</body>
	<foot>
		<?php require_once("./pages/common/footbar.php"); ?>
		<script src="./tools/vendor/ckeditor/ckeditor.js"></script>
		<script>
			js_creCkeditorBox(".ipt_cke");
			function js_creCkeditorBox (target = "") {
				$(target).each(function() {
					var tmp_textareaName = $(this).attr("id");
					CKEDITOR.replace(tmp_textareaName);
				});
				
				return true;
			}
		</script>
    <script>
			document.addEventListener('keydown', function(event) {
				console.log("keydown: ", event);
				if (event.ctrlKey && event.key === 'Enter') {
					console.log("CTRL + ENTER 被按下了");
					localStorage.setItem('showToast', 'true');
					location.reload();
				}
				window.addEventListener('load', function() {
					if (localStorage.getItem('showToast') === 'true') {
						var toastEl = document.getElementById('myToast');
						$(toastEl).toast('show');
						localStorage.removeItem('showToast');
					}
				});
			});
    </script>
	</foot>
</html>