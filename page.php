<?php get_header(); ?>
<section class="page-hero compact"><div class="container"><h1><?php the_title(); ?></h1></div></section>
<section class="content-section"><div class="container narrow">
<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
</div></section>
<?php get_footer(); ?>
