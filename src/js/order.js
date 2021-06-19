jQuery(function($) {
    const informationBy = [
        {'value': 'ネット検索（Google、Yahoo!など）', 'id': 'internet'},
        {'value': 'Instagram', 'id': 'instagram'},
        {'value': 'Facebook', 'id': 'faceBook'},
        {'value': 'YouTube', 'id': 'youtube'},
        {'value': 'ブログ', 'id': 'blog'},
        {'value': '覚えていない', 'id': 'unclear'},
        {'value': 'その他', 'id': 'other'},
    ]


    $('#shippingAddressCheck').on('click', function() {
        if(!$(this).prop('checked')) {
            $('#shippingAddressForm').removeClass('d-none');
            $('#shippingZip').addClass('required number');
            $('#shippingAddress').addClass('required');
        } else {
            $('#shippingAddressForm').addClass('d-none');
            $('#shippingZip').removeClass('required number');
            $('#shippingAddress').removeClass('required');
        }
    })

    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        $('#submitButton').attr('disabled', true);
        var formData = new FormData(e.target);
        var errors = validation(formData);
        $('.error').text('');
        if(Object.keys(errors).length !== 0) {
            for(var key in errors) {
                var strArray = key.split('_');
                
                for(var i = 0 ; i < strArray.length ; i++) {
                    if(i == 0) {
                        continue;
                    }
                    strArray[i] = strArray[i][0].toUpperCase() + strArray[i].slice(1);
                }
                var keyForId = strArray.join('') + 'Error';
                // delete Object.assign(errors, {[keyForId]: errors[key]})[key];
                $(`#${keyForId}`).text(errors[key]);
            }
            $('#submitButton').attr('disabled', false);
            $('#message').text('入力に誤りがあります。');
            return;
        }

        formData.append('action', 'save_profile');
        $.ajax({
            type: "POST",
            url: ajax_script.url,
            data: formData,
            processData: false,
            contentType: false,
            // dataType: "json"
        }).done(function(data) {
            console.log(data);
            console.log('done...');
            window.location.href = data;
        }).fail(function(XMLHttpRequest, textStatus, error) {
            console.log(error);
            console.log(XMLHttpRequest.responseText);
            $('#submitButton').attr('disabled', false);
        });
    });
});

function validation(formData) {
    var errors = {};
    var regex = null;
    for(var item of formData) {
        var key = item[0];
        var value = item[1];

        $el = $(`input[name='${key}']`);
        if($el.hasClass('required') && !value) { // 必須項目のバリデーション
            errors[key] = 'この項目は入力必須です。';
        }
        else if($el.hasClass('number')) {
            regex = /^[0-9]+$/;
            if(!regex.test(value)) {
                errors[key] = '数値のみで入力してください。';
            }
        }
        else if($el.hasClass('katakana')) {
            regex = /^[ァ-ンヴー]*$/;
            if(!regex.test(value)) {
                errors[key] = 'カタカナで入力してください。';
            }
        }
        else if($el.hasClass('email')) {
            regex = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
            if(!regex.test(value)) {
                errors[key] = '無効なメールアドレスです。';
            }
        }
        else if($el.hasClass('email-confirmation') && formData.get('email') !== value) {
            errors[key] = 'メールアドレスが一致していません。';
        }
    }

    return errors;
}