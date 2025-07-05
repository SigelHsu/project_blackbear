//用來修改 Toast所的內容並展示
function fun_showToastMessage (ipt_showInfo = {toastTime: "Just now", toastMsg: "New Message"}) {
	//console.log("fun_showToastMessage ", ipt_showInfo);
	var tmp_toastContainer 	= document.getElementById('div_toastContainer');
	var set_leftPosition 		= window.innerWidth - tmp_toastContainer.offsetWidth - 25;
	tmp_toastContainer.style.position = 'absolute';
	tmp_toastContainer.style.top 			= '50px';
	tmp_toastContainer.style.left 		= set_leftPosition + 'px';
	
	// 獲取當前時間
	var tmp_currentTime = new Date().toLocaleTimeString();
	
	// 設置 lab_toastTime 和 div_toastBody 的值
	document.getElementById('lab_toastTime').innerText = ( ipt_showInfo.toastTime ) ? ( ipt_showInfo.toastTime ) 	: (tmp_currentTime);
	document.getElementById('div_toastBody').innerText = ( ipt_showInfo.toastMsg ) 	? ( ipt_showInfo.toastMsg ) 	: ("Message");

	$('#myToast').toast('show');

	$('#myToast').on('hidden.bs.toast', function () {
			tmp_toastContainer.style.position = '';
			tmp_toastContainer.style.top 			= '';
			tmp_toastContainer.style.left 		= '';
	});
}

function fun_throughToast2Local (ipt_throughInfo = {toastTime: "", toastMsg: ""}) {
	//console.log("fun_throughToast2Local ", ipt_throughInfo);
	var toastInfo = {
		toastTime: 	ipt_throughInfo.toastTime,
		toastMsg: 	ipt_throughInfo.toastMsg
	};
	localStorage.setItem('toastInfo', JSON.stringify(toastInfo));
}