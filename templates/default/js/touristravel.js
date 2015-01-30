jQuery(document).ready(function($) {
	"use strict";
	var touristtravel_find = $('.touristtravel-find');
	var touristtravel_content = $('.touristtravel-content');
	
	var datetime = {timepicker:false};
	var datetime_format = touristtravel_find.attr('data-format');
	
	datetime.format = (datetime_format != undefined && datetime_format != '') ? datetime_format : 'Y/m/d' ;
	
	$('.date').datetimepicker(datetime);
	
	touristtravel_find.on('click', '.search', function() {
		var keyword = touristtravel_find.find('input.keyword').val();
		var start_date = touristtravel_find.find('input.start-date').val();
		var end_date = touristtravel_find.find('input.end-date').val();
		var budgets = touristtravel_find.find('input.budgets').val();
		touristtravel_content.find('.content').css('opacity', '0.3');
		touristtravel_content.find('.loading').css('display', 'block');
		$.post(adminajax.ajax_url, {
			'action' : 'touristtravel_search',
			'data' : {
				'keyword' : keyword,
				'start_date' : start_date,
				'end_date' : end_date,
				'budgets': budgets
			}
		}, function(response) {
			touristtravel_content.find('.content').html(response).css('opacity', '1');
			touristtravel_content.find('.loading').css('display', 'none');
		});
	});
});