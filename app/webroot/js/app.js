(function ($) {
    $(document).ready(function(){
        $("#AppointmentHealthInsurance").change(function(){
        	//console.log( $(this).children(":selected").val() );
        	if ("other_trigger" == $(this).children(":selected").val()){
	        	//console.log( $(".hio.hidden").text() );
        		$(".hio.hidden").css({visibility:'visible'}).slideDown('slow');
        	}
        });
    });
}(jQuery));