function ajax_sendCounterData () {
	
	let rspData = [];
	var datas = $("form").serializeArray();
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_updCounterData.php",
    dataType: "JSON",
    data: datas,
		async: false,
    success: function (response) {
			console.log("success", response);	//console.log(response);
			rspData = response;
			alert("新增/修改成功");
			location.replace("./index.php?loc=editCount&code="+rspData.Counter_Code);
			//location.reload();
    },
    error: function (thrownError) {
      console.log("thrownError ", thrownError);
    }
  });
	//return rspData;
}
function ajax_sendScoreData () {
	//console.log("ajax_sendScoreData");
	
	let rspData = [];
	var datas = $("form").serializeArray();
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_updRankData.php",
    dataType: "json",
    data: datas,
		async: false,
    success: function (response) {
			//console.log("success", typeof response);	//console.log(response);
			rspData = response;
			location.reload();
    },
    error: function (thrownError) {
      console.log(thrownError);
    }
  });
	//return rspData;
}
function ajax_grabDataFrom () {
	console.log("ajax_grabDataFrom");
	
	let rspData = [];
	var datas = $("form").serializeArray();
	
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_grabOutsideData.php",
    dataType: "json",
    data: datas,
		async: false,
    success: function (response) {
			//console.log("success", typeof response);	//console.log(response);
			rspData = response;
			location.reload();
    },
    error: function (thrownError) {
      console.log(thrownError);
    }
  });
	//return rspData;
}

function js_resetData() {
	location.reload();
}
function js_JumpCounter(target = "") {
	let basic_url = '<?=$GLOBALS["html_root"];?>';
	//console.log("url ", basic_url+"/index.php?loc=scoreBoard&code="+target);
	window.open(basic_url+"/index.php?loc=jumpCount&code="+target);
}

function js_startGrabInfoData(frequency) {
	ajax_grabDataFrom();
}

function js_setStatus(target, value) {
	$(target).parents("div.form-group").find("input.ipt_Status").val(value);
	$(target).parents("div.form-group").find("button").removeClass("btn-primary").addClass("btn-secondary");
	$(target).parents("div.form-group").find("button.btnStatus_"+value).removeClass("btn-secondary").addClass("btn-primary");
}

function js_chgNavTab(target) {
	console.log("js_chgNavTab", target);
	$("ul#nav_bar a.nav_tab").removeClass("active");
	$("ul#nav_bar a#tab_"+target).addClass("active");
	$("div#page_edit div.div_edit").removeClass("d-none").addClass("d-none");
	$("div#page_edit div#div_"+target).removeClass("d-none");
}

function ajax_addNewValues() {
	let rspData = [];
	var datas = $("form").serializeArray();
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_addNewValues.php",
    dataType: "JSON",
    data: datas,
		async: false,
    success: function (response) {
			console.log("success", response);	//console.log(response);
			rspData = response;
			//alert("新增/修改成功");
			location.reload();
    },
    error: function (thrownError) {
      console.log("thrownError ", thrownError);
    }
  });
}

function ajax_sendGrabInfoData() {
	let rspData = [];
	var datas = $("form").serializeArray();
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_updGrabValues.php",
    dataType: "JSON",
    data: datas,
		async: false,
    success: function (response) {
			console.log("success", response);	//console.log(response);
			rspData = response;
			alert("新增/修改成功");
			location.reload();
    },
    error: function (thrownError) {
      console.log("thrownError ", thrownError);
    }
  });
}