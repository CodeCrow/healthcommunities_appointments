(function($) {
$('document').ready(function(){    
    /* Appointment Request Form */
    $('#form-container').load('https://www.healthcommunities-appointments.com/app/hifuny #AppointmentIndexForm', function() {
        var $form = $('#AppointmentIndexForm'),
            action = $form.attr('action'),
            $ns = $form.find('noscript'),
            $p = $ns.parent(),
            html = $ns.text();
        $p.append('<legend>reCAPTCHA anti-spam</legend>');
        $p.append('<div id="recaptcha" />');
        key = html.match(/k=(.+?)"/)[1];
        Recaptcha.create(key, "recaptcha", {theme: "red"});

        action = 'https://www.healthcommunities-appointments.com' + action;
        $form.attr('action', action);
        $form.on('submit', function(ev){
            ev.preventDefault();
            $('#form-container .index, #flashMessage').remove();
            $form.find('input[type="submit"]').attr('disabled', 'disabled');
            $form.find('.submit').append($('<span> Your request is being processed…</span>'));
        }).on('submit.ajax', function(){
            $.post(action, $form.serialize(), function(result){
                var $html = $($.parseHTML(result));
                $form.find('.submit span').fadeOut(400);
                $html.find('#content .index, #flashMessage').appendTo('#form-container').hide().slideDown(400);
                if($('#flashMessage').length) {
                    $form.find('input[type="submit"]').removeAttr('disabled');
                    Recaptcha.reload();
                    if(! $('#flashMessage').text().match(/The reCAPTCHA/)) {
                        $('#flashMessage').text('Your request could not be processed. Please check the required Contact Information fields and try again.');
                    }
                } else if($('#form-container > .index').text().match(/Thank you/)) {
                    $('#form-container .index').html('Thank you for requesting an appointment!<br />Someone on our staff will respond to you soon.');
                    if(typeof sourcePg != 'undefined') sourcePg = encodeURIComponent(sourcePg);
                    window.location = 'http://www.hifuny.com/thank-you#' + sourcePg;
                }
            });
        });
    });
    
    
/* NEW Request Form */
   
    $('#request-form-container').load('https://www.healthcommunities-appointments.com/app/hifuny/contact #AppointmentContactForm', function() {
        var $form = $('#AppointmentContactForm'),
            action = $form.attr('action'),
            $ns = $form.find('noscript'),
            $p = $ns.parent(),
            html = $ns.text();

        action = 'https://www.healthcommunities-appointments.com' + action;
        console.log(action);
        $form.attr('action', action);
        $form.on('submit', function(ev){
            ev.preventDefault();
            $('#request-form-container .index, #flashMessage').remove();
            $form.find('input[type="submit"]').attr('disabled', 'disabled');
            $form.find('.submit').append($('<span> Your request is being processed…</span>'));
        }).on('submit.ajax', function(){
            $.post(action, $form.serialize(), function(result){
                var $html = $($.parseHTML(result));
                $form.find('.submit span').fadeOut(400);
                $html.find('#content .index, #flashMessage').appendTo('#request-form-container').hide().slideDown(400);
                if($('#flashMessage').length) {
                    $form.find('input[type="submit"]').removeAttr('disabled');
                    $('#flashMessage').text('Your request could not be processed. Please check the required Contact Information fields and try again.');
                
                } else if($('#request-form-container > .index').text().match(/Thank you/)) {
                    $('#request-form-container .index').html('Thank you for requesting an appointment!<br />Someone on our staff will respond to you soon.');
                    if(typeof sourcePg != 'undefined') sourcePg = encodeURIComponent(sourcePg);
                    window.location = 'http://www.hifuny.com/thank-you#' + sourcePg;
                }
            });
        });
    });

}); // end document ready
})(jQuery);