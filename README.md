# KAJE Loja — tema WooCommerce

Tema WordPress/WooCommerce leve para `loja.kajeservicos.com.br`, alinhado ao visual institucional da KAJE.

## Instalação no servidor WordPress

```bash
cd /var/www/kaje/wp-content/themes
git clone https://github.com/jarvis-zictec/kaje-woocommerce-theme.git kaje-loja
chown -R nginx:nginx /var/www/kaje/wp-content/themes/kaje-loja
find /var/www/kaje/wp-content/themes/kaje-loja -type d -exec chmod 755 {} \;
find /var/www/kaje/wp-content/themes/kaje-loja -type f -exec chmod 644 {} \;
restorecon -Rv /var/www/kaje/wp-content/themes/kaje-loja  # se disponível
```

No Multisite:

1. Administração da rede > Temas > ativar **KAJE Loja** para a rede.
2. Site `loja.kajeservicos.com.br` > Aparência > Temas > ativar **KAJE Loja**.

## Atualização

```bash
cd /var/www/kaje/wp-content/themes/kaje-loja
git pull --ff-only
chown -R nginx:nginx /var/www/kaje/wp-content/themes/kaje-loja
```

## Observações

- O tema pressupõe WooCommerce ativo no site da loja.
- O tema institucional `KAJE Serviços` deve continuar no `www.kajeservicos.com.br`.
- O WhatsApp em `functions.php` está com número placeholder e pode ser ajustado depois.
