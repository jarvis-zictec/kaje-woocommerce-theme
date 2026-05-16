<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
</main>
<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <img class="footer-logo" src="<?php echo esc_url( kaje_loja_asset( 'assets/logo-kaje-header-horizontal.png' ) ); ?>" alt="KAJE Administração e Serviços">
            <p>Serviços administrativos, MEI, NFS-e, regularização e atendimento consultivo para quem precisa resolver com clareza.</p>
        </div>
        <div>
            <h2>Atendimento</h2>
            <p><a href="mailto:kerly@kajeservicos.com.br">kerly@kajeservicos.com.br</a></p>
            <p><a href="<?php echo esc_url( kaje_loja_calendly_url() ); ?>" target="_blank" rel="noopener">Agendar atendimento online</a></p>
        </div>
        <div>
            <h2>Compra segura</h2>
            <p>Todos os serviços são revisados antes da execução. Taxas públicas, multas, juros e débitos não estão inclusos salvo indicação expressa.</p>
        </div>
    </div>
    <div class="container footer-bottom">© <?php echo esc_html( date( 'Y' ) ); ?> KAJE Serviços. Loja operada em WordPress + WooCommerce.</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
