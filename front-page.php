<?php get_header(); ?>
<section class="shop-hero">
    <div class="container hero-grid">
        <div class="hero-copy">
            <span class="eyebrow">Loja KAJE Serviços</span>
            <h1>Serviços administrativos para MEIs, profissionais e pequenas empresas.</h1>
            <p>Contrate serviços selecionados online e receba o contato da KAJE para confirmar dados, documentos, escopo e próximos passos antes da execução.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="<?php echo esc_url( kaje_loja_shop_url() ); ?>">Ver serviços disponíveis</a>
                <a class="btn btn-secondary" href="<?php echo esc_url( kaje_loja_calendly_url() ); ?>" target="_blank" rel="noopener">Agendar conversa</a>
            </div>
        </div>
        <aside class="hero-card">
            <strong>Como funciona</strong>
            <ol>
                <li>Você escolhe um serviço no catálogo.</li>
                <li>A KAJE valida os dados, documentos e limites do atendimento.</li>
                <li>O serviço segue com orientação humana e execução combinada.</li>
            </ol>
        </aside>
    </div>
</section>
<section class="featured-products">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Catálogo online</span>
            <h2>Escolha o serviço e inicie o atendimento</h2>
            <p>Serviços virtuais para formalização, regularização, NFS-e, obrigações do MEI e atendimento consultivo.</p>
        </div>
        <?php echo do_shortcode( '[products limit="8" columns="4" orderby="date" order="DESC"]' ); ?>
    </div>
</section>
<section class="trust-band">
    <div class="container trust-grid">
        <div><strong>Escopo claro</strong><span>Descrições com inclusões, limites e próximos passos.</span></div>
        <div><strong>Confirmação humana</strong><span>Contato após a compra para validar dados antes da execução.</span></div>
        <div><strong>Integrado ao atendimento</strong><span>Loja, WhatsApp e agendamento seguem o mesmo padrão da KAJE.</span></div>
    </div>
</section>
<?php get_footer(); ?>
