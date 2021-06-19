<?php get_header(); ?>
<div class="container">
    <h1 class="text-md text-center mb-5">商品カート</h1>
    <p>
    各商品詳細ページよりご希望の商品をショッピングカートに入れ、お申込み手続きへお進みください。<br>
    ご注文内容・お客様情報をご入力いただき、お間違いがないかご確認ください。
    </p>
    <div class="border border-dark p-4 mb-5">
        <p class="mb-3"><i class="fas fa-bookmark fa-lg text-gray"></i> <span class="border-bottom-gray font-weight-bold">ご注文に関する注意事項</span></p>
        <ul class="pl-4">
            <li>お申込みされる前に、利用規約をお読みください。</li>
            <li>
                お申込み完了後、弊社より自動返信メールをお送りいたします。<br>
                <span class="text-gray font-weight-bold">その後、24時間以内に担当者から映像制作の流れを記載したメールを送信いたします。</span><br>
                必ずお申込みの前にメール設定をご確認いただき、弊社ドメイン「@lcm-atelier.com」からのメールを受信できるよう設定してください。
            </li>
        </ul>
    </div>
    <div>
        <section class="mb-3 border-bottom">
            <h2 class="form-title">ムービー</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">商品情報</th>
                        <th scope="col">値段 (円)</th>
                        <th scope="col">変更</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($_SESSION['order']['products'])) : foreach ($_SESSION['order']['products'] as $key => $value) : ?>
                    <tr>
                       <td>
                            <p><?= $value['name'] ?></p>
                            <div class="img-container w-60">
                                <img src="<?= esc_html($value['thumbnail']); ?>" alt="<?= esc_html($value['name']); ?>">
                            </div>
                       </td>
                       <td><?= esc_html(number_format($value['price'])); ?></td>     
                       <td><button class="btn btn-secondary delete-product-button" value="<?= esc_html($value['id']); ?>">取り消し</button></td>     
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td>商品がありません</td>
                        <td>-</td>
                        <td></td>
                    </tr>
                <?php endif ?>   
                    <tr>
                        <td>セット割</td>
                        <td>
                            -<?= esc_html(number_format($_SESSION['order']['discount_set'])); ?>
                        </td>
                        <td></td>
                    </tr>             
                </tbody>
            </table>
    
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <a href="<?= esc_html(home_url('product')); ?>" class="btn btn-primary">商品を探す</a>
                <p class="bg-gray-light px-1 py-3 text-center"><span class="mr-3">小計</span> <?= esc_html( number_format($_SESSION['order']['total'] - $_SESSION['order']['discount_set'])); ?> 円（税込）</p>
            </div>
        </section>

        <section class="mb-3 border-bottom">
            <div class="row">
                <div class="col-md-2 font-weight-bold mb-3 mb-md-0">
                    挙式日（上映日） *
                </div>
                <div class="col-9 col-md-8">
                    <input type="text" name="wedding_date" class="form-control" id="datepicker" value="<?= esc_html( $_SESSION['order']['wedding_date']) ?>">
                    <p id="messageForDate" class="text-danger"></p>
                </div>
                <div class="col-3 col-md-2 text-right" id="discountEarly">
                    <?= esc_html( $_SESSION['order']['discount_early']); ?>円
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 font-weight-bold mb-3 mb-md-0">
                    仮スケジュール
                </div>
                <div class="col-md-8">
                    <p class="text-success">
                        営業時間内(9時〜20時)までにご対応いただいた場合のスケジュールです。<br>
                        通常制作では、映像素材が揃ってから納品まで約２週間(特急制作の場合は1週間)が目安となります。<br>
                        お早めに納品をご希望の場合は、映像素材のご提出が早いほど納品の前倒しが可能になります。
                    </p>
                    <div class="mb-3">
                        <p class="border border-info rounded py-2 px-1 m-0">映像素材ご提出期日 : <span id="deadlineForSubmit"><?= esc_html( $_SESSION['order']['date_for_discount']) ?></span></p>
                        <p class="text-success">上記の期限までにすべての映像素材をご提出いただけないと特急制作料5,500円（税込）が発生します。</p>
                    </div>
                    <div class="mb-3">
                        <p class="border border-info rounded py-2 px-1 m-0">Webでの確認映像ご案内日 : 映像素材ご提出日より8日前後</p>
                    </div>
                    <div class="mb-3">
                        <p class="border border-info rounded py-2 px-1 m-0">納品予定日 : 映像素材ご提出日より2週間前後</p>
                        <p class="text-success">お客様からの修正の有無のご連絡や修正内容、修正回数により納品日は変わります。</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="design-section mb-3 border-bottom">
            <div class="row">
                <div class="col-md-2 font-weight-bold mb-3 mb-md-0">
                    DVDデザイン *
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="design" id="simple" value="シンプル" <?= ($_SESSION['order']['design'] == 'シンプル') ? 'checked' : null ?> />
                                <label for="simple" class="form-check-label">
                                    <img src="<?= get_template_directory_uri(); ?>/img/simple2019.png" alt="シンプル">
                                    <p>シンプル</p>
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="design" id="popA" value="ポップA" <?= ($_SESSION['order']['design'] == 'ポップA') ? 'checked' : null ?> />
                                <label for="popA" class="form-check-label">
                                    <img src="<?= get_template_directory_uri(); ?>/img/popa2019.png" alt="ポップA">
                                    <p>ポップA</p>
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="design" id="popB" value="ポップB" <?= ($_SESSION['order']['design'] == 'ポップB') ? 'checked' : null ?> />
                                <label for="popB" class="form-check-label">
                                    <img src="<?= get_template_directory_uri(); ?>/img/popb2019.png" alt="ポップB">
                                    <p>ポップB</p>
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="design" id="modernA" value="モダンA" <?= ($_SESSION['order']['design'] == 'モダンA') ? 'checked' : null ?> />
                                <label for="modernA" class="form-check-label">
                                    <img src="<?= get_template_directory_uri(); ?>/img/moderna2019.png" alt="モダンA">
                                    <p>モダンA</p>
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="design" id="modernB" value="モダンB" <?= ($_SESSION['order']['design'] == 'モダンB') ? 'checked' : null ?> />
                                <label for="modernB" class="form-check-label">
                                    <img src="<?= get_template_directory_uri(); ?>/img/modernb2019.png" alt="モダンB">
                                    <p>モダンB</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="payment-section mb-3">
            <div class="row">
                <div class="col-md-2 font-weight-bold mb-3 mb-md-0">
                    お支払い方法 *
                </div>
                <div class="col-9 col-md-8">
                    <select name="payment" id="payment" class="form-control ">
                        <option value="銀行振込" <?= ($_SESSION['order']['payment'] == 'bank') ? 'selected' : null ?>>銀行振込</option>
                        <option value="代金引換" <?= ($_SESSION['order']['payment'] == 'cash') ? 'selected' : null ?>>代金引換</option>
                    </select>
                </div>
                <div class="col-3 col-md-2 text-right" id="discountEarly">
                    <p class="text-right" id="paymentCharge"><?= esc_html( $_SESSION['order']['payment_charge']); ?> 円</p>
                </div>
            </div>
        </section>

        <div class="bg-gray-light w-60 ml-auto px-1 py-3 mb-3">
            <p class="m-0"><span class="mr-3">合計</span> <span id="totalPrice"></span> 円（税込）</p>
            <p class="m-0"><span class="mr-3">送料</span> <span id="deliveryCharge"><?= esc_html( $_SESSION['order']['delivery_charge']); ?></span> 円</p>
        </div>

        <input type="hidden" name="csrf_token" id="csrfToken" value="<?= session_id(); ?>">

        <?php if(!empty($_SESSION['order']['products'])): ?>
            <div class="text-right">
                <button id="submitCartButton" class="btn bg-green submit-button">申し込みへ進む</button>
            </div>
        <?php endif; ?>
        <p class="text-danger" id="errorMessage"></p>
    </div>
</div>

<?php get_footer() ?>