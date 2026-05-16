PRODUCTS = [('KAJE-MEI-DASN', 'declaracao-anual-mei-dasn-simei', 'Declaração Anual do MEI — DASN-SIMEI', 'calendar'), ('KAJE-MEI-DASN-ATRASO', 'declaracao-anual-mei-pendencia-atraso', 'Declaração Anual MEI com Pendência ou Atraso', 'alert'), ('KAJE-MEI-ABERTURA', 'abertura-formalizacao-mei', 'Abertura e Formalização de MEI', 'store'), ('KAJE-MEI-ALTERACAO', 'alteracao-cadastral-mei', 'Alteração Cadastral do MEI', 'edit'), ('KAJE-MEI-REGULARIZACAO', 'regularizacao-cadastral-pendencias-mei', 'Regularização Cadastral e Pendências do MEI', 'shield'), ('KAJE-NFSE-AVULSA', 'apoio-emissao-nfse-avulsa', 'Apoio para Emissão de NFS-e Avulsa', 'invoice'), ('KAJE-NFSE-PACOTE10', 'pacote-apoio-10-nfse', 'Pacote de Apoio para até 10 NFS-e', 'stack'), ('KAJE-TRIBUTOS-DIAGNOSTICO', 'diagnostico-pendencias-tributarias', 'Diagnóstico de Pendências Tributárias', 'magnify'), ('KAJE-TRIBUTOS-PARCELAMENTO', 'regularizacao-parcelamento-tributario', 'Apoio em Regularização ou Parcelamento Tributário', 'chart'), ('KAJE-ANTT-CADASTRO', 'cadastro-antt-apoio-orientacao', 'Cadastro ANTT — Apoio e Orientação', 'truck'), ('KAJE-CONSULTA-ONLINE', 'atendimento-consultivo-online-30-min', 'Atendimento Consultivo Online — 30 minutos', 'video'), ('KAJE-CONSULTA-PRESENCIAL', 'atendimento-presencial-agendamento-timbo', 'Atendimento Presencial com Agendamento — Timbó/SC', 'pin'), ('KAJE-LICITACAO-COMPRASBR-MEI', 'cadastro-compras-br-mei', 'Cadastro no Compras BR para MEI', 'portal'), ('KAJE-LICITACAO-DOCUMENTOS', 'gestao-documentos-licitacao', 'Gestão de Documentos para Licitação', 'folder')]
OUT = '/root/agents/jarvis/kaje-woocommerce-theme/assets/product-images'

from PIL import Image, ImageDraw, ImageFont
from pathlib import Path
import math, json, csv, textwrap
W=H=1200
COL={
 'cream':(248,242,229),'cream2':(255,250,241),'navy':(20,38,56),'navy2':(30,54,78),
 'gold':(181,137,74),'gold2':(216,178,111),'green':(93,138,96),'orange':(209,119,59),'red':(158,73,64),'muted':(104,113,121),'white':(255,255,255),
 'line':(230,218,198)
}
try:
    FONT_BOLD=ImageFont.truetype('/usr/share/fonts/dejavu/DejaVuSans-Bold.ttf',54)
    FONT_MED=ImageFont.truetype('/usr/share/fonts/dejavu/DejaVuSans.ttf',35)
    FONT_SMALL=ImageFont.truetype('/usr/share/fonts/dejavu/DejaVuSans.ttf',28)
except Exception:
    FONT_BOLD=FONT_MED=FONT_SMALL=ImageFont.load_default()

def rr(d, xy, r, fill, outline=None, width=1):
    d.rounded_rectangle(xy, radius=r, fill=fill, outline=outline, width=width)

def line(d, pts, fill, width=10):
    d.line(pts, fill=fill, width=width, joint='curve')

def kaje_mark(d, x, y, s=1):
    line(d, [(x+0*s,y+75*s),(x+45*s,y+15*s),(x+95*s,y+15*s)], COL['orange'], int(10*s))
    line(d, [(x+8*s,y+82*s),(x+58*s,y+82*s),(x+102*s,y+28*s)], COL['green'], int(10*s))
    line(d, [(x+25*s,y+102*s),(x+78*s,y+102*s),(x+112*s,y+58*s)], COL['red'], int(10*s))

def badge(d, text, x=94, y=98):
    rr(d,(x,y,x+410,y+60),30,COL['cream2'],COL['line'],2)
    d.text((x+26,y+14),text,fill=COL['gold'],font=FONT_SMALL)

def card(d):
    # background
    im = d.im if hasattr(d,'im') else None
    d.rectangle((0,0,W,H), fill=COL['cream'])
    # soft circles
    for cx,cy,r,c in [(1030,130,260,(244,232,208)),(105,990,220,(242,230,205)),(80,120,95,(235,224,205))]:
        d.ellipse((cx-r,cy-r,cx+r,cy+r), fill=c)
    rr(d,(70,70,W-70,H-70),54,COL['cream2'],COL['line'],3)
    kaje_mark(d, 940, 95, 1.25)

def document(d,x,y,w,h,fill=None):
    fill=fill or COL['white']
    rr(d,(x,y,x+w,y+h),28,fill,COL['line'],3)
    for i in range(4):
        d.rounded_rectangle((x+55,y+80+i*62,x+w-55,y+104+i*62), radius=10, fill=(232,226,214))
    d.rectangle((x+w-150,y,x+w,y+150), fill=COL['cream'])
    d.polygon([(x+w-150,y),(x+w,y),(x+w,y+150)], fill=(239,231,214), outline=COL['line'])

def calendar_icon(d):
    rr(d,(390,345,810,800),36,COL['white'],COL['line'],4)
    rr(d,(390,345,810,455),36,COL['navy'],None,1)
    d.rectangle((390,410,810,455), fill=COL['navy'])
    for x in [485,715]: rr(d,(x,305,x+42,395),20,COL['gold2'])
    for ix,x in enumerate([455,550,645,740]):
      for iy,y in enumerate([510,605,700]):
        col=COL['gold'] if (ix,iy)==(2,1) else (224,215,199)
        rr(d,(x,y,x+45,y+45),12,col)
    line(d,[(520,635),(590,705),(720,560)],COL['green'],20)

def alert_icon(d):
    document(d,335,300,460,560)
    d.ellipse((710,270,900,460), fill=COL['red'])
    d.rectangle((792,315,820,395), fill=COL['white'])
    d.ellipse((792,410,820,438), fill=COL['white'])
    line(d,[(410,760),(535,645),(645,720),(770,555)],COL['gold'],18)

def store_icon(d):
    rr(d,(300,485,900,790),34,COL['white'],COL['line'],4)
    d.rectangle((355,600,525,790), fill=(237,230,217))
    rr(d,(610,590,825,715),18,(231,240,231),COL['green'],4)
    # awning
    d.polygon([(285,470),(915,470),(850,340),(350,340)], fill=COL['navy'])
    for i,c in enumerate([COL['gold'],COL['cream2'],COL['gold'],COL['cream2'],COL['gold']]):
        x=335+i*105
        d.polygon([(x,345),(x+105,345),(x+132,470),(x-28,470)], fill=c)
    kaje_mark(d,535,220,1.1)

def edit_icon(d):
    document(d,330,300,440,560)
    line(d,[(530,745),(840,435)],COL['gold'],44)
    d.polygon([(835,425),(895,365),(930,455),(875,510)], fill=COL['orange'])
    d.polygon([(500,775),(565,735),(535,815)], fill=COL['navy'])
    rr(d,(420,390,645,440),14,(230,239,230))

def shield_icon(d):
    d.polygon([(600,250),(855,350),(820,640),(600,830),(380,640),(345,350)], fill=COL['navy'], outline=COL['line'])
    d.polygon([(600,305),(795,382),(770,610),(600,760),(430,610),(405,382)], fill=(34,63,91))
    line(d,[(490,560),(575,645),(735,465)],COL['gold2'],30)
    document(d,270,410,260,330,(255,252,245))
    document(d,670,470,260,280,(255,252,245))

def invoice_icon(d):
    document(d,330,260,500,620)
    d.text((500,365),'R$',fill=COL['gold'],font=FONT_BOLD)
    for y in [500,570,640]: d.rounded_rectangle((430,y,720,y+25), radius=12, fill=(225,218,205))
    d.ellipse((690,680,875,865), fill=COL['green'])
    line(d,[(735,775),(775,815),(835,725)],COL['white'],18)

def stack_icon(d):
    for i,(x,y,c) in enumerate([(285,355,COL['cream2']),(345,305,COL['white']),(405,255,(255,253,248))]):
        document(d,x,y,430,535,c)
    rr(d,(735,610,920,795),34,COL['navy'])
    d.text((770,645),'10',fill=COL['gold2'],font=FONT_BOLD)
    d.text((770,712),'NFS-e',fill=COL['white'],font=FONT_SMALL)

def magnify_icon(d):
    document(d,300,285,430,550)
    d.ellipse((545,455,850,760), outline=COL['navy'], width=34, fill=(255,255,255,0))
    line(d,[(770,690),(910,830)],COL['navy'],42)
    line(d,[(395,665),(490,560),(575,620),(665,470)],COL['red'],16)
    for x,y in [(420,435),(505,435),(590,435)]: d.ellipse((x,y,x+34,y+34), fill=COL['gold'])

def chart_icon(d):
    rr(d,(285,310,915,805),42,COL['white'],COL['line'],4)
    line(d,[(390,705),(390,410)],(210,201,186),8); line(d,[(380,705),(800,705)],(210,201,186),8)
    bars=[(445,610,65,95,COL['green']),(545,540,65,165,COL['gold']),(645,455,65,250,COL['orange']),(745,375,65,330,COL['navy'])]
    for x,y,w,h,c in bars: rr(d,(x,y,x+w,y+h),16,c)
    line(d,[(460,535),(570,490),(675,405),(790,330)],COL['red'],14)

def truck_icon(d):
    rr(d,(270,485,690,690),26,COL['white'],COL['line'],4)
    d.rectangle((690,545,825,690), fill=COL['navy'])
    d.polygon([(825,590),(910,630),(910,690),(825,690)], fill=COL['navy'])
    for x in [410,780]:
        d.ellipse((x,645,x+115,y:=760), fill=COL['navy']); d.ellipse((x+30,675,x+85,730), fill=COL['gold2'])
    d.rounded_rectangle((745,575,810,625), radius=8, fill=COL['cream2'])
    line(d,[(360,420),(505,420),(590,330)],COL['green'],18)
    line(d,[(365,380),(535,380)],COL['orange'],14)

def video_icon(d):
    rr(d,(300,345,805,725),42,COL['white'],COL['line'],4)
    rr(d,(360,410,705,660),28,COL['navy'])
    d.polygon([(705,505),(890,420),(890,650),(705,565)], fill=COL['gold'])
    d.ellipse((500,475,570,545), fill=COL['green'])
    d.rounded_rectangle((450,575,620,600), radius=12, fill=COL['cream2'])
    rr(d,(395,760,805,825),32,COL['cream2'],COL['line'],3)


def portal_icon(d):
    rr(d,(280,300,920,780),42,COL['white'],COL['line'],4)
    rr(d,(280,300,920,410),42,COL['navy'],None,1)
    d.rectangle((280,365,920,410), fill=COL['navy'])
    for x,c in [(340,COL['red']),(395,COL['gold']),(450,COL['green'])]: d.ellipse((x,340,x+28,y:=368), fill=c)
    rr(d,(360,475,590,650),26,(241,235,222),COL['line'],2)
    rr(d,(625,475,840,530),18,(231,240,231),None,1)
    rr(d,(625,570,840,625),18,(242,232,211),None,1)
    line(d,[(425,560),(475,610),(545,510)],COL['green'],16)
    d.ellipse((690,665,850,825), fill=COL['gold'])
    d.rectangle((760,555,785,705), fill=COL['navy'])
    d.rectangle((695,735,855,760), fill=COL['navy'])

def folder_icon(d):
    rr(d,(260,420,940,805),36,COL['gold2'],COL['line'],4)
    d.polygon([(300,360),(535,360),(590,425),(300,425)], fill=COL['gold'], outline=COL['line'])
    rr(d,(295,455,905,835),36,COL['white'],COL['line'],4)
    document(d,380,300,360,445,(255,252,245))
    line(d,[(460,520),(525,585),(665,435)],COL['green'],18)
    for y in [390,650,710]: d.rounded_rectangle((455,y,720,y+22), radius=10, fill=(226,219,205))
    d.ellipse((700,645,870,815), fill=COL['navy'])
    d.text((744,675),'OK',fill=COL['gold2'],font=FONT_BOLD)

def pin_icon(d):
    d.ellipse((430,240,770,580), fill=COL['navy'])
    d.polygon([(500,520),(700,520),(600,870)], fill=COL['navy'])
    d.ellipse((525,335,675,485), fill=COL['gold2'])
    rr(d,(260,705,940,850),38,COL['white'],COL['line'],4)
    line(d,[(365,780),(835,780)],COL['gold'],12)
    for x,c in [(420,COL['green']),(600,COL['orange']),(780,COL['red'])]: d.ellipse((x,758,x+45,803), fill=c)

icons={'calendar':calendar_icon,'alert':alert_icon,'store':store_icon,'edit':edit_icon,'shield':shield_icon,'invoice':invoice_icon,'stack':stack_icon,'magnify':magnify_icon,'chart':chart_icon,'truck':truck_icon,'video':video_icon,'pin':pin_icon,'portal':portal_icon,'folder':folder_icon}
products = PRODUCTS
out=Path(OUT)
out.mkdir(parents=True, exist_ok=True)
manifest=[]
for sku,slug,title,kind in products:
    im=Image.new('RGB',(W,H),COL['cream'])
    d=ImageDraw.Draw(im)
    card(d)
    badge(d,'SERVIÇO KAJE')
    icons[kind](d)
    # bottom title panel
    rr(d,(140,935,1060,1085),34,COL['navy'])
    wrapped=textwrap.wrap(title, width=34)
    y=963 if len(wrapped)==1 else 945
    for line_txt in wrapped[:2]:
        bbox=d.textbbox((0,0),line_txt,font=FONT_MED)
        d.text(((W-(bbox[2]-bbox[0]))/2,y), line_txt, fill=COL['white'], font=FONT_MED)
        y += 44
    d.text((165,1037), sku, fill=COL['gold2'], font=FONT_SMALL)
    filename=f'{sku.lower()}.png'
    path=out/filename
    im.save(path, optimize=True)
    manifest.append({'sku':sku,'slug':slug,'title':title,'image_file':f'assets/product-images/{filename}','prompt_style':'Ilustração vetorial quadrada KAJE: fundo creme, azul-marinho, dourado, acentos geométricos laranja/verde/vermelho, ícone sem foto realista.'})
# write manifest json/csv
(out/'manifest.json').write_text(json.dumps(manifest, ensure_ascii=False, indent=2))
with (out/'manifest.csv').open('w', newline='', encoding='utf-8') as f:
    w=csv.DictWriter(f, fieldnames=['sku','slug','title','image_file','prompt_style'])
    w.writeheader(); w.writerows(manifest)
print('generated', len(manifest), 'images in', out)
