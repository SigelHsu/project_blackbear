function ajax_sendScoreData () {
	console.log("ajax_sendScoreData");
	let rspData = [];
	var datas = $("form").serializeArray();
	$.ajax({
    type: "POST",
    url: "./tools/ajax/ajax_updRankData.php",
    dataType: "html",
    data: datas,
		async: false,
    success: function (response) {
			console.log("success", typeof response);
			console.log(response);
			rspData = response;
			location.reload();
    },
    error: function (thrownError) {
      console.log(thrownError);
    }
  });
	//return rspData;
}
function fun_ScoreBoard() {
	window.open("http://localhost/ranked/index.php?loc=scoreBoard");
}