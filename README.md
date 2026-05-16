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
- WhatsApp principal da KAJE no tema: `(47) 98809-0296`.


## Imagens de produtos

As imagens vetoriais dos 12 serviços ficam em:

```text
assets/product-images/
```

Arquivos de controle:

```text
assets/product-images/manifest.csv
assets/product-images/manifest.json
scripts/generate-product-images.py
scripts/assign-product-images.sh
```

Para associar as imagens aos produtos existentes no WooCommerce via SKU:

```bash
cd /var/www/kaje/wp-content/themes/kaje-loja
./scripts/assign-product-images.sh
```

O script usa por padrão:

```text
WP_ROOT=/var/www/kaje
SHOP_URL=https://loja.kajeservicos.com.br
THEME_DIR=/var/www/kaje/wp-content/themes/kaje-loja
```

Se necessário, sobrescrever:

```bash
WP_ROOT=/var/www/kaje SHOP_URL=https://loja.kajeservicos.com.br ./scripts/assign-product-images.sh
```
