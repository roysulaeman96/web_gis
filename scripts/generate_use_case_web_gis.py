from PIL import Image, ImageDraw, ImageFont
import textwrap

WIDTH = 1200
HEIGHT = 820
BG = (255, 255, 255)
LINE = (45, 45, 45)
TEXT = (25, 25, 25)
HEADER_BG = (220, 230, 245)

img = Image.new("RGB", (WIDTH, HEIGHT), BG)
draw = ImageDraw.Draw(img)

try:
    font = ImageFont.truetype("arial.ttf", 16)
    font_bold = ImageFont.truetype("arialbd.ttf", 18)
except Exception:
    font = ImageFont.load_default()
    font_bold = ImageFont.load_default()


def draw_title():
    title = "Use Case Diagram Sistem WEB_GIS"
    draw.rectangle([20, 20, WIDTH - 20, 66], fill=HEADER_BG, outline=LINE, width=2)
    draw.text((WIDTH // 2, 43), title, fill=TEXT, font=font_bold, anchor="mm")


def draw_actor(x, y, label):
    head_r = 16
    draw.ellipse([x - head_r, y - head_r, x + head_r, y + head_r], outline=LINE, width=2)
    draw.line([x, y + head_r, x, y + 52], fill=LINE, width=2)
    draw.line([x - 20, y + 24, x + 20, y + 24], fill=LINE, width=2)
    draw.line([x, y + 52, x - 18, y + 80], fill=LINE, width=2)
    draw.line([x, y + 52, x + 18, y + 80], fill=LINE, width=2)
    draw.text((x, y + 98), label, fill=TEXT, font=font, anchor="mm")


def wrap_text(text, max_width):
    words = text.split()
    lines = []
    current = []
    for word in words:
        test = " ".join(current + [word])
        bbox = draw.textbbox((0, 0), test, font=font)
        if bbox[2] - bbox[0] <= max_width or not current:
            current.append(word)
        else:
            lines.append(" ".join(current))
            current = [word]
    if current:
        lines.append(" ".join(current))
    return lines


def draw_use_case(cx, cy, w, h, text):
    x0 = cx - w // 2
    y0 = cy - h // 2
    x1 = cx + w // 2
    y1 = cy + h // 2
    draw.ellipse([x0, y0, x1, y1], outline=LINE, width=2)

    lines = wrap_text(text, w - 20)
    line_h = 18
    total_h = line_h * len(lines)
    start_y = cy - total_h // 2
    for i, line in enumerate(lines):
        draw.text((cx, start_y + i * line_h), line, fill=TEXT, font=font, anchor="mm")
    return (x0, y0, x1, y1)


def connect(p1, p2):
    draw.line([p1, p2], fill=LINE, width=2)


def connect_elbow(p1, p2, mid_x=None):
    if mid_x is None:
        mid_x = (p1[0] + p2[0]) // 2
    draw.line([p1, (mid_x, p1[1]), (mid_x, p2[1]), p2], fill=LINE, width=2)


def center(rect):
    return ((rect[0] + rect[2]) // 2, (rect[1] + rect[3]) // 2)


def left_mid(rect):
    return (rect[0], (rect[1] + rect[3]) // 2)


def right_mid(rect):
    return (rect[2], (rect[1] + rect[3]) // 2)


def draw_system_boundary():
    rect = [200, 96, 1000, 760]
    draw.rectangle(rect, outline=LINE, width=2)
    draw.text((600, 116), "Sistem WEB_GIS Monitoring Sampah", fill=TEXT, font=font_bold, anchor="mm")
    return rect


def main():
    draw_title()
    draw_system_boundary()

    # Actors
    draw_actor(110, 170, "Guest")
    draw_actor(110, 420, "Petugas")
    draw_actor(1090, 300, "Admin")

    # Use cases inside system boundary
    uc = {}
    uc["registrasi"] = draw_use_case(340, 160, 210, 52, "Registrasi")
    uc["login"] = draw_use_case(600, 160, 190, 52, "Login")

    uc["dashboard"] = draw_use_case(340, 260, 260, 56, "Lihat Dashboard dan Peta")
    uc["input_sampah"] = draw_use_case(340, 360, 240, 56, "Input Lokasi Sampah")
    uc["tracking"] = draw_use_case(340, 450, 220, 56, "Mulai Tracking")
    uc["upload"] = draw_use_case(340, 540, 280, 60, "Upload Foto Sebelum dan Sesudah")
    uc["riwayat_petugas"] = draw_use_case(340, 640, 250, 56, "Lihat Riwayat Tracking")
    uc["logout"] = draw_use_case(600, 700, 190, 52, "Logout")

    uc["riwayat_admin"] = draw_use_case(820, 300, 260, 56, "Lihat Riwayat Petugas")
    uc["kelola_user"] = draw_use_case(820, 390, 220, 52, "Kelola User")
    uc["export_csv"] = draw_use_case(820, 480, 220, 52, "Export CSV")

    # Connections
    # Guest
    connect_elbow((130, 170), left_mid(uc["registrasi"]), mid_x=200)
    connect_elbow((130, 170), left_mid(uc["login"]), mid_x=200)

    # Petugas
    for key in ["dashboard", "input_sampah", "tracking", "upload", "riwayat_petugas", "logout"]:
        connect_elbow((130, 420), left_mid(uc[key]), mid_x=200)

    # Admin
    for key in ["login", "dashboard", "riwayat_admin", "kelola_user", "export_csv", "logout"]:
        connect_elbow((1070, 300), right_mid(uc[key]), mid_x=1000)

    img.save("c:/xampp8.1.25/htdocs/web_gis/public/use_case_web_gis.png")


if __name__ == "__main__":
    main()
