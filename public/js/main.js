/*
 * Функция вывода информации в консоль
 */
function logger(message, icon, color) {
	var actionString = '\
			<div class="bot-console-string">\
				<i class="fa fa-angle-right" aria-hidden="true"></i>\
				' + message + '\
				<i class="fa fa-' + icon + ' pull-right text-' + color + ' l-h-16" aria-hidden="true"></i>\
			</div>\
		';
	if ($('.bot-console .bot-console-string:contains("\u00a0")').length){
		$('.bot-console .bot-console-string:last').remove();
	} else {
		$('.bot-console .bot-console-string:not(.hidden)').first().addClass('hidden');
	}
	$('.bot-console .bot-console-string:has(.fa)').last().before(actionString);
}

/*
 * Функция отправки команд боту
 */
function sender(url, action, password, message){
	$.ajax({
		url: 'http://' + url + '/cgi-bin/keibot',
		type: 'GET',
		data: {'action': action, 'password': password},
		dataType: 'json',
		crossDomain: true,
		success: function(data){
			if (data['pass']) {
				if (data['exec']) {
					logger(message, 'chevron-circle-left', 'success');
				} else {
					logger(message, 'chevron-circle-left', 'danger');
				}
			} else {
				logger('access denied', 'exclamation-circle', 'danger');
			}
		}
	});
}

$(function(){
	// Отобразим окно камеры только после загрузки фоновой картинки
	var img = new Image();
	img.onload = function(){
		$('.cam-view').show();
	}
	img.src = $('.cam-default').attr('src');

	$('.cam-stream').on('load', function(){
		$(this).animate({opacity: 1}, 2000);
	});

	$('.cam-rotate-horizontal input').slider({
		tooltip_position: 'top',
		formatter: function(value) {
			return value + '°';
		}
	});

	$('.cam-rotate-vertical input').slider({
		tooltip_position: 'left',
		reversed: true,
		formatter: function(value) {
			return value + '°';
		}
	});

	// Выбор бота из списка
	$('.bot-selector').change(function () {
		var action = $(this).val();

		$('.bot-edit-form').attr('action', function(i, val){
			return val.replace(/[^/]+$/, action);
		})
		.append('<input type="hidden" name="activate" value="1">')
		.submit();
	});

	$('.bot-settings-btn').on('mousemove', function(){
		if (!$(this).closest('.open').length){
			$(this).children('.fa').addClass('fa-spin');
		}
	});

	$('.bot-settings-btn').on('mouseout', function(){
		$(this).children('.fa').removeClass('fa-spin');
	});

	$('.bot-settings-btn').closest('.btn-group').on('show.bs.dropdown', function(){
		$(this).children('.bot-settings-btn').children('.fa').removeClass('fa-spin');
	});

	// Обработка событий кнопок управления
	var actionStarted = false;
	var actionId = '1000';

	$('.bot-action-btn').on('mousedown', function(){
		if (!actionStarted) {
			$(this).data('id', actionId++);
			logger('\'' + $(this).data('name') + '\' #' + $(this).data('id') + ' command sended', 'chevron-circle-right', 'primary');
			actionStarted = true;
			sender($(this).data('url'), $(this).data('action'), $(this).data('password'), '\'' + $(this).data('name') + '\' #' + $(this).data('id') + ' action executed');
		}
	})
	.on('mouseup', function(){
		if (actionStarted){
			logger('\'stop\'' + ' #' + $(this).data('id') + ' command sended', 'chevron-circle-right', 'primary');
			actionStarted = false;
			sender($(this).data('url'), 'ms', $(this).data('password'), '\'stop\'' + ' #' + $(this).data('id') + ' action executed');
		}
	})
	.on('mouseleave', function(){
		$(this).trigger('mouseup');
	});

	$(window).on('keydown', function(e){
		if (!actionStarted){
			$('.bot-action-btn[data-code=' + e.which + ']').trigger('mousedown');
		}
	})
	.on('keyup', function(e){
		if (actionStarted){
			$('.bot-action-btn[data-code=' + e.which + ']').trigger('mouseup');
		}
	});
});