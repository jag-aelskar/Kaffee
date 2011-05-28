$(document).ready(function(){

var login_aktiv = false;
var timeout;

	$("#mini_login input").focus(function(){
		login_aktiv = true;
	}).blur(function(){
		login_aktiv = false;
	});


	$("#login").mouseenter(function(){
		$("#mini_login").css("margin-top", "0px");
		clearTimeout(timeout);
	});
	
	$("#bar").mouseleave(function(){
		timeout = setTimeout(function(){
			if (!login_aktiv){
				$("#mini_login").css("margin-top", "-30px");
			}
		}, 500);
	});


});