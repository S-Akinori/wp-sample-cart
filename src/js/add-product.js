const { ajax } = require("jquery");

jQuery(function($) {
    $('#addProductButton').on('click', function() {
        $thisButton = $(this);
        $thisButton.attr('disabled', true);
        $.ajax({
            type: "POST",
            url: ajax_script.url,
            data: {
                'action' : 'add_product',
                'product' : product,
                'csrf_token' : csrfToken.value
            },
            dataType: "json"
        }).done(function(data) {
            // for(var key in data) {
            //     console.log(data[key]);
            // }
            console.log(data);
            console.log('done...');
            if(data == 0) {
                $('#message').text('すでに商品が追加されています。');
            } else {
                $('#message').text('商品を追加しました。');
            }
            $thisButton.attr('disabled', false);
        }).fail(function(XMLHttpRequest, textStatus, error) {
            console.log(error);
            console.log(XMLHttpRequest.responseText);
            $thisButton.attr('disabled', false);
        });
    });

    $('.delete-product-button').on('click', function() {
        $thisButton = $(this);
        $thisButton.attr('disabled', true);
        $.ajax({
            type: "POST",
            url: ajax_script.url,
            data: {
                'action' : 'delete_product',
                'product_id' : $thisButton.val(),
                'csrf_token' : csrfToken.value
            },
            dataType: "json"
        }).done(function(data) {
            console.log(data);
            console.log('done...');
            document.location.reload();
        }).fail(function(XMLHttpRequest, textStatus, error) {
            console.log(error);
            console.log(XMLHttpRequest.responseText);
            $thisButton.attr('disabled', false);
        });
    });
});