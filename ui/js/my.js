function incrscore(id) {
	//alert(id);
	var url = "ajaxredis.php?action=incrscore&teamkey="+id;
    $.get(url, function(data) {          
    }).done(function(data) {
        $("#score-"+id).html(data);
    }).fail(function() {
        $("#score-"+id).html("ERR");
    });
}

function decrscore(id) {
	var url = "ajaxredis.php?action=decrscore&teamkey="+id;
    $.get(url, function(data) {          
    }).done(function(data) {
        $("#score-"+id).html(data);
    }).fail(function() {
        $("#score-"+id).html("ERR");
    });
}

function resetalltime() {
	console.log("reset all time");
	var url = "ajaxredis.php?action=resetalltime";
    $.get(url, function(data) {          
    }).done(function(data) {
    	//$('#divId').find('.buttonScore');
    	$("div[id^='position-']").html("------");
    	$("img[id^='imagebutton-']").attr("src", "img/button_red.png");
        //$("#position-"+id).html(data);
    }).fail(function() {
        $("#position-"+id).html("ERR");
    });
}

function setNbTeams() {
	console.log("set Nb Teams");
	var nbteams = $("#inputNbTeams").val();
	if (nbteams == 0) {
		var url = "ajaxredis.php?action=flushall";
	    $.get(url, function(data) {
	    }).done(function(data) {
	    	console.log("Flush ALL")         
	    });
	} else {
		var url = "ajaxredis.php?action=setnbteams&nbteams="+nbteams;
	    $.get(url, function(data) {
	    }).done(function(data) {
	    	console.log("set Nb Teams ok")         
	    });
	}
}

function refresh() {
    console.log("refresh");
    var url = "ajaxredis.php?action=refresh";
    $.get(url, function(data) {          
    }).done(function(data) {
    	arr = JSON.parse(data);
    	//console.log(arr["positions"]);
    	for(var i in arr["positions"])
		{
			var str = String(arr["positions"][i]);
		    console.log(str);
		    if (str == "1") {
		    	str = str + "er";
			}
		    else {
		    	str = str + "ème";
		    }
		    $("#position-"+i).html(str);
		    $("#imagebutton-"+i).attr("src", "img/button_green.png");
		}
        $("#time").html(data);
    }).fail(function() {
        console.log("error");
    }).always(function() {
        setTimeout(refresh, 1000);
    });
}

refresh();