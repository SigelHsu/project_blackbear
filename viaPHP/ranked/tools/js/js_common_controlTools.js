
//用來把其他不需要的部分隱藏起來
function fun_hideTheTopLeftBar () {
	$(".sticky-footer").addClass("d-none");			//將其他不需要的部分隱藏
	$("#btn_top").addClass("d-none");
	$(".navbar").addClass("d-none");
	$("#accordionSidebar").addClass("d-none");	//$("#content-wrapper").addClass("d-none");
	$("#div_main").css("min-height", "400px");
}