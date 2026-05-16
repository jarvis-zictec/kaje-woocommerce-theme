<?php get_header(); ?>
<section class="page-hero compact">
    <div class="container">
        <span class="eyebrow">Loja KAJE Serviços</span>
        <h1><?php function_exists( 'woocommerce_page_title' ) ? woocommerce_page_title() : the_title(); ?></h1>
        <p>Contratação online para serviços administrativos e consultivos, com confirmação humana de dados, documentos e escopo antes da execução.</p>
    </div>
</section>
<section class="content-section">
    <div class="container">
        <?php if ( function_exists( 'woocommerce_content' ) ) { woocommerce_content(); } else { while ( have_posts() ) : the_post(); the_content(); endwhile; } ?>
    </div>
</section>
<?php get_footer(); ?>
