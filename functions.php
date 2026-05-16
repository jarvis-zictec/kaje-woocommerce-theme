<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'KAJE_LOJA_VERSION', '1.0.0' );

function kaje_loja_asset( $path ) {
    return get_template_directory_uri() . '/' . ltrim( $path, '/' );
}

add_action( 'after_setup_theme', function () {
    load_theme_textdomain( 'kaje-loja', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    register_nav_menus( array(
        'primary' => __( 'Menu principal', 'kaje-loja' ),
        'footer'  => __( 'Menu do rodapé', 'kaje-loja' ),
    ) );
} );

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'kaje-loja-fonts', 'https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@300;400;500;600;700;800&display=swap', array(), null );
    wp_enqueue_style( 'kaje-loja-style', get_stylesheet_uri(), array( 'kaje-loja-fonts' ), KAJE_LOJA_VERSION );
    wp_enqueue_script( 'kaje-loja-js', kaje_loja_asset( 'assets/kaje-loja.js' ), array(), KAJE_LOJA_VERSION, true );
} );

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

add_filter( 'woocommerce_breadcrumb_defaults', function ( $defaults ) {
    $defaults['delimiter'] = '<span class="breadcrumb-separator">/</span>';
    $defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb kaje-breadcrumb" aria-label="Breadcrumb">';
    $defaults['wrap_after'] = '</nav>';
    return $defaults;
} );

add_filter( 'woocommerce_product_add_to_cart_text', function () { return __( 'Contratar serviço', 'kaje-loja' ); } );
add_filter( 'woocommerce_product_single_add_to_cart_text', function () { return __( 'Contratar agora', 'kaje-loja' ); } );

add_filter( 'woocommerce_checkout_fields', function ( $fields ) {
    if ( isset( $fields['billing']['billing_company'] ) ) {
        $fields['billing']['billing_company']['label'] = __( 'Empresa / CNPJ, se houver', 'kaje-loja' );
        $fields['billing']['billing_company']['required'] = false;
    }
    if ( isset( $fields['order']['order_comments'] ) ) {
        $fields['order']['order_comments']['label'] = __( 'Informações para atendimento', 'kaje-loja' );
        $fields['order']['order_comments']['placeholder'] = __( 'Conte rapidamente sua necessidade, CNPJ/MEI e melhor canal de contato.', 'kaje-loja' );
    }
    return $fields;
} );

add_action( 'woocommerce_before_shop_loop', function () {
    echo '<div class="kaje-shop-note"><strong>Serviços digitais e atendimento orientado.</strong> Após a compra, a KAJE entra em contato para confirmar dados, documentos e próximos passos.</div>';
}, 5 );

function kaje_loja_whatsapp_url() {
    return 'https://wa.me/5547999999999?text=' . rawurlencode( 'Olá, vim pela Loja KAJE e gostaria de atendimento.' );
}

function kaje_loja_calendly_url() {
    return 'https://www.calendly.com/kerly-kajeservicos';
}

function kaje_loja_shop_url() {
    return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
}

function kaje_loja_cart_url() {
    return function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/' );
}

function kaje_loja_checkout_url() {
    return function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/' );
}

function kaje_loja_default_menu() {
    echo '<ul class="menu"><li><a href="' . esc_url( kaje_loja_shop_url() ) . '">Serviços</a></li><li><a href="' . esc_url( kaje_loja_cart_url() ) . '">Carrinho</a></li><li><a href="' . esc_url( kaje_loja_checkout_url() ) . '">Finalizar compra</a></li><li><a href="' . esc_url( kaje_loja_calendly_url() ) . '" target="_blank" rel="noopener">Agendamento</a></li></ul>';
}
