<?php get_header(); ?>
<article>
    <div class="container">
        <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <div class="row">
            <div class="col-6">
                <?php if(has_post_thumbnail()) : ?>
                <div class="img-container thumbnail">
                    <img src="<?= get_the_post_thumbnail_url('', 'full') ?>" alt="<?php the_title(); ?>">
                </div>
                <?php endif; ?>
            </div>
            <div class="col-6">            
                <h1 class="text-center"><?php the_title(); ?></h1>
                <section>
                    <?php the_content(); ?>
                </section>
                <section>
                    <p>料金 : <?php echo get_post_meta($post->ID, 'product', true)['price']; ?>円</p>
                    <input type="hidden" name="csrf_token" id="csrfToken" value="<?= session_id(); ?>">
                    <button id="addProductButton" class="btn btn-success">カートに追加</button>
                    <p id="message"></p>
                </section>
            </div>
        </div>
        <?php endwhile; endif ?>
    </div>
</article>
<?php get_footer(); ?>