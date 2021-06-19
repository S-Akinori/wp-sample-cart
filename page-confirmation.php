<?php get_header(); ?>
<div class="container">
    <h1 class="text-md text-center">申し込み確認</h1>
    <p>
        ご注文内容・お客様情報をご入力いただき、お間違いがないかご確認してから送信ボタンを押してください。<br>
        お申込み内容を確認後、担当者よりご連絡させていただきます。
    </p>
    <section class="mb-4">
        <h2 class="form-title">ムービー</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">商品情報</th>
                    <th scope="col">値段 (円)</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['order']['products'] as $key => $value) : ?>
                <tr>
                    <td>
                        <p><?= esc_html($value['name']) ?></p>
                        <div class="img-container w-60">
                            <img src="<?= $value['thumbnail'] ?>" alt="<?= esc_html($value['name']) ?>">
                        </div>
                    </td>     
                    <td><?= esc_html(number_format($value['price'])) ?></td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td>セット割</td>
                    <td>
                        -<?= esc_html(number_format($_SESSION['order']['discount_set'])); ?>
                    </td>
                </tr>             
            </tbody>
        </table>

        <div>
            <p>挙式日（上映日） : <?= esc_html($_SESSION['order']['wedding_date']); ?> </p>
        </div>

        <div>
            <p>DVDデザイン : <?= esc_html($_SESSION['order']['design']); ?></p>
        </div>

        <div>
            <p>お支払い方法 : <?= esc_html($_SESSION['order']['payment']); ?></p>
        </div>

        <div>
            <p>合計金額 : <?= esc_html(number_format($_SESSION['order']['defined_price'])); ?>円</p>
        </div>
    
    </section>

    <section class="mb-4">
        <p class="form-title">お名前</p>
        <div>
            <p>お名前 : <?= esc_html($_SESSION['order']['profile']['name']); ?></p>
        </div>
        <div class="mt-2">
            <p>フリガナ : <?= esc_html($_SESSION['order']['profile']['name_kana']); ?></p>
        </div>
    </section>

    <section class="mb-4">
        <p class="form-title">メールアドレス</p>
        <p><?= esc_html($_SESSION['order']['profile']['email']); ?></p>
    </section>
    <section class="mb-4">
        <p class="form-title">電話番号</p>
        <p><?= esc_html($_SESSION['order']['profile']['tel']); ?></p>
    </section>
    <section class="mb-4">
        <p class="form-title">住所</p>
        <div>
            <p>郵便番号 : <?= esc_html($_SESSION['order']['profile']['zip']); ?></p>
        </div>
        <div class="mt-2">
            <p>住所 : <?= esc_html($_SESSION['order']['profile']['address']); ?></p>
        </div>

        <div class="mt-2">
            <?php if($_SESSION['order']['profile']['shipping_address_check'] == 'on') : ?>
                <p>＊上記の住所に商品を届ける</p>
            <?php else : ?>
            <div>
                <div>
                    <p>郵便番号 : <?= esc_html($_SESSION['order']['profile']['shipping_zip']); ?></p>
                </div>
                <div class="mt-2">
                    <p>住所 : <?= esc_html($_SESSION['order']['profile']['shipping_address']); ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="mb-4">
        <p class="form-title">その他</p>
        <div class="border-bottom">
            <p class="mb-1">LCMアトリエを知ったきっかけ</p>
            <p><?= esc_html($_SESSION['order']['profile']['information_by']); ?></p>
        </div>
        <div>
            <p class="mb-1">備考</p>
            <p><?= esc_html($_SESSION['order']['profile']['note']); ?></p>
        </div>
    </section>

    <div class="button-group">
        <a href="<?= home_url('order') ?>" class="btn btn-info">戻る</a>
        <input type="hidden" name="csrf_token" id="csrfToken" value="<?= session_id(); ?>">
        <button id="cofirmOrderButton" class="btn bg-green submit-button">申し込みを確定</button>
    </div>
</div>
<?php get_footer() ?>