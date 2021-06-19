<?php get_header(); ?>
<div class="container">
    <h2 class="title">記事一覧</h2>
    <div class="row">
        <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
            <div class="col-6 col-md-4">
                <div class="post position-relative">
                    <div class="img-container">
                        <img src="<?= has_post_thumbnail() ? get_the_post_thumbnail_url('', 'full') : get_template_directory_uri() . '/img/sample-image.jpg' ?>" alt="<?php the_title(); ?>">
                    </div>
                    <div class="mx-2">
                        <h2 class="title"><?php the_title() ?></h2>
                        <!-- <p class="description">ここに抜粋文が入ります。だいたい100文字くらいかな？</p> -->
                    </div>
                    <a href="<?php the_permalink() ?>" class="stretched-link"></a>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>
</div>
<?php get_footer(); ?>