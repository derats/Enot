$(document).ajaxStart(function() {
  $("#load").show();
});

$(document).ajaxStop(function() {
  $("#load").hide();
});

$(document).ready(function() {

	function form_data() {
		$.getScript("?action=fetchLanguages");
		$.getScript("?action=fetchCountries");
	}

	$('#countries').change(function() {
		$('#search_city').val('');
	});

	$("#lang").change(function() {
		$('#search_city').val('');
		data = {
			action: 'changeLang',
			language: $('#lang :selected').val()
		}
		$.post('', data, function(data) {
			form_data();
		});
	});

	form_data();

	function grep(data, request) {
    	matcher = new RegExp($.ui.autocomplete.escapeRegex(request), "i" );
    	return $.grep(data, function(item) {
            return matcher.test(item.value);
        });
    }

	$("#search_city").autocomplete({
		source: function(request, response) {
			$.ajax({
				dataType: "json",
				url: "?action=fetchCities",
				type: "post", 
				data: {'COUNTRY': $('#countries :selected').val()},
				success: function(data) {
					response(grep(data, request.term));
				}
			});

		},
		select: function(event, ui) {
			console.log(ui.item);
		},
		minLength: 2
	});

});
