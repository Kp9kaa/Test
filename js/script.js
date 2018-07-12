//С помощью JQuery вызывается всплывающее окно
$('.show_popup').click(function() {
    let popup_id = $('#' + $(this).attr("rel"));
    $(popup_id).show();
    $('.overlay_popup, .popup').show();
})
$('.overlay_popup').click(function() {
    $('.overlay_popup, .popup, #signUp, #signIn').hide();
})

//Используя ajax, передаю данные из формы в php
$('form').submit(function(){
	$.ajax({
		type: "POST",
		url: "db.php",
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		success: function(result){
			alert(result);
		},
	});
});

//Блокирование кнопки в регистрации, пока пароли не будут совпадать.
$('#pass, #conf_pass').on('keyup', function () {
  if ($('#pass').val() == $('#conf_pass').val()) {
  	$('#buttonUp').prop('disabled', false);
    $('#message').html('Matching').css('color', 'green');
  } else {
    $('#message').html('Not Matching').css('color', 'red');
    $('#buttonUp').prop('disabled', true);
  }
});