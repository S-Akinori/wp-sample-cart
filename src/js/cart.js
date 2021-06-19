const { ajax } = require("jquery");

jQuery(function($) {
    // $('input[name="wedding_date"]').on('change', function() {
    //     console.log($(this).val());
    //     var weddingDate = $(this).val();
    //     $.ajax({
    //         type: "POST",
    //         url: ajax_script.url,
    //         data: {
    //             'action': 'store_wedding_date',
    //             'wedding_date': weddingDate
    //         },
    //     }).done(function(data) {
    //         console.log(data);
    //         $('#discountEarly').text((-data.discount_early).toLocaleString() + '円');
    //         $('#messageForDate').text(data.message);
    //         $('#deadlineForSubmit').text(data.deadline_for_submit);
    //     }).fail(function(XMLHttpRequest, textStatus, error) {
    //         console.log(error);
    //         console.log(XMLHttpRequest.responseText);
    //     });
    // });

    var totalProductPrice = 0;
    var discountEarly = 0;
    var paymentCharge = 0;
    var total = 0;
    var now = new Date();
    var weddingDate = null;
    var dateForDiscount = null
    var deliveryCharge = 0;

    $.ajax({
        type: 'GET',
        url: ajax_script.url,
        data: {
            'action': 'get_total_price',
        }
    }).done(function(data) {
        totalProductPrice = parseInt(data);
        setTotalPrice();
    }).fail(function(XMLHttpRequest, textStatus, error) {
        console.log(error);
        console.log(XMLHttpRequest.responseText);
    });

    $('input[name="wedding_date"]').on('change', function() {
        weddingDate = new Date($(this).val());
        var diffDay = Math.ceil((weddingDate - now) / 86400000);
        console.log(diffDay);
        var message = '';
        if(diffDay >= 70) {
            discountEarly = 2000;
            dateForDiscount = weddingDate;
            dateForDiscount.setDate(dateForDiscount.getDate() - 70);
            message = `<早割適応条件><br>${dateForDiscount.getFullYear()}年${dateForDiscount.getMonth()+1}月${dateForDiscount.getDate()}日までにすべての映像素材をご提出いただきますと早割特典の対象となります。`
        } else if(diffDay < 21) {
            discountEarly = -5500;
            message = `挙式日が迫っておりますので特急制作料が必要となります。`;
        } else {
            discountEarly = 0;
        }
        var deadline = weddingDate;
        deadline.setDate(deadline.getDate() - 21);
        $('#discountEarly').text((-discountEarly).toLocaleString() + '円')
        $('#messageForDate').html(message);
        $('#deadlineForSubmit').text(`${deadline.getFullYear()}年${deadline.getMonth()+1}月${deadline.getDate()}日`);
        setTotalPrice()
    });

    $('select[name="payment"]').on('change', function() {
        console.log($(this).val());
        if($(this).val() == '代金引換') {
            paymentCharge = 260;
        } else {
            paymentCharge = 0;
        }
        $('#paymentCharge').text(paymentCharge + '円');
        setTotalPrice()
    });

    $('#submitCartButton').on('click', function() {
        $(this).attr('disabled', true);
        if(
            !$('input[name="wedding_date"]').val() ||
            !$('input[name="design"]').val() ||
            !$('select[name="payment"]').val()
        ) {
            $('#errorMessage').text('*の項目は必須です。');
            $(this).attr('disabled', false);
            return
        }

        $.ajax({
        type: "POST",
        url: ajax_script.url,
        data: {
            'action': 'save_cart',
            'wedding_date' : $('input[name="wedding_date"]').val(),
            'design' : $('input[name="design"]').val(),
            'payment' : $('select[name="payment"]').val(),
            'payment_charge' : paymentCharge,
            'discount_early' : discountEarly,
            'delivery_charge' : deliveryCharge,
            'defined_price': total,
            'csrf_token' : csrfToken.value
        },
        }).done(function(data) {
            console.log(data);
            window.location.href = data;
        }).fail(function(XMLHttpRequest, textStatus, error) {
            $('#errorMessage').text(XMLHttpRequest.responseText);
            $(this).attr('disabled', false);
            console.log(error);
            console.log(XMLHttpRequest.responseText);
        });
    })

    function setTotalPrice() {
        total = totalProductPrice + paymentCharge - discountEarly;
        var lineForFree = 30000;
        if(total < lineForFree) {//合計が30,000円未満の場合は送料800円
            deliveryCharge = 800;
        } else {
            deliveryCharge = 0;
        }
        total += deliveryCharge;
        $('#totalPrice').text(total.toLocaleString());
        $('#deliveryCharge').text(deliveryCharge.toLocaleString());
    }
});
