<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>Title</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
        <?php
            wp_deregister_script('jquery');
            wp_enqueue_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js", array(), '3.3.1');
            ?>
        <?php wp_head(); ?>
    </head>
    <body>
        <header class="border-bottom mx-3 d-flex align-items-center justify-content-between">
            ECカート機能 - テスト
            <div>
                <a href="<?= home_url('product'); ?>">商品</a>
                <a href="<?= home_url().'/cart'?>"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </header>

        <main class="my-5">