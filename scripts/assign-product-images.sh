#!/usr/bin/env bash
set -euo pipefail
WP_ROOT="${WP_ROOT:-/var/www/kaje}"
SHOP_URL="${SHOP_URL:-https://loja.kajeservicos.com.br}"
THEME_DIR="${THEME_DIR:-$WP_ROOT/wp-content/themes/kaje-loja}"
IMG_DIR="$THEME_DIR/assets/product-images"
cd "$WP_ROOT"

assign_image() {
  local sku="$1" file="$2" title="$3"
  local product_id attachment_id
  product_id=$(wp --allow-root --url="$SHOP_URL" wc product list --sku="$sku" --field=id --user=1 2>/dev/null || true)
  if [ -z "$product_id" ]; then
    product_id=$(wp --allow-root --url="$SHOP_URL" post list --post_type=product --post_status=draft,publish,private --meta_key=_sku --meta_value="$sku" --field=ID | head -n1 || true)
  fi
  if [ -z "$product_id" ]; then
    echo "Produto não encontrado para SKU $sku"
    return 0
  fi
  echo "Importando imagem para produto $product_id / $sku"
  attachment_id=$(wp --allow-root --url="$SHOP_URL" media import "$IMG_DIR/$file" --post_id="$product_id" --title="$title" --alt="$title" --porcelain)
  wp --allow-root --url="$SHOP_URL" post meta update "$product_id" _thumbnail_id "$attachment_id" >/dev/null
}

assign_image 'KAJE-MEI-DASN' 'kaje-mei-dasn.png' 'Declaração Anual do MEI — DASN-SIMEI'
assign_image 'KAJE-MEI-DASN-ATRASO' 'kaje-mei-dasn-atraso.png' 'Declaração Anual MEI com Pendência ou Atraso'
assign_image 'KAJE-MEI-ABERTURA' 'kaje-mei-abertura.png' 'Abertura e Formalização de MEI'
assign_image 'KAJE-MEI-ALTERACAO' 'kaje-mei-alteracao.png' 'Alteração Cadastral do MEI'
assign_image 'KAJE-MEI-REGULARIZACAO' 'kaje-mei-regularizacao.png' 'Regularização Cadastral e Pendências do MEI'
assign_image 'KAJE-NFSE-AVULSA' 'kaje-nfse-avulsa.png' 'Apoio para Emissão de NFS-e Avulsa'
assign_image 'KAJE-NFSE-PACOTE10' 'kaje-nfse-pacote10.png' 'Pacote de Apoio para até 10 NFS-e'
assign_image 'KAJE-TRIBUTOS-DIAGNOSTICO' 'kaje-tributos-diagnostico.png' 'Diagnóstico de Pendências Tributárias'
assign_image 'KAJE-TRIBUTOS-PARCELAMENTO' 'kaje-tributos-parcelamento.png' 'Apoio em Regularização ou Parcelamento Tributário'
assign_image 'KAJE-ANTT-CADASTRO' 'kaje-antt-cadastro.png' 'Cadastro ANTT — Apoio e Orientação'
assign_image 'KAJE-CONSULTA-ONLINE' 'kaje-consulta-online.png' 'Atendimento Consultivo Online — 30 minutos'
assign_image 'KAJE-CONSULTA-PRESENCIAL' 'kaje-consulta-presencial.png' 'Atendimento Presencial com Agendamento — Timbó/SC'

echo 'OK - imagens associadas aos produtos KAJE.'
