#!/usr/bin/env bash
set -euo pipefail
WP_ROOT="${WP_ROOT:-/var/www/kaje}"
TERMS_FILE="${TERMS_FILE:-$(cd "$(dirname "$0")/.." && pwd)/assets/legal/termos-de-uso-kaje.html}"
TITLE="Termos de Uso e Contratação"
SLUG="termos-de-uso"

create_or_update_page() {
  local url="$1"
  local existing_id
  cd "$WP_ROOT"
  existing_id=$(wp --allow-root --url="$url" post list --post_type=page --name="$SLUG" --field=ID --format=ids | head -n1 || true)
  if [ -n "$existing_id" ]; then
    echo "Atualizando página de termos em $url (ID $existing_id)"
    wp --allow-root --url="$url" post update "$existing_id"       --post_title="$TITLE"       --post_name="$SLUG"       --post_status=publish       --post_content="$(cat "$TERMS_FILE")" >/dev/null
  else
    echo "Criando página de termos em $url"
    existing_id=$(wp --allow-root --url="$url" post create       --post_type=page       --post_title="$TITLE"       --post_name="$SLUG"       --post_status=publish       --post_content="$(cat "$TERMS_FILE")"       --porcelain)
  fi
  echo "$existing_id"
}

STORE_ID=$(create_or_update_page "https://loja.kajeservicos.com.br" | tail -n1)
SITE_ID=$(create_or_update_page "https://www.kajeservicos.com.br" | tail -n1)

cd "$WP_ROOT"
if [ -n "$STORE_ID" ]; then
  echo "Configurando WooCommerce para usar página de termos ID $STORE_ID"
  wp --allow-root --url="https://loja.kajeservicos.com.br" option update woocommerce_terms_page_id "$STORE_ID" >/dev/null || true
fi

echo "OK - termos publicados/atualizados."
echo "Loja: https://loja.kajeservicos.com.br/termos-de-uso/"
echo "Site: https://www.kajeservicos.com.br/termos-de-uso/"
