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
add_filter( 'private_title_format', function () { return '%s'; } );
add_filter( 'protected_title_format', function () { return '%s'; } );

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
    return 'https://wa.me/5547988090296?text=' . rawurlencode( 'Olá, vim pela Loja KAJE e gostaria de atendimento.' );
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
    echo '<ul class="menu"><li><a href="' . esc_url( kaje_loja_shop_url() ) . '">Serviços</a></li><li><a href="' . esc_url( kaje_loja_calendly_url() ) . '" target="_blank" rel="noopener">Agendamento</a></li><li><a href="https://www.kajeservicos.com.br/">Site institucional</a></li><li><a href="' . esc_url( kaje_loja_cart_url() ) . '">Carrinho</a></li></ul>';
}


add_filter( 'woocommerce_page_title', function ( $title ) {
    if ( function_exists( 'is_shop' ) && is_shop() ) {
        return __( 'Escolha o serviço', 'kaje-loja' );
    }
    return $title;
} );

add_action( 'woocommerce_before_shop_loop_item_title', function () {
    echo '<div class="kaje-product-label">Serviço KAJE</div>';
}, 8 );


/**
 * Experiência premium dos e-mails transacionais da loja.
 *
 * Estratégia atual:
 * - Agendamento permanece aberto via Calendly, com dados do pedido em parâmetros.
 * - Manual inicial fica disponível como asset versionado do tema.
 * - Futuro: substituir o link aberto por fluxo controlado via pagamento confirmado/API/IA.
 */
function kaje_loja_order_service_summary( $order ) {
    if ( ! $order || ! is_a( $order, 'WC_Order' ) ) {
        return 'Serviço KAJE';
    }
    $names = array();
    foreach ( $order->get_items() as $item ) {
        $names[] = wp_strip_all_tags( $item->get_name() );
    }
    $names = array_filter( array_unique( $names ) );
    return $names ? implode( ', ', array_slice( $names, 0, 3 ) ) : 'Serviço KAJE';
}

function kaje_loja_manual_inicial_url() {
    return kaje_loja_asset( 'assets/manuals/guia-inicial-atendimento-kaje.html' );
}

function kaje_loja_calendly_order_url( $order ) {
    $base = kaje_loja_calendly_url();
    if ( ! $order || ! is_a( $order, 'WC_Order' ) ) {
        return $base;
    }

    $name = trim( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() );
    $args = array(
        'name'       => $name,
        'email'      => $order->get_billing_email(),
        'a1'         => 'Pedido #' . $order->get_order_number(),
        'a2'         => kaje_loja_order_service_summary( $order ),
        'a3'         => $order->get_billing_phone(),
        'utm_source' => 'woocommerce',
        'utm_medium' => 'email',
        'utm_campaign' => 'pos-compra',
        'utm_content'  => 'pedido-' . $order->get_order_number(),
    );

    return add_query_arg( array_filter( $args ), $base );
}

add_filter( 'woocommerce_email_from_name', function () {
    return 'KAJE Serviços';
}, 20 );

add_filter( 'woocommerce_email_from_address', function () {
    return 'no-reply@kajeservicos.com.br';
}, 20 );

add_filter( 'woocommerce_email_header_image', function ( $image ) {
    return kaje_loja_asset( 'assets/email/kaje-email-logo.png' );
}, 20 );

add_filter( 'woocommerce_email_footer_text', function () {
    return 'KAJE Serviços — empresa privada independente, sem vínculo com órgãos governamentais.<br>Serviços administrativos, consultivos e operacionais para simplificar a rotina do empreendedor.<br>Dúvidas? kerly@kajeservicos.com.br';
}, 20 );

add_filter( 'woocommerce_email_heading_customer_processing_order', function ( $heading, $order ) {
    return 'Recebemos seu pedido KAJE';
}, 20, 2 );

add_filter( 'woocommerce_email_subject_customer_processing_order', function ( $subject, $order ) {
    if ( $order && is_a( $order, 'WC_Order' ) ) {
        return 'Pedido KAJE #' . $order->get_order_number() . ' recebido — próximos passos';
    }
    return 'Pedido KAJE recebido — próximos passos';
}, 20, 2 );

add_filter( 'woocommerce_email_additional_content_customer_processing_order', function ( $content, $order ) {
    return 'A KAJE recebeu sua solicitação e vai conduzir os próximos passos com segurança. Se quiser adiantar o atendimento, acesse o guia inicial e agende uma conversa com a Kerly pelo link indicado neste e-mail.';
}, 20, 2 );

add_action( 'woocommerce_email_before_order_table', function ( $order, $sent_to_admin, $plain_text, $email ) {
    if ( $sent_to_admin || ! $order || ! is_a( $order, 'WC_Order' ) || ! $email || empty( $email->id ) ) {
        return;
    }

    $customer_email_ids = array( 'customer_processing_order', 'customer_completed_order', 'customer_on_hold_order' );
    if ( ! in_array( $email->id, $customer_email_ids, true ) ) {
        return;
    }

    $order_number = $order->get_order_number();
    $service_summary = kaje_loja_order_service_summary( $order );
    $manual_url = kaje_loja_manual_inicial_url();
    $calendly_url = kaje_loja_calendly_order_url( $order );

    if ( $plain_text ) {
        echo "\nPróximos passos KAJE\n";
        echo "Pedido: #" . $order_number . "\n";
        echo "Serviço: " . $service_summary . "\n";
        echo "Guia inicial: " . $manual_url . "\n";
        echo "Agendamento com a Kerly: " . $calendly_url . "\n\n";
        return;
    }
    ?>
    <div class="kaje-email-panel">
        <p class="kaje-email-eyebrow">Próximos passos KAJE</p>
        <h2>Seu pedido #<?php echo esc_html( $order_number ); ?> foi recebido.</h2>
        <p>Serviço contratado: <strong><?php echo esc_html( $service_summary ); ?></strong></p>
        <p>A KAJE vai revisar seu pedido, confirmar os dados necessários e orientar a execução. Nesta fase inicial, o agendamento fica liberado para facilitar o atendimento, mesmo antes de travas mais rígidas por pagamento confirmado.</p>
        <div class="kaje-email-actions">
            <a class="kaje-email-button" href="<?php echo esc_url( $manual_url ); ?>">Baixar guia inicial</a>
            <a class="kaje-email-button kaje-email-button-secondary" href="<?php echo esc_url( $calendly_url ); ?>">Agendar com a Kerly</a>
        </div>
        <p class="kaje-email-note">O link de agendamento já leva referência do pedido #<?php echo esc_html( $order_number ); ?> para facilitar a identificação interna.</p>
    </div>
    <?php
}, 8, 4 );

add_filter( 'woocommerce_email_styles', function ( $css ) {
    $css .= '
        body { background-color: #f6f0e6 !important; }
        #wrapper { background-color: #f6f0e6 !important; padding: 34px 0 !important; }
        #template_container { border: 1px solid #eadfcf !important; border-radius: 22px !important; overflow: hidden !important; box-shadow: 0 18px 55px rgba(16,24,32,.10) !important; }
        #template_header_image { background-color: #050505 !important; text-align: center !important; padding: 14px 0 12px !important; margin: 0 !important; border-radius: 22px 22px 0 0 !important; line-height: 0 !important; }
        #template_header_image p { margin: 0 !important; padding: 0 !important; line-height: 0 !important; }
        #template_header_image img { width: 320px !important; max-width: 82% !important; height: auto !important; margin: 0 auto !important; display: block !important; border: 0 !important; }
        #template_header { background-color: #c7a46a !important; border-bottom: 4px solid #101820 !important; border-radius: 0 !important; }
        #template_header h1 { color: #101820 !important; font-family: Helvetica, Arial, sans-serif !important; font-weight: 800 !important; letter-spacing: -0.02em !important; text-shadow: none !important; }
        #body_content_inner, #body_content_inner p, #body_content_inner td { color: #101820 !important; font-family: Helvetica, Arial, sans-serif !important; font-size: 15px !important; line-height: 1.65 !important; }
        a { color: #9b6b2f !important; font-weight: 700 !important; }
        .td, .text, address, table.td { border-color: #eadfcf !important; }
        #template_footer #credit, #template_footer #credit p { color: #5f5a50 !important; font-size: 12px !important; line-height: 1.55 !important; }
        .kaje-email-panel { background: #fbf7ef !important; border: 1px solid #eadfcf !important; border-radius: 18px !important; padding: 24px !important; margin: 0 0 28px !important; }
        .kaje-email-eyebrow { margin: 0 0 8px !important; color: #9b6b2f !important; font-size: 11px !important; text-transform: uppercase !important; letter-spacing: .14em !important; font-weight: 800 !important; }
        .kaje-email-panel h2 { color: #101820 !important; font-size: 24px !important; line-height: 1.18 !important; margin: 0 0 12px !important; }
        .kaje-email-actions { margin: 20px 0 12px !important; }
        .kaje-email-button { display: inline-block !important; margin: 0 10px 10px 0 !important; padding: 12px 18px !important; border-radius: 999px !important; background: #c7a46a !important; color: #101820 !important; text-decoration: none !important; font-weight: 800 !important; }
        .kaje-email-button-secondary { background: #101820 !important; color: #f6f0e6 !important; }
        .kaje-email-note { color: #5f5a50 !important; font-size: 13px !important; margin-bottom: 0 !important; }
    ';
    return $css;
}, 20 );
