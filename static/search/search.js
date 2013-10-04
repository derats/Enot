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
		$.getScript("?action=fetchDuration");
		$.getScript("?action=fetchRoomNumber");
		$.getScript("?action=fetchRoomCode");
	}

	var cityInput = $("#searchCity");

	$('#country').change(function() {
		cityInput.val('');
	});

	$("#lang").change(function() {
		cityInput.val('');
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

	cityInput.autocomplete({
		source: function(request, response) {
			$.ajax({
				dataType: "json",
				url: "?action=fetchCities",
				type: "post", 
				data: {'COUNTRY': $('#country :selected').val()},
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

	
    $("#dateIn").datepicker();

    $("#goSearch").click(function() {
    	console.log($('#search').serialize());
    })


});
