from PIL import Image, ImageDraw, ImageFont

WIDTH = 1100
HEIGHT = 820
BG = (255, 255, 255)
LINE = (40, 40, 40)
TEXT = (20, 20, 20)
BAR = (0, 0, 0)

img = Image.new("RGB", (WIDTH, HEIGHT), BG)
draw = ImageDraw.Draw(img)

try:
    font = ImageFont.truetype("arial.ttf", 14)
    font_bold = ImageFont.truetype("arialbd.ttf", 15)
except Exception:
    font = ImageFont.load_default()
    font_bold = ImageFont.load_default()


def round_rect(x0, y0, x1, y1, r=12, outline=LINE, fill=None, width=2):
    try:
        draw.rounded_rectangle([x0, y0, x1, y1], radius=r, outline=outline, fill=fill, width=width)
    except Exception:
        draw.rectangle([x0, y0, x1, y1], outline=outline, fill=fill, width=width)


def text_size(text, use_font):
    bbox = draw.textbbox((0, 0), text, font=use_font)
    return (bbox[2] - bbox[0], bbox[3] - bbox[1])


def draw_centered_lines(cx, cy, lines, use_font):
    sizes = [text_size(line, use_font) for line in lines]
    line_h = max([h for _, h in sizes] + [14]) + 2
    total_h = line_h * len(lines)
    start_y = cy - (total_h // 2)
    for i, line in enumerate(lines):
        w, h = sizes[i]
        x = cx - (w // 2)
        y = start_y + (i * line_h)
        draw.text((x, y), line, fill=TEXT, font=use_font)


def draw_label(text, x, y):
    draw_centered_lines(x, y, [text], font)


def draw_box(cx, cy, w, h, text, bold=False):
    x0 = cx - w // 2
    y0 = cy - h // 2
    x1 = cx + w // 2
    y1 = cy + h // 2
    round_rect(x0, y0, x1, y1)
    lines = text.split("\n")
    use_font = font_bold if bold else font
    draw_centered_lines(cx, cy, lines, use_font)
    return (x0, y0, x1, y1)


def draw_bar(x0, y, x1):
    draw.rectangle([x0, y, x1, y + 10], fill=BAR)
    return (x0, y, x1, y + 10)


def draw_start(cx, cy):
    r = 12
    draw.ellipse([cx - r, cy - r, cx + r, cy + r], fill=BAR, outline=BAR)
    return (cx, cy)


def draw_end(cx, cy):
    r1 = 12
    r2 = 18
    draw.ellipse([cx - r2, cy - r2, cx + r2, cy + r2], outline=BAR, width=2)
    draw.ellipse([cx - r1, cy - r1, cx + r1, cy + r1], fill=BAR, outline=BAR)
    return (cx, cy)


def draw_diamond(cx, cy, w, h, text):
    pts = [(cx, cy - h // 2), (cx + w // 2, cy), (cx, cy + h // 2), (cx - w // 2, cy)]
    draw.polygon(pts, outline=LINE, fill=None)
    draw_centered_lines(cx, cy, [text], font)
    return pts


def arrow(p1, p2):
    draw.line([p1, p2], fill=LINE, width=2)
    ax, ay = p2
    bx, by = p1
    dx, dy = ax - bx, ay - by
    length = max((dx * dx + dy * dy) ** 0.5, 1)
    ux, uy = dx / length, dy / length
    size = 8
    left = (ax - ux * size - uy * size, ay - uy * size + ux * size)
    right = (ax - ux * size + uy * size, ay - uy * size - ux * size)
    draw.polygon([p2, left, right], fill=LINE)


def arrow_elbow(p1, p2, mid_x=None, mid_y=None):
    x1, y1 = p1
    x2, y2 = p2
    if mid_x is None:
        mid_x = x1
    if mid_y is None:
        mid_y = y2
    draw.line([p1, (mid_x, y1), (mid_x, mid_y), (x2, mid_y)], fill=LINE, width=2)
    arrow((x2, mid_y), p2)


def center_bottom(rect):
    return ((rect[0] + rect[2]) // 2, rect[3])


def center_top(rect):
    return ((rect[0] + rect[2]) // 2, rect[1])


def center_left(rect):
    return (rect[0], (rect[1] + rect[3]) // 2)


def center_right(rect):
    return (rect[2], (rect[1] + rect[3]) // 2)


def main():
    start = draw_start(600, 50)
    registrasi = draw_box(430, 110, 150, 40, "Registrasi")
    login = draw_box(600, 110, 150, 40, "Login", bold=True)
    diamond = draw_diamond(600, 190, 70, 70, "Valid?")

    arrow((start[0], start[1] + 12), (600, 90))
    arrow(center_right(registrasi), center_left(login))
    arrow((600, 130), (600, 155))

    # Decision: N loops back to login (right side)
    login_right = login[2]
    login_mid_y = (login[1] + login[3]) // 2
    diamond_right = (600 + 35, 190)
    loop_x = login_right + 22
    draw.line([diamond_right, (loop_x, diamond_right[1]), (loop_x, login_mid_y)], fill=LINE, width=2)
    arrow((loop_x, login_mid_y), (login_right, login_mid_y))
    draw_label("N", loop_x - 12, diamond_right[1] - 10)
    draw_label("Y", 612, 232)

    fork = draw_bar(80, 240, 1020)
    arrow((600, 225), (600, 240))

    # Top level modules
    col_x = [200, 450, 700, 950]
    kelola = draw_box(col_x[0], 300, 210, 50, "Kelola User\n(Admin)")
    tracking = draw_box(col_x[1], 300, 230, 50, "Tracking dan\nLokasi Sampah")
    riwayat = draw_box(col_x[2], 300, 210, 50, "Riwayat dan\nLaporan")
    logout = draw_box(col_x[3], 300, 140, 50, "Logout")

    for x, box in zip(col_x, [kelola, tracking, riwayat, logout]):
        arrow((x, 240), center_top(box))

    # Sub bars
    draw_bar(col_x[0] - 70, 350, col_x[0] + 70)
    draw_bar(col_x[1] - 70, 350, col_x[1] + 70)
    draw_bar(col_x[2] - 70, 350, col_x[2] + 70)

    arrow(center_bottom(kelola), (col_x[0], 350))
    arrow(center_bottom(tracking), (col_x[1], 350))
    arrow(center_bottom(riwayat), (col_x[2], 350))

    # Sub items - kelola user
    tambah = draw_box(col_x[0], 410, 190, 42, "Tambah User")
    edit = draw_box(col_x[0], 470, 190, 42, "Edit User")
    hapus = draw_box(col_x[0], 530, 190, 42, "Hapus User")

    arrow((col_x[0], 360), center_top(tambah))
    arrow(center_bottom(tambah), center_top(edit))
    arrow(center_bottom(edit), center_top(hapus))

    # Sub items - tracking
    mulai = draw_box(col_x[1], 410, 200, 42, "Mulai Tracking")
    input_sampah = draw_box(col_x[1], 470, 210, 42, "Input Lokasi Sampah")
    upload = draw_box(col_x[1], 530, 230, 42, "Upload Foto Sebelum\ndan Sesudah")

    arrow((col_x[1], 360), center_top(mulai))
    arrow(center_bottom(mulai), center_top(input_sampah))
    arrow(center_bottom(input_sampah), center_top(upload))

    # Sub items - riwayat
    riwayat_saya = draw_box(col_x[2], 410, 210, 42, "Riwayat Tracking Saya")
    riwayat_petugas = draw_box(col_x[2], 470, 210, 42, "Riwayat Petugas")
    export = draw_box(col_x[2], 530, 180, 42, "Export CSV")

    arrow((col_x[2], 360), center_top(riwayat_saya))
    arrow(center_bottom(riwayat_saya), center_top(riwayat_petugas))
    arrow(center_bottom(riwayat_petugas), center_top(export))

    # Join bar and end
    join = draw_bar(120, 640, 980)

    arrow(center_bottom(hapus), (col_x[0], 640))
    arrow(center_bottom(upload), (col_x[1], 640))
    arrow(center_bottom(export), (col_x[2], 640))
    arrow(center_bottom(logout), (col_x[3], 640))

    arrow((550, 650), (550, 690))
    draw_end(550, 720)

    img.save("c:/xampp8.1.25/htdocs/web_gis/public/activity_diagram_web_gis.png")


if __name__ == "__main__":
    main()
