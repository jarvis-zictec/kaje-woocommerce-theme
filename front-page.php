<?php get_header(); ?>
<section class="shop-hero">
    <div class="container hero-grid">
        <div class="hero-copy">
            <span class="eyebrow">Loja KAJE Serviços</span>
            <h1>Contrate serviços administrativos com orientação clara e atendimento humano.</h1>
            <p>Escolha o serviço, finalize o pedido e receba o contato da KAJE para confirmar documentos, dados e próximos passos.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="<?php echo esc_url( kaje_loja_shop_url() ); ?>">Ver serviços</a>
                <a class="btn btn-secondary" href="<?php echo esc_url( kaje_loja_calendly_url() ); ?>" target="_blank" rel="noopener">Agendar conversa</a>
            </div>
        </div>
        <aside class="hero-card">
            <strong>Como funciona</strong>
            <ol>
                <li>Você escolhe o serviço.</li>
                <li>A KAJE confirma os dados necessários.</li>
                <li>O atendimento segue com orientação e execução combinada.</li>
            </ol>
        </aside>
    </div>
</section>
<section class="featured-products">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Catálogo inicial</span>
            <h2>Serviços mais procurados</h2>
            <p>Produtos virtuais para formalização, regularização, NFS-e e atendimento consultivo.</p>
        </div>
        <?php echo do_shortcode( '[products limit="8" columns="4" orderby="date" order="DESC"]' ); ?>
    </div>
</section>
<section class="trust-band">
    <div class="container trust-grid">
        <div><strong>Escopo claro</strong><span>Descrições com inclusões e limites.</span></div>
        <div><strong>Atendimento orientado</strong><span>Contato após a compra para validar dados.</span></div>
        <div><strong>Online ou agendado</strong><span>Fluxo prático para MEIs e pequenos negócios.</span></div>
    </div>
</section>
<?php get_footer(); ?>
