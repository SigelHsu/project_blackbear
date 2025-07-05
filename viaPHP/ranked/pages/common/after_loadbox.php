<!-- Page level custom scripts -->
<script src = "./tools/js/js_common_controlTools.js"></script>
<script src = "./tools/js/js_toast_controlTools.js"></script>
<script src = "./tools/js/js_listen_controlTools.js"></script>
<script type = "text/javascript">
	$(function () {
		
		//為了顯示 tooltip所用
		$('[data-toggle="tooltip"]').tooltip();

		//這個是測試 tosat的，非必要功能
		/*
		document.getElementById('showToastBtn').addEventListener('click', function () {
			console.log("showToastBtn is clicked");
			fun_showToastMessage();
		});
		*/

		//主要用來當頁面重整後，去localStorage裡面撈資料，若有 toastInfo，就顯示 toast的資料
		window.addEventListener('load', function() {
			if (localStorage.getItem('toastInfo')) {
				var toastInfo = JSON.parse(localStorage.getItem('toastInfo'));
				console.log("localStorage: ", toastInfo)
				fun_showToastMessage({ toastTime: toastInfo.toastTime, 
															 toastMsg: 	toastInfo.toastMsg });
				localStorage.removeItem('toastInfo');
			}
		});
	});
	
</script>