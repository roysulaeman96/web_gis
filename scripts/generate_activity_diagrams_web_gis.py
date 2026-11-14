import os
from PIL import Image, ImageDraw, ImageFont

OUT_DIR = "c:/xampp8.1.25/htdocs/web_gis/public/diagrams"
os.makedirs(OUT_DIR, exist_ok=True)

BG = (255, 255, 255)
LINE = (40, 40, 40)
TEXT = (20, 20, 20)
BAR = (0, 0, 0)
HEADER_BG = (220, 230, 245)

try:
    FONT = ImageFont.truetype("arial.ttf", 14)
    FONT_BOLD = ImageFont.truetype("arialbd.ttf", 15)
except Exception:
    FONT = ImageFont.load_default()
    FONT_BOLD = ImageFont.load_default()


def text_size(draw, text, use_font):
    bbox = draw.textbbox((0, 0), text, font=use_font)
    return (bbox[2] - bbox[0], bbox[3] - bbox[1])


def draw_centered_lines(draw, cx, cy, lines, use_font):
    sizes = [text_size(draw, line, use_font) for line in lines]
    line_h = max([h for _, h in sizes] + [14]) + 2
    total_h = line_h * len(lines)
    start_y = cy - (total_h // 2)
    for i, line in enumerate(lines):
        w, h = sizes[i]
        x = cx - (w // 2)
        y = start_y + (i * line_h)
        draw.text((x, y), line, fill=TEXT, font=use_font)


def draw_title(draw, width, title):
    draw.rectangle([20, 20, width - 20, 60], fill=HEADER_BG, outline=LINE, width=2)
    draw_centered_lines(draw, width // 2, 40, [title], FONT_BOLD)


def round_rect(draw, x0, y0, x1, y1, r=12, outline=LINE, fill=None, width=2):
    try:
        draw.rounded_rectangle([x0, y0, x1, y1], radius=r, outline=outline, fill=fill, width=width)
    except Exception:
        draw.rectangle([x0, y0, x1, y1], outline=outline, fill=fill, width=width)


def draw_box(draw, cx, cy, w, h, text, bold=False):
    x0 = cx - w // 2
    y0 = cy - h // 2
    x1 = cx + w // 2
    y1 = cy + h // 2
    round_rect(draw, x0, y0, x1, y1)
    lines = text.split("\n")
    draw_centered_lines(draw, cx, cy, lines, FONT_BOLD if bold else FONT)
    return (x0, y0, x1, y1)


def draw_diamond(draw, cx, cy, w, h, text):
    pts = [(cx, cy - h // 2), (cx + w // 2, cy), (cx, cy + h // 2), (cx - w // 2, cy)]
    draw.polygon(pts, outline=LINE, fill=None)
    draw_centered_lines(draw, cx, cy, [text], FONT)
    return pts


def draw_bar(draw, x0, y, x1):
    draw.rectangle([x0, y, x1, y + 10], fill=BAR)
    return (x0, y, x1, y + 10)


def draw_start(draw, cx, cy):
    r = 12
    draw.ellipse([cx - r, cy - r, cx + r, cy + r], fill=BAR, outline=BAR)
    return (cx, cy)


def draw_end(draw, cx, cy):
    r1 = 12
    r2 = 18
    draw.ellipse([cx - r2, cy - r2, cx + r2, cy + r2], outline=BAR, width=2)
    draw.ellipse([cx - r1, cy - r1, cx + r1, cy + r1], fill=BAR, outline=BAR)
    return (cx, cy)


def arrow(draw, p1, p2):
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


def arrow_elbow(draw, p1, p2, mid_x=None, mid_y=None):
    x1, y1 = p1
    x2, y2 = p2
    if mid_x is None:
        mid_x = x1
    if mid_y is None:
        mid_y = y2
    draw.line([p1, (mid_x, y1), (mid_x, mid_y), (x2, mid_y)], fill=LINE, width=2)
    arrow(draw, (x2, mid_y), p2)


def center_top(rect):
    return ((rect[0] + rect[2]) // 2, rect[1])


def center_bottom(rect):
    return ((rect[0] + rect[2]) // 2, rect[3])


def center_left(rect):
    return (rect[0], (rect[1] + rect[3]) // 2)


def center_right(rect):
    return (rect[2], (rect[1] + rect[3]) // 2)


def draw_vertical_steps(draw, cx, start_y, steps, w=300, h=46, gap=30):
    boxes = []
    y = start_y
    for text in steps:
        box = draw_box(draw, cx, y, w, h, text)
        boxes.append(box)
        y += h + gap
    for i in range(len(boxes) - 1):
        arrow(draw, center_bottom(boxes[i]), center_top(boxes[i + 1]))
    return boxes


def save_image(img, name):
    img.save(os.path.join(OUT_DIR, name))


def diagram_role_admin():
    width, height = 1100, 760
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)
    draw_title(draw, width, "Activity Diagram - Admin")

    cx = width // 2
    start = draw_start(draw, cx, 80)
    login = draw_box(draw, cx, 140, 220, 46, "Login", bold=True)
    diamond = draw_diamond(draw, cx, 220, 70, 70, "Valid?")

    arrow(draw, (start[0], start[1] + 12), (cx, 118))
    arrow(draw, center_bottom(login), (cx, 185))

    # N loop to the left
    login_left = login[0]
    login_mid_y = (login[1] + login[3]) // 2
    diamond_left = (cx - 35, 220)
    loop_x = login_left - 30
    draw.line([diamond_left, (loop_x, diamond_left[1]), (loop_x, login_mid_y)], fill=LINE, width=2)
    arrow(draw, (loop_x, login_mid_y), (login_left, login_mid_y))
    draw_centered_lines(draw, loop_x + 10, diamond_left[1] - 10, ["N"], FONT)

    # Y flow
    draw_centered_lines(draw, cx + 15, 255, ["Y"], FONT)
    arrow(draw, (cx, 255), (cx, 280))

    fork = draw_bar(draw, 100, 310, 1000)
    arrow(draw, (cx, 280), (cx, 310))

    col_x = [200, 470, 740, 950]
    dashboard = draw_box(draw, col_x[0], 370, 200, 46, "Dashboard")
    kelola = draw_box(draw, col_x[1], 370, 220, 46, "Kelola User")
    riwayat = draw_box(draw, col_x[2], 370, 220, 46, "Riwayat Petugas")
    logout = draw_box(draw, col_x[3], 370, 160, 46, "Logout")

    for x, box in zip(col_x, [dashboard, kelola, riwayat, logout]):
        arrow(draw, (x, 310), center_top(box))

    # Sub bar and steps for admin operations
    sub_bar = draw_bar(draw, 340, 430, 870)
    arrow(draw, center_bottom(kelola), (col_x[1], 430))
    arrow(draw, center_bottom(riwayat), (col_x[2], 430))

    tambah = draw_box(draw, col_x[1], 490, 200, 42, "Tambah User")
    edit = draw_box(draw, col_x[1], 550, 200, 42, "Edit User")
    hapus = draw_box(draw, col_x[1], 610, 200, 42, "Hapus User")
    arrow(draw, (col_x[1], 440), center_top(tambah))
    arrow(draw, center_bottom(tambah), center_top(edit))
    arrow(draw, center_bottom(edit), center_top(hapus))

    export = draw_box(draw, col_x[2], 540, 200, 42, "Export CSV")
    arrow(draw, (col_x[2], 440), center_top(export))

    join = draw_bar(draw, 120, 690, 980)
    arrow(draw, center_bottom(dashboard), (col_x[0], 690))
    arrow(draw, center_bottom(hapus), (col_x[1], 690))
    arrow(draw, center_bottom(export), (col_x[2], 690))
    arrow(draw, center_bottom(logout), (col_x[3], 690))

    arrow(draw, (cx, 700), (cx, 720))
    draw_end(draw, cx, 730)

    save_image(img, "activity_role_admin.png")


def diagram_role_petugas():
    width, height = 900, 740
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)
    draw_title(draw, width, "Activity Diagram - Petugas")

    start = draw_start(draw, width // 2, 80)
    login = draw_box(draw, width // 2, 140, 220, 46, "Login", bold=True)
    arrow(draw, (start[0], start[1] + 12), (width // 2, 118))
    arrow(draw, center_bottom(login), (width // 2, 200))

    steps = [
        "Dashboard",
        "Mulai Tracking",
        "Input Lokasi Sampah",
        "Upload Foto Sebelum dan Sesudah",
        "Riwayat Tracking Saya",
        "Logout",
    ]
    boxes = draw_vertical_steps(draw, width // 2, 230, steps, w=300)
    arrow(draw, center_bottom(boxes[-1]), (width // 2, 680))
    draw_end(draw, width // 2, 710)

    save_image(img, "activity_role_petugas.png")


def diagram_feature_login():
    width, height = 900, 620
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)
    draw_title(draw, width, "Activity Diagram - Login")

    start = draw_start(draw, width // 2, 80)
    login = draw_box(draw, width // 2, 140, 220, 46, "Input Email dan Password")
    diamond = draw_diamond(draw, width // 2, 230, 70, 70, "Valid?")
    arrow(draw, (start[0], start[1] + 12), (width // 2, 118))
    arrow(draw, center_bottom(login), (width // 2, 195))

    # N loop
    right = (width // 2 + 35, 230)
    loop_x = width // 2 + 90
    draw.line([right, (loop_x, right[1]), (loop_x, 140)], fill=LINE, width=2)
    arrow(draw, (loop_x, 140), (width // 2 + 110, 140))
    draw_centered_lines(draw, loop_x - 10, 215, ["N"], FONT)

    # Y
    draw_centered_lines(draw, width // 2 + 15, 265, ["Y"], FONT)
    arrow(draw, (width // 2, 265), (width // 2, 300))
    dashboard = draw_box(draw, width // 2, 340, 220, 46, "Masuk Dashboard")
    arrow(draw, center_bottom(dashboard), (width // 2, 420))
    draw_end(draw, width // 2, 450)

    save_image(img, "activity_feature_login.png")


def diagram_feature_registrasi():
    width, height = 760, 540
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)
    draw_title(draw, width, "Activity Diagram - Registrasi")

    start = draw_start(draw, width // 2, 80)
    steps = [
        "Isi Form Registrasi",
        "Validasi Data",
        "Simpan User",
        "Login",
    ]
    arrow(draw, (start[0], start[1] + 12), (width // 2, 120))
    boxes = draw_vertical_steps(draw, width // 2, 150, steps, w=260)
    arrow(draw, center_bottom(boxes[-1]), (width // 2, 450))
    draw_end(draw, width // 2, 480)

    save_image(img, "activity_feature_registrasi.png")


def diagram_feature_kelola_user():
    width, height = 900, 680
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)
    draw_title(draw, width, "Activity Diagram - Kelola User")

    start = draw_start(draw, width // 2, 80)
    open_page = draw_box(draw, width // 2, 140, 260, 46, "Buka Halaman Kelola User")
    arrow(draw, (start[0], start[1] + 12), (width // 2, 118))
    arrow(draw, center_bottom(open_page), (width // 2, 190))

    fork = draw_bar(draw, 140, 210, 760)
    arrow(draw, (width // 2, 200), (width // 2, 210))

    tambah = draw_box(draw, 260, 280, 200, 46, "Tambah User")
    edit = draw_box(draw, 450, 280, 200, 46, "Edit User")
    hapus = draw_box(draw, 640, 280, 200, 46, "Hapus User")

    arrow(draw, (260, 210), center_top(tambah))
    arrow(draw, (450, 210), center_top(edit))
    arrow(draw, (640, 210), center_top(hapus))

    join = draw_bar(draw, 200, 360, 700)
    arrow(draw, center_bottom(tambah), (260, 360))
    arrow(draw, center_bottom(edit), (450, 360))
    arrow(draw, center_bottom(hapus), (640, 360))

    arrow(draw, (width // 2, 370), (width // 2, 420))
    draw_end(draw, width // 2, 450)

    save_image(img, "activity_feature_kelola_user.png")


def diagram_feature_tracking():
    width, height = 820, 620
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)
    draw_title(draw, width, "Activity Diagram - Tracking")

    start = draw_start(draw, width // 2, 80)
    steps = [
        "Mulai Tracking",
        "Ambil Lokasi GPS",
        "Kirim Titik Tracking",
        "Simpan Tracking",
        "Stop Tracking",
    ]
    arrow(draw, (start[0], start[1] + 12), (width // 2, 120))
    boxes = draw_vertical_steps(draw, width // 2, 150, steps, w=260)
    arrow(draw, center_bottom(boxes[-1]), (width // 2, 520))
    draw_end(draw, width // 2, 550)

    save_image(img, "activity_feature_tracking.png")


def diagram_feature_input_sampah():
    width, height = 760, 560
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)
    draw_title(draw, width, "Activity Diagram - Input Lokasi Sampah")

    start = draw_start(draw, width // 2, 80)
    steps = [
        "Klik Input Lokasi Sampah",
        "Ambil Lokasi GPS",
        "Simpan Data Sampah",
        "Tampil di Peta",
    ]
    arrow(draw, (start[0], start[1] + 12), (width // 2, 120))
    boxes = draw_vertical_steps(draw, width // 2, 150, steps, w=270)
    arrow(draw, center_bottom(boxes[-1]), (width // 2, 480))
    draw_end(draw, width // 2, 510)

    save_image(img, "activity_feature_input_sampah.png")


def diagram_feature_upload_foto():
    width, height = 820, 600
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)
    draw_title(draw, width, "Activity Diagram - Upload Foto")

    start = draw_start(draw, width // 2, 80)
    steps = [
        "Pilih Foto Sebelum",
        "Pilih Foto Sesudah",
        "Upload Foto",
        "Simpan Path Foto",
    ]
    arrow(draw, (start[0], start[1] + 12), (width // 2, 120))
    boxes = draw_vertical_steps(draw, width // 2, 150, steps, w=260)
    arrow(draw, center_bottom(boxes[-1]), (width // 2, 500))
    draw_end(draw, width // 2, 530)

    save_image(img, "activity_feature_upload_foto.png")


def diagram_feature_riwayat_saya():
    width, height = 760, 560
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)
    draw_title(draw, width, "Activity Diagram - Riwayat Tracking Saya")

    start = draw_start(draw, width // 2, 80)
    steps = [
        "Buka Riwayat Tracking",
        "Ambil Data Tracking",
        "Tampilkan Peta dan Tabel",
    ]
    arrow(draw, (start[0], start[1] + 12), (width // 2, 120))
    boxes = draw_vertical_steps(draw, width // 2, 150, steps, w=280)
    arrow(draw, center_bottom(boxes[-1]), (width // 2, 450))
    draw_end(draw, width // 2, 480)

    save_image(img, "activity_feature_riwayat_saya.png")


def diagram_feature_riwayat_petugas():
    width, height = 820, 600
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)
    draw_title(draw, width, "Activity Diagram - Riwayat Petugas")

    start = draw_start(draw, width // 2, 80)
    steps = [
        "Pilih Petugas",
        "Ambil Data Tracking",
        "Tampilkan Peta dan Tabel",
    ]
    arrow(draw, (start[0], start[1] + 12), (width // 2, 120))
    boxes = draw_vertical_steps(draw, width // 2, 150, steps, w=280)
    arrow(draw, center_bottom(boxes[-1]), (width // 2, 470))
    draw_end(draw, width // 2, 500)

    save_image(img, "activity_feature_riwayat_petugas.png")


def diagram_feature_export_csv():
    width, height = 760, 560
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)
    draw_title(draw, width, "Activity Diagram - Export CSV")

    start = draw_start(draw, width // 2, 80)
    steps = [
        "Klik Export CSV",
        "Ambil Data Tracking",
        "Generate File CSV",
        "Download CSV",
    ]
    arrow(draw, (start[0], start[1] + 12), (width // 2, 120))
    boxes = draw_vertical_steps(draw, width // 2, 150, steps, w=250)
    arrow(draw, center_bottom(boxes[-1]), (width // 2, 480))
    draw_end(draw, width // 2, 510)

    save_image(img, "activity_feature_export_csv.png")


def diagram_feature_logout():
    width, height = 700, 480
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)
    draw_title(draw, width, "Activity Diagram - Logout")

    start = draw_start(draw, width // 2, 80)
    steps = [
        "Klik Logout",
        "Hapus Token",
        "Kembali ke Login",
    ]
    arrow(draw, (start[0], start[1] + 12), (width // 2, 120))
    boxes = draw_vertical_steps(draw, width // 2, 150, steps, w=240)
    arrow(draw, center_bottom(boxes[-1]), (width // 2, 390))
    draw_end(draw, width // 2, 420)

    save_image(img, "activity_feature_logout.png")


def main():
    diagram_role_admin()
    diagram_role_petugas()
    diagram_feature_login()
    diagram_feature_registrasi()
    diagram_feature_kelola_user()
    diagram_feature_tracking()
    diagram_feature_input_sampah()
    diagram_feature_upload_foto()
    diagram_feature_riwayat_saya()
    diagram_feature_riwayat_petugas()
    diagram_feature_export_csv()
    diagram_feature_logout()


if __name__ == "__main__":
    main()
