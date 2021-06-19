<?php get_header(); ?>
<article>
    <div class="container">
        <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <h1 class="text-base"><?php the_title(); ?></h1>
        <div class="img-container">
            <img src="<?php echo get_template_directory_uri(); ?>/img/sample-image.jpg" alt="">
        </div>
        <div>
            <?php the_content(); ?>
        </div>
        <?php endwhile; endif ?>
    </div>
</article>
<?php get_footer(); ?>