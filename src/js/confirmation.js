jQuery(function($) {
    $('#cofirmOrderButton').on('click', function() {
        $thisButton = $(this);
        $thisButton.attr('disabled', true);
        $.ajax({
            type: "POST",
            url: ajax_script.url,
            data: {
                'action' : 'store_order_in_db',
                'csrf_token' : csrfToken.value
            }
            // dataType: "json"
        }).done(function(data) {
            console.log(data);
            window.location.href = data;
        }).fail(function(XMLHttpRequest, textStatus, error) {
            console.log(error);
            console.log(XMLHttpRequest.responseText);
            $thisButton.attr('disabled', false);
        });
    })
})