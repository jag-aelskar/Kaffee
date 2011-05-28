$(document).ready(function(){

var login_aktiv = false;

	$("#mini_login input").focus(function(){
		login_aktiv = true;
	}).blur(function(){
		login_aktiv = false;
	});


	$("#login").mouseenter(function(){
		$("#mini_login").css("margin-top", "0px");
	});
	
	$("#bar").mouseleave(function(){
		if (!login_aktiv){
			$("#mini_login").css("margin-top", "-30px");
		}
	});


});