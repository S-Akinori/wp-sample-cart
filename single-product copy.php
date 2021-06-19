<?php get_header(); ?>
<article>
    <div class="container">
        <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <h1 class="text-center">【<?php the_title(); ?>】<?= get_the_category()[0]->name; ?></h1>
        <div class="d-none img-container">
            <img src="<?php echo get_template_directory_uri(); ?>/img/sample-image.jpg" alt="">
        </div>
        <video class="mt-3" src="<?= get_template_directory_uri(); ?>/dist/video/sample-movie.mp4" controls></video>
        <div class="my-3 row">
            <div class="col-3">
                <img src="<?php echo get_template_directory_uri(); ?>/img/sample-image.jpg" alt="">
            </div>
            <div class="col-3">
                <img src="<?php echo get_template_directory_uri(); ?>/img/sample-image.jpg" alt="">
            </div>
            <div class="col-3">
                <img src="<?php echo get_template_directory_uri(); ?>/img/sample-image.jpg" alt="">
            </div>
            <div class="col-3">
                <img src="<?php echo get_template_directory_uri(); ?>/img/sample-image.jpg" alt="">
            </div>
        </div>

        <section class="my-3">
            <h2 class="text-gray text-lg">
                <i class="fas fa-video"></i> <?php the_title(); ?> <br>
                <span class="text-sm"><?= get_the_category()[0]->name; ?></span>
            </h2>

            <section>
                <h3><i class="far fa-hand-point-right"></i> ムービーの特徴</h3>
                <?php the_content(); ?>
            </section>

            <section>
                <h3><i class="fas fa-film"></i> 商品内容</h3>
            </section>
        </section>
        <?php endwhile; endif ?>

        <div>
            <p>料金</p>
            <p><?php echo get_post_meta($post->ID, 'product', true)['price']; ?></p>
            <input type="hidden" name="csrf_token" id="csrfToken" value="<?= session_id(); ?>">
            <button id="addProductButton" class="btn btn-success">カートに追加</button>
            <p id="message"></p>
        </div>
    </div>
</article>
<?php get_footer(); ?>