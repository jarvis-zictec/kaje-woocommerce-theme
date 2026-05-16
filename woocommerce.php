<?php get_header(); ?>
<section class="page-hero compact">
    <div class="container">
        <span class="eyebrow">Loja KAJE</span>
        <h1><?php function_exists( 'woocommerce_page_title' ) ? woocommerce_page_title() : the_title(); ?></h1>
        <p>Serviços administrativos e consultivos com compra online e confirmação humana antes da execução.</p>
    </div>
</section>
<section class="content-section">
    <div class="container">
        <?php if ( function_exists( 'woocommerce_content' ) ) { woocommerce_content(); } else { while ( have_posts() ) : the_post(); the_content(); endwhile; } ?>
    </div>
</section>
<?php get_footer(); ?>
