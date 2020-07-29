/*$(document).ready(function(){
	$('#show').mousedown(function(){
		$('#pass').removeAttr('type');
		$('#show').addClass('fa-eye-slash').removeClass('fa-eye');
	});
	$('#show').mouseup(function(){
		$('#pass').attr('type','password');
		$('#show').addClass('fa-eye').removeClass('fa-eye-slash');
	})
});*/
function mostrarPassword(){
		var cambio = document.getElementById("txtPassword");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	} 
	
	$(document).ready(function () {
	//CheckBox mostrar contraseña
	$('#ShowPassword').click(function () {
		$('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
	});
});