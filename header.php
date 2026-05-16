<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?php echo esc_url( kaje_loja_asset( 'assets/favicon-kaje.png' ) ); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'kaje-loja' ); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#conteudo"><?php esc_html_e( 'Ir para o conteúdo', 'kaje-loja' ); ?></a>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="KAJE Loja">
            <img src="<?php echo esc_url( kaje_loja_asset( 'assets/logo-kaje-header-horizontal.png' ) ); ?>" alt="KAJE Administração e Serviços">
        </a>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu">Menu</button>
        <nav id="primary-menu" class="primary-nav" aria-label="Menu principal">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container' => false,
                'fallback_cb' => 'kaje_loja_default_menu',
                'menu_class' => 'menu',
            ) );
            ?>
        </nav>
        <div class="header-actions">
            <a class="header-link" href="https://www.kajeservicos.com.br/">Site institucional</a>
            <a class="btn btn-primary" href="<?php echo esc_url( kaje_loja_cart_url() ); ?>">Ver carrinho</a>
        </div>
    </div>
</header>
<main id="conteudo" class="site-main">
