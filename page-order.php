<?php get_header(); ?>
<div class="container">
    <h1 class="text-md text-center">申し込み</h1>
    <p>
        ご注文内容・お客様情報をご入力いただき、お間違いがないかご確認してから送信ボタンを押してください。<br>
        お申込み内容を確認後、担当者よりご連絡させていただきます。
    </p>
    <form id="profileForm" name="profile_form">
        <div class="form-group">
            <p class="form-title">お名前</p>
            <div>
                <label for="name">お名前</label>
                <input type="text" name="name" id="name" class="form-control required" value="<?= esc_html( $_SESSION['order']['profile']['name']); ?>">
                <p class="error" id="nameError"></p>
            </div>
            <div class="mt-2">
                <label for="name_kana">フリガナ</label>
                <input type="text" name="name_kana" id="name_kana" class="form-control required katakana" value="<?= esc_html( $_SESSION['order']['profile']['name_kana']); ?>">
            </div>
            <p class="error" id="nameKanaError"></p>
        </div>
        <div class="form-group">
            <p class="form-title">メールアドレス</p>
            <input type="email" name="email" id="email" class="form-control required email" value="<?= esc_html( $_SESSION['order']['profile']['email']); ?>">
            <p class="error" id="emailError"></p>
            <div>
                <label for="emailConfirmation">確認のためもう一度入力してください</label>
                <input type="email" name="email_confirmation" id="emailConfirmation" class="form-control required email-confirmation">
                <p class="error" id="emailConfirmationError"></p>
            </div>
        </div>
        <div class="form-group">
            <p class="form-title">電話番号</p>
            <input type="tel" name="tel" class="form-control required number" value="<?= esc_html( $_SESSION['order']['profile']['tel']); ?>">
            <p class="text-sm">ハイフン(-)なしで入力</p>
            <p class="error" id="telError"></p>
        </div>
        <div class="form-group">
            <p class="form-title">住所</p>
            <div>
                <label for="zip">郵便番号</label>
                <input type="text" name="zip" id="zip" class="form-control required number" onKeyUp="AjaxZip3.zip2addr('zip', '', 'address', 'address');" value="<?= esc_html( $_SESSION['order']['profile']['zip']); ?>">
                <p class="error" id="zipError"></p>
            </div>
            <div class="mt-2">
                <label for="address">住所</label>
                <input type="text" name="address" id="address" class="form-control required" value="<?= esc_html( $_SESSION['order']['profile']['address']); ?>">
                <p class="error" id="addressError"></p>
            </div>

            <div class="mt-2">
                <input type="checkbox" class="form-check-control" name="shipping_address_check" id="shippingAddressCheck" checked>
                <label for="shippingAddressCheck">上記の住所に商品を届ける</label>
                <div class="d-none" id="shippingAddressForm">
                    <p>お届け先住所を入力してください。</p>
                    <div>
                        <label for="shippingZip">郵便番号</label>
                        <input type="text" name="shipping_zip" id="shippingZip" class="form-control" onKeyUp="AjaxZip3.zip2addr('shipping_zip', '', 'shipping_address', 'shipping_address');" value="<?= esc_html( $_SESSION['order']['profile']['shipping_zip']); ?>" pattern="^[0-9]+$">
                        <p class="error" id="shippingZipError"></p>
                    </div>
                    <div class="mt-2">
                        <label for="address">住所</label>
                        <input type="text" name="shipping_address" id="shippingAddress" class="form-control" value="<?= esc_html( $_SESSION['order']['profile']['shipping_address']); ?>">
                        <p class="error" id="shippingAddressError"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <p class="form-title">その他</p>
            <div class="border-bottom">
                <p>LCMアトリエを知ったきっかけ</p>
                <div id="formInformationBy">
                    <div class="form-check">
                        <input type="radio" name="information_by" id="internet" class="form-check-control" value="ネット検索（Google、Yahoo!など）" checked/>
                        <label for="internet" class="form-check-label">ネット検索（Google、Yahoo!など）</label> 
                    </div>
                    <div class="form-check">
                        <input type="radio" name="information_by" id="instagram" class="form-check-control" value="Instagram" <?= ($_SESSION['order']["profile"]["information_by"] == 'Instagram') ? 'checked' : null ?> />
                        <label for="instagram" class="form-check-label">Instagram</label> 
                    </div>
                    <div class="form-check">
                        <input type="radio" name="information_by" id="faceBook" class="form-check-control" value="FaceBook" <?= ($_SESSION['order']["profile"]["information_by"] == 'FaceBook') ? 'checked' : null ?> />
                        <label for="faceBook" class="form-check-label">FaceBook</label> 
                    </div>
                    <div class="form-check">
                        <input type="radio" name="information_by" id="youtube" class="form-check-control" value="YouTube" <?= ($_SESSION['order']["profile"]["information_by"] == 'YouTube') ? 'checked' : null ?> />
                        <label for="youtube" class="form-check-label">YouTube</label> 
                    </div>
                    <div class="form-check">
                        <input type="radio" name="information_by" id="blog" class="form-check-control" value="ブログ" <?= ($_SESSION['order']["profile"]["information_by"] == 'ブログ') ? 'checked' : null ?> />
                        <label for="blog" class="form-check-label">ブログ</label> 
                    </div>
                    <div class="form-check">
                        <input type="radio" name="information_by" id="unclear" class="form-check-control" value="覚えていない" <?= ($_SESSION['order']["profile"]["information_by"] == '覚えていない') ? 'checked' : null ?> />
                        <label for="unclear" class="form-check-label">覚えていない</label> 
                    </div>
                    <div class="form-check">
                        <input type="radio" name="information_by" id="other" class="form-check-control" value="その他" <?= ($_SESSION['order']["profile"]["information_by"] == 'その他') ? 'checked' : null ?> />
                        <label for="other" class="form-check-label">その他</label> 
                    </div>
                    <p class="error" id="informationByError"></p>
                </div>
            </div>
            <div>
                <p>備考</p>
                <div>
                    <p>以下の内容がございましたらご入力ください。</p>
                    <ul>
                        <li>ご質問やご相談</li>
                        <li>事前にお問い合わせをした日時、内容（具体的に）</li>
                        <li>お引越しの予定日、新しいご住所</li>
                    </ul>
                    <textarea name="note" id="note" rows="5" class="form-control"><?= esc_html($_SESSION['order']['profile']['note']); ?></textarea>
                </div>
            </div>
        </div>

        <div class="button-group">
            <a href="<?= home_url('cart') ?>" class="btn btn-info">戻る</a>
            <input type="hidden" name="csrf_token" id="csrfToken" value="<?= session_id(); ?>">
            <button type="submit" id="submitButton" class="btn bg-green submit-button">次へ</button>
        </div>
        <p id="message" class="error"></p>
    </form>
</div>
<?php get_footer() ?>