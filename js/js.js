// Код для Input file
$('.my').change(function() {
  if ($(this).val() != '') $('.amount').text('Выбрано файлов: ' + $(this)[0].files.length);
  else $('.amount').text('Выберите файлы');
});

// Для анимации label у input
$(".form-input, .form-text").focus(function() {
  $(this).siblings('label').addClass('active');
});
$(".form-input, .form-text").focusout(function() {
  if ($(this).val() != false) {
    $(this).siblings('label').addClass('active');
  } else {
    $(this).siblings('label').removeClass('active');
  }
});

// Анимация сообщения о результате
var showmsg = new TimelineMax();
showmsg.add(TweenMax.to(".msg", 0.7, {opacity: 1,y: -40,ease: Expo.easeOut}));
showmsg.add(TweenMax.to(".msg", 0.7, {opacity: 0,y: 0,ease: Expo.easeOut,delay: 2}));
showmsg.pause();

// Анимация плашки слова "подождите"
var loadanim = TweenLite.to(".loading", 1, {autoAlpha: 0.8});
loadanim.pause();

// Отправка данных на сервер
$('#form').trigger('reset');
$(function() {
  'use strict';
  $('#form').on('submit', function(e) {
    $('.msg').removeClass('error success');
    $('input').removeClass('inputerror');
    loadanim.play();
    e.preventDefault();
    $.ajax({
      url: 'send.php',
      type: 'POST',
      contentType: false,
      processData: false,
      data: new FormData(this),
      success: function(msg) {
        console.log(msg);
        if (msg == 'ok') {
          $('#form').trigger('reset');
          $('.amount').text('Выберите файлы');
          $('label').removeClass('active');
          $('.msg').text('Сообщение успешно отправлено').addClass('success');
          showmsg.restart();loadanim.duration(0.3).reverse();
        } else {
          if (msg == 'mailerror') {
            $("#email").addClass('inputerror');
          }
          $('.msg').text('Ошибка. Сообщение не отправлено').addClass('error');
          showmsg.restart();loadanim.duration(0.3).reverse();
        }
      }
    });
  });
});
