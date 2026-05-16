<?php get_header(); ?>
<section class="page-hero compact"><div class="container"><h1><?php bloginfo( 'name' ); ?></h1></div></section>
<section class="content-section"><div class="container narrow">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article <?php post_class( 'post-card' ); ?>><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php the_excerpt(); ?></article>
<?php endwhile; the_posts_pagination(); else : ?><p>Nenhum conteúdo encontrado.</p><?php endif; ?>
</div></section>
<?php get_footer(); ?>
