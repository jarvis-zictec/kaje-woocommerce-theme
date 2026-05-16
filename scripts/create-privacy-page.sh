#!/usr/bin/env bash
set -euo pipefail
WP_ROOT="${WP_ROOT:-/var/www/kaje}"
PRIVACY_FILE="${PRIVACY_FILE:-$(cd "$(dirname "$0")/.." && pwd)/assets/legal/politica-de-privacidade-kaje.html}"
TITLE="Política de Privacidade"
SLUG="politica-de-privacidade"

create_or_update_page() {
  local url="$1"
  local existing_id
  cd "$WP_ROOT"
  existing_id=$(wp --allow-root --url="$url" post list --post_type=page --name="$SLUG" --field=ID --format=ids | head -n1 || true)
  if [ -n "$existing_id" ]; then
    echo "Atualizando política de privacidade em $url (ID $existing_id)"
    wp --allow-root --url="$url" post update "$existing_id"       --post_title="$TITLE"       --post_name="$SLUG"       --post_status=publish       --post_content="$(cat "$PRIVACY_FILE")" >/dev/null
  else
    echo "Criando política de privacidade em $url"
    existing_id=$(wp --allow-root --url="$url" post create       --post_type=page       --post_title="$TITLE"       --post_name="$SLUG"       --post_status=publish       --post_content="$(cat "$PRIVACY_FILE")"       --porcelain)
  fi
  echo "$existing_id"
}

STORE_ID=$(create_or_update_page "https://loja.kajeservicos.com.br" | tail -n1)
SITE_ID=$(create_or_update_page "https://www.kajeservicos.com.br" | tail -n1)

cd "$WP_ROOT"
if [ -n "$STORE_ID" ]; then
  echo "Configurando página de privacidade WordPress/WooCommerce na loja ID $STORE_ID"
  wp --allow-root --url="https://loja.kajeservicos.com.br" option update wp_page_for_privacy_policy "$STORE_ID" >/dev/null || true
  wp --allow-root --url="https://loja.kajeservicos.com.br" option update woocommerce_privacy_policy_page_id "$STORE_ID" >/dev/null || true
fi
if [ -n "$SITE_ID" ]; then
  echo "Configurando página de privacidade WordPress no site institucional ID $SITE_ID"
  wp --allow-root --url="https://www.kajeservicos.com.br" option update wp_page_for_privacy_policy "$SITE_ID" >/dev/null || true
fi

echo "OK - política de privacidade publicada/atualizada."
echo "Loja: https://loja.kajeservicos.com.br/politica-de-privacidade/"
echo "Site: https://www.kajeservicos.com.br/politica-de-privacidade/"
