<?php
/*【表示カスタマイズ】アイキャッチ画像の有効化 */
add_theme_support( 'post-thumbnails' );

function create_post_type() {
    register_post_type('product', [ //投稿タイプ名
        'labels' => [
            'name' => '商品', // 管理画面上の名前
            'singular_name' => 'product', // カスタム投稿の識別名
        ],
        'public' => true, //投稿タイプをpublicにする
        'has_archive' => true, //アーカイブ機能をオン
        'menu_position' => 5, // 管理画面上での配置場所
        'supports' => array('title','editor','thumbnail','excerpt'),
    ]);
    register_taxonomy_for_object_type('category', 'product');
}
add_action('init', 'create_post_type');

function add_product_fields() {
    add_meta_box('product_setting', '商品情報', 'insert_product_fields', 'product', 'normal');
}
add_action('admin_menu', 'add_product_fields');

// カスタムフィールドの入力エリア
function insert_product_fields() {
    global $post;

    $data = get_post_meta($post->ID, 'product', true);

    echo '<div>名前 : <input type="text" name="product_name" size="50" value="'.$data['name'].'" /></div>';
    echo '<div style="margin-top: 15px">価格 : <input type="number" name="product_price" min="0" value="'.$data['price'].'" />円 </div>';
    echo '<div style="margin-top: 15px">概要 : <input type="text" name="product_description" size="100" value="'.$data['description'].'" /></div>';
}

// カスタムフィールドの値を保存
function save_product_fields($post_id) {
    if(empty($_POST['product_name'])) {
        $name = get_the_title($post_id);
    } else {
        $name = $_POST['product_name'];
    }
    $data = [
        'name' => $name,
        'price' => $_POST['product_price'],
        'description'  => $_POST['product_description']
    ];
    update_post_meta($post_id, 'product', $data);
}
add_action('save_post', 'save_product_fields');

function my_session_start() {
    if(session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}
add_action('init', 'my_session_start');

function my_enqueue() {
    // 特定のページのみで読み込む
    // Ajaxの処理を書いたjsの読み込み
    wp_enqueue_script( 'ajax-script', get_template_directory_uri().'/dist/main.js', array('jquery'), null, true );
    // 「ad_url.ajax_url」のようにしてURLを指定できるようになる
    wp_localize_script( 'ajax-script', 'ajax_script', array('url' => admin_url('admin-ajax.php')));
    if(is_singular('product')) {
        global $post;
        $data = get_post_meta($post->ID, 'product', true);
        wp_localize_script('ajax-script', 'product', array(
            'id' => $post->ID,
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'thumbnail' => get_the_post_thumbnail_url($post->ID, 'full'),
        ));
    }
    if(is_page('order')) {
        wp_enqueue_script('ajaxzip3', 'https://ajaxzip3.github.io/ajaxzip3.js', array('jquery'), null, true);
    }
}
add_action( 'wp_enqueue_scripts', 'my_enqueue' );

function check_csrf_token($token) {
    if($token !== session_id()) {
        wp_die('不正なリクエストです', 'error', array('response' => 400));
    }
}

//商品を追加
function add_product() {
    check_csrf_token($_POST['csrf_token']);
    $data = $_POST['product'];
    //商品項目がない場合は作成
    if(!array_key_exists('order', $_SESSION)) {
        $_SESSION['order'] = array();
        $_SESSION['order']['products'] = array();
        $_SESSION['order']['total'] = 0;
    }

    $item_exists = false;

    //すでにアイテムが存在しているかチェック
    foreach($_SESSION['order']['products'] as $num => $item) {
        if($item['id'] == $data['id']) {
            $item_exists = true;
            break;
        }
    }

    if($item_exists) { //商品がすでに存在している場合は追加しない
        echo 0;
    } else { //商品を追加し、総額も増加させる
        array_push($_SESSION['order']['products'], $data);
        $_SESSION['order']['total'] += $data['price'];
        if(count($_SESSION['order']['products']) >= 3) { //3セット割引
            $_SESSION['order']['discount_set'] = 5000;
        } else if(count($_SESSION['products']) >= 2) { //2セット割引
            $_SESSION['order']['discount_set'] = 3000;
        } else {
            $_SESSION['order']['discount_set'] = 0;
        }
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    
    wp_die();
}
// ログインしているユーザー向け関数
add_action( 'wp_ajax_add_product', 'add_product' );
// 非ログインユーザー用関数
add_action( 'wp_ajax_nopriv_add_product', 'add_product' );

//商品を削除
function delete_product() {
    check_csrf_token($_POST['csrf_token']);

    foreach($_SESSION['order']['products'] as $num => $item) {
        if($item['id'] == $_POST['product_id']) {
            array_splice($_SESSION['order']['products'], $num, 1);
            $_SESSION['order']['total'] -= $item['price'];
            break;
        }
    }

    if(count($_SESSION['order']['products']) >= 3) { //3セット割引
        $_SESSION['order']['discount_set'] = 5000;
    } else if(count($_SESSION['order']['products']) >= 2) { //2セット割引
        $_SESSION['order']['discount_set'] = 3000;
    } else {
        $_SESSION['order']['discount_set'] = 0;
    }

    echo 1;
}
// ログインしているユーザー向け関数
add_action( 'wp_ajax_delete_product', 'delete_product' );
// 非ログインユーザー用関数
add_action( 'wp_ajax_nopriv_delete_product', 'delete_product' );

// 申し込みの際のお客様情報
function save_profile() {
    check_csrf_token($_POST['csrf_token']);

    $_SESSION['order']['profile'] = $_POST;
    echo home_url('confirmation');
    wp_die();
}
// ログインしているユーザー向け関数
add_action( 'wp_ajax_save_profile', 'save_profile' );
// 非ログインユーザー用関数
add_action( 'wp_ajax_nopriv_save_profile', 'save_profile' );

function store_order_in_db() {
    check_csrf_token($_POST['csrf_token']);

    global $wpdb;
    $table_columns = ['products', 'created_at', 'name', 'name_kana', 'email', 'tel', 'zip', 'address', 'shipping_zip', 'shipping_address', 'wedding_date', 'design', 'payment', 'information_by', 'note', 'defined_price'];
    $products = '';
    $data = [];

    foreach ($_SESSION['order'] as $key => $value) {
        if($key == 'products') {
            foreach ($_SESSION['order']['products'] as $key => $value) {
                $products .= $value['name'] . ',';
            }
            $data['products'] = $products;
        } else if($key == 'profile') {
            foreach ($_SESSION['order']['profile'] as $key => $value) {
                if(!in_array($key, $table_columns)) continue;
                $data[$key] = $value;
            }
        } else {
            if(!in_array($key, $table_columns)) continue;
            $data[$key] = $value;
        }
    }

    $data['created_at'] = date("Y-m-d");
    $sql = $wpdb->prepare(
        "INSERT INTO $wpdb->order 
        (created_at,products, name, name_kana, email, tel, zip, address, shipping_zip, shipping_address, wedding_date, design, payment, information_by, note, defined_price) 
        values (%s, %s, %s, %s, %s, %s, %s, %s, %s ,%s, %s, %s, %s, %s, %s, %s)", 
        $data['created_at'],
        $data['products'],
        $data['name'],
        $data['name_kana'],
        $data['email'],
        $data['tel'],
        $data['zip'],
        $data['address'],
        $data['shipping_zip'],
        $data['shipping_address'],
        $data['wedding_date'],
        $data['design'],
        $data['payment'],
        $data['information_by'],
        $data['note'],
        $data['defined_price'],
    );
    $wpdb->query($sql);

    $mail_to = $data['email'];
    $subject = '申し込み完了のお知らせ';
    $mail_body = <<<EOM
        LCMアトリエです。商品の申し込みありがとうございました。
        内容を確認後改めて担当者よりご連絡をいたしますのでしばらくお待ちください。
    EOM;
    $headers[] = "Cc: ccemail@example.com";
    $headers[] = "Bcc: bccemail@example.com";
    wp_mail($mail_to, $subject, $mail_body, $headers);
    // unset($_SESSION['order']);
    echo home_url('complete');
    wp_die();
}
// ログインしているユーザー向け関数
add_action( 'wp_ajax_store_order_in_db', 'store_order_in_db' );
// 非ログインユーザー用関数
add_action( 'wp_ajax_nopriv_store_order_in_db', 'store_order_in_db' );

function save_cart() {
    check_csrf_token($_POST['csrf_token']);

    foreach ($_POST as $key => $value) {
        if($key == 'action') {
            continue;
        }
        $_SESSION['order'][$key] = $value;
    }
    $date = new DateTime($_POST['wedding_date']);
    $_SESSION['order']['date_for_discount'] = $date->format('Y/m/d');

    echo home_url('order');
    wp_die();
}
// ログインしているユーザー向け関数
add_action( 'wp_ajax_save_cart', 'save_cart' );
// 非ログインユーザー用関数
add_action( 'wp_ajax_nopriv_save_cart', 'save_cart' );

function get_total_price() {
    echo $_SESSION['order']['total'] - $_SESSION['order']['discount_set'];
    wp_die();
}
// ログインしているユーザー向け関数
add_action( 'wp_ajax_get_total_price', 'get_total_price' );
// 非ログインユーザー用関数
add_action( 'wp_ajax_nopriv_get_total_price', 'get_total_price' );

//stmp設定
// function setup_phpmailer_init($phpmailer) {
//     $phpmailer->isSMTP();
//     $phpmailer->Host = 'smtp.mailtrap.io';
//     $phpmailer->SMTPAuth = true;
//     $phpmailer->Port = 2525;
//     $phpmailer->Username = '84084526c91d6a';
//     $phpmailer->Password = '7b82571baf4a2d';
//     $phpmailer->From = "from@example.com";  
// }  
// add_action('phpmailer_init', 'setup_phpmailer_init');