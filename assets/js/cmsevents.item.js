jQuery(document).ready(function($){
	/** Tabs */
	$('.easytabs').easytabs();
	/** Input date time */
	$('.input-datetime').datetimepicker();
	
	no_location($('#cmsevent_no_location'));
	$('#cmsevent_no_location').click(function(){
		no_location($(this));
	});
	
	function no_location(elem){
		if(elem.is( ":checked" )){
			$('#events_location').css('display','none');
		} else {
			$('#events_location').css('display','block');
		}
	}
});