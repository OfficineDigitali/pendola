function parseID(node) {
	var id = node.attr('id');
	return id.substring(id.indexOf('-') + 1);
}

function initCommons() {
	$('.accordion').collapse();
	$('.iconpick').iconpicker();

	$('.revealing').each(function(index) {
		var id = $(this).attr('id');
		var target = $(this);
		$('input[type=radio]').change(function () {
			var valtarget = $(this).attr('value');
			if (id == valtarget && $(this).is(':checked'))
				target.show();
			else
				target.hide();
		});
	});

	$('input.date').datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		language: 'it'
	});
}

function stepSelect(name, endpoint, data) {
	$('#' + name).empty();
	$('#steps .panel-info').collapse('hide');

	$.get(endpoint, data, function(contents) {
		$('#' + name).collapse('show').append(contents);
	});
}

function alarmTypeSelected() {
	var typeid = $('input[name=alarmtype]').val();
	stepSelect('select-details', '/alarms/create', {action: 'details', type: typeid});
}

function pushNewAlarmType(id, name) {
	$('#select-alarm .alert').remove();
	$('#select-alarm ul').append('<li class="alarmtype" id="alarm-' + id + '"><p>' + name + '</p></li>');
}

function engageEditing(node) {
	node.find('.inline-edit .value').hide();
	node.find('.inline-edit .edit').show();
	node.addClass('editing');
}

function cancelEditing(node) {
	node.find('.inline-edit .edit').hide();
	node.find('.inline-edit .value').show();
	node.removeClass('editing');
}

$(document).ready(function() {
	$(document).ajaxSuccess(function(e, xhr, settings) {
		initCommons();
	});

	initCommons();

	$('.inline-action').each(function() {
		$(this).popover({
			container: 'body',
			placement: 'bottom',
			html : true,
			content: function() {
				return $(this).next().html();
			}
		});
	});

	$('.inline-action').on('shown.bs.popover', function() {
		$('.inline-action').not(this).popover('hide');
		$('.popover select[multiple=multiple]').multiselect('destroy').multiselect({
			nonSelectedText: 'nessuno selezionato',
			nSelectedText: 'selezionati',
			allSelectedText: 'selezionati tutti'
		});
	});

	$('.delete-button').click(function() {
		var it = $(this).parents('.item');
		var id = it.find('input[name=item_id]').val();
		var type = it.find('input[name=item_type]').val();

		var msg = 'Sei proprio sicuro di voler eliminare questo elemento?';
		if ($(this).hasClass('hard-delete'))
			msg = 'Sei proprio sicuro di voler eliminare questo elemento? NON È POSSIBILE ANNULLARE L\'OPERAZIONE!';

		if (confirm(msg)) {
			$.ajax({
				url: '/' + type + '/' + id,
				data: {_token: $('meta[name=csrf-token]').attr('content')},
				type: 'DELETE',
				success: function () {
					location.reload();
				}
			});
		}
	});

	$('.undo-button').click(function() {
		var link = $(this).attr('href');

		var data = {
			type: 'restore',
			_token: $('meta[name=csrf-token]').attr('content')
		};

		$.post(link, data, function() {
			location.reload();
		});

		return false;
	});

	/*
		Inline editing
	*/

	$('.edit-button').click(function() {
		var item = $(this).parents('.item');
		if (item.hasClass('editing'))
			cancelEditing(item);
		else
			engageEditing(item);
	});

	$('.cancel-edit').click(function() {
		var item = $(this).parents('.item');
		cancelEditing(item);
	});

	/*
		Editing multilinea
	*/

	if ($('.many-rows').length != 0) {
		function manyRowsAddDeleteButtons(node) {
			if (node.find('.delete-many-rows').length == 0) {
				var fields = node.find('.row');
				if (fields.length > 1) {
					fields.each(function() {
						var button = '<div class="col-md-2"><a class="btn btn-danger pull-right delete-many-rows"><span class="glyphicon glyphicon-delete" aria-hidden="true"></span> Elimina</a></div>';
						$(this).append(button);
					});
				}
			}
		}

		$('.many-rows').on('click', '.delete-many-rows', function() {
			var container = $(this).parents('.many-rows');
			$(this).parents('.row').remove();
			if (container.find('.row').length <= 1)
				container.find('.delete-many-rows').parent().remove();
			return false;
		});

		$('.many-rows').on('click', '.add-many-rows', function() {
			var container = $(this).parents('.many-rows');
			var row = container.find('.row').first().clone();
			row.find('input').val('');
			row.find('select option').removeAttr('selected');
			container.find('.add-many-rows').before(row);
			manyRowsAddDeleteButtons(container);
			return false;
		});

		$('.many-rows').each(function() {
			manyRowsAddDeleteButtons($(this));
		});
	}

	/*
		Interazione pannello creazione nuova scadenza
	*/

	$('#select-entity li').click(function() {
		var id = parseID($(this));
		var type_id = parseID($(this).parents('ul'));
		$('input[name=entity]').val(id);
		$('input[name=entitytype]').val(type_id);
		$('#select-details').empty();

		stepSelect('select-alarm', '/entity/' + id + '/edit', {type: 'selectalarm'});
	});

	$('body').on('click', '#select-alarm li.alarmtype', function() {
		var id = parseID($(this));
		$('input[name=alarmtype]').val(id);
		alarmTypeSelected();
	});

	$('body').on('submit', '#create-new-alarm form', function() {
		var form = $('#create-new-alarm form');
		var name = form.find('input[name=name]').val();

		var data = {
			name: name,
			entitytype: $('input[name=entitytype]').val(),
			type: form.find('input[name=type]:checked').val(),
			recurrence: form.find('input[name=recurrence]:checked').val(),
			recurrence_quantity: form.find('input[name=custom-recurrence-quantity]').val(),
			recurrence_unit: form.find('select[name=custom-recurrence-unit] option:selected').val(),
			_token: $('meta[name=csrf-token]').attr('content')
		};

		$.post('/alarmtype', data, function(identifier) {
			$('#create-new-alarm').modal('hide');
			$('input[name=alarmtype]').val(identifier);
			pushNewAlarmType(identifier, name);
			alarmTypeSelected();
		});

		return false;
	});

	$('body').on('submit', '#new-alarm-details', function() {
		$(this).append($('input[name=entity]').clone());
		$(this).append($('input[name=alarmtype]').clone());
		return true;
	});

	/*
		Animazione pendola
	*/

	var rotation = 7;
        var swingtime = 1603;
        var swinger = $('.pendulum-parent');
        swinger.css("display", "block");

        function pendulumSwing(first) {
		swinger.animate({rotate: rotation},swingtime, first? 0 : "swing", function() {
			rotation *= -1;
			pendulumSwing();
		});
	}

        pendulumSwing(true);
});
