from PIL import Image, ImageDraw, ImageFont

WIDTH = 760
HEIGHT = 900
MARGIN = 20
HEADER_H = 56
COLS = 3
COL_W = (WIDTH - (MARGIN * 2)) // COLS

BG = (255, 255, 255)
LINE = (60, 60, 60)
HEADER_BG = (223, 231, 244)
TEXT = (30, 30, 30)

img = Image.new("RGB", (WIDTH, HEIGHT), BG)
draw = ImageDraw.Draw(img)

try:
    font = ImageFont.truetype("arial.ttf", 16)
    font_bold = ImageFont.truetype("arialbd.ttf", 16)
except Exception:
    font = ImageFont.load_default()
    font_bold = ImageFont.load_default()

# Outer border
outer = [MARGIN, MARGIN, WIDTH - MARGIN, HEIGHT - MARGIN]
draw.rectangle(outer, outline=LINE, width=2)

# Header row
for i in range(COLS):
    x0 = MARGIN + i * COL_W
    x1 = x0 + COL_W
    draw.rectangle([x0, MARGIN, x1, MARGIN + HEADER_H], fill=HEADER_BG, outline=LINE, width=2)

# Column separators and header bottom line
for i in range(1, COLS):
    x = MARGIN + i * COL_W
    draw.line([x, MARGIN, x, HEIGHT - MARGIN], fill=LINE, width=2)

draw.line([MARGIN, MARGIN + HEADER_H, WIDTH - MARGIN, MARGIN + HEADER_H], fill=LINE, width=2)

# Header labels
headers = ["Petugas", "Sistem", "Admin"]
for i, label in enumerate(headers):
    x0 = MARGIN + i * COL_W
    x1 = x0 + COL_W
    cx = (x0 + x1) // 2
    draw.text((cx, MARGIN + 18), label, fill=TEXT, font=font_bold, anchor="mm")


def draw_box(col, y, w=150, h=50, text=""):
    x0 = MARGIN + col * COL_W + (COL_W - w) // 2
    x1 = x0 + w
    y1 = y + h
    draw.rectangle([x0, y, x1, y1], outline=LINE, width=2)
    if text:
        draw.multiline_text(((x0 + x1) // 2, (y + y1) // 2), text, fill=TEXT, font=font, anchor="mm", align="center")
    return (x0, y, x1, y1)


def draw_parallelogram(col, y, w=170, h=54, skew=18, text=""):
    x0 = MARGIN + col * COL_W + (COL_W - w) // 2
    x1 = x0 + w
    y1 = y + h
    pts = [(x0 + skew, y), (x1, y), (x1 - skew, y1), (x0, y1)]
    draw.polygon(pts, outline=LINE, fill=None)
    if text:
        cx = (x0 + x1) // 2
        cy = (y + y1) // 2
        draw.multiline_text((cx, cy), text, fill=TEXT, font=font, anchor="mm", align="center")
    return (x0, y, x1, y1)


def draw_arrow(p1, p2):
    draw.line([p1, p2], fill=LINE, width=2)
    # arrow head
    ax, ay = p2
    bx, by = p1
    dx, dy = ax - bx, ay - by
    if dx == 0 and dy == 0:
        return
    length = max((dx * dx + dy * dy) ** 0.5, 1)
    ux, uy = dx / length, dy / length
    size = 8
    left = (ax - ux * size - uy * size, ay - uy * size + ux * size)
    right = (ax - ux * size + uy * size, ay - uy * size - ux * size)
    draw.polygon([p2, left, right], fill=LINE)


# Petugas steps
p1 = draw_parallelogram(0, 110, text="Login /\nAkses Dashboard")
p2 = draw_box(0, 210, text="Mulai\nTracking")
p3 = draw_parallelogram(0, 300, text="Input Lokasi\nSampah")
p4 = draw_parallelogram(0, 392, text="Upload Foto\nSebelum & Sesudah")

# Sistem steps
s1 = draw_box(1, 110, text="Autentikasi\n& API Token")
s2 = draw_box(1, 210, text="Ambil Lokasi\n& Simpan Tracking")
s3 = draw_box(1, 300, text="Simpan Data\nSampah + Peta")
s4 = draw_box(1, 392, text="Simpan Foto\n& Tracking")
s5 = draw_box(1, 500, text="Sediakan\nRiwayat Tracking")

# Admin steps
a1 = draw_box(2, 500, text="Lihat Riwayat\nPetugas")
a2 = draw_parallelogram(2, 590, text="Export CSV")

# Arrows between steps
# Petugas to Sistem
for left, right in [(p1, s1), (p2, s2), (p3, s3), (p4, s4)]:
    draw_arrow((left[2], (left[1] + left[3]) // 2), (right[0], (right[1] + right[3]) // 2))

# Sistem flow down
for top, bottom in [(s1, s2), (s2, s3), (s3, s4), (s4, s5)]:
    draw_arrow(((top[0] + top[2]) // 2, top[3]), ((bottom[0] + bottom[2]) // 2, bottom[1]))

# Admin flow
draw_arrow(((s5[2]), (s5[1] + s5[3]) // 2), (a1[0], (a1[1] + a1[3]) // 2))
draw_arrow(((a1[0] + a1[2]) // 2, a1[3]), ((a2[0] + a2[2]) // 2, a2[1]))

# Petugas vertical hints
draw_arrow(((p1[0] + p1[2]) // 2, p1[3]), ((p2[0] + p2[2]) // 2, p2[1]))
draw_arrow(((p2[0] + p2[2]) // 2, p2[3]), ((p3[0] + p3[2]) // 2, p3[1]))
draw_arrow(((p3[0] + p3[2]) // 2, p3[3]), ((p4[0] + p4[2]) // 2, p4[1]))

img.save("c:/xampp8.1.25/htdocs/web_gis/public/diagram_sistem_berjalan_web_gis.png")
print("saved")
