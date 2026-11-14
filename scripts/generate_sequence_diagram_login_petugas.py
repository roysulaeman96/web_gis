import os
from PIL import Image, ImageDraw, ImageFont

OUT_PATH = "c:/xampp8.1.25/htdocs/web_gis/public/diagrams/sequence_login_petugas.png"
os.makedirs(os.path.dirname(OUT_PATH), exist_ok=True)

WIDTH = 530
HEIGHT = 480
BG = (255, 255, 255)
BLACK = (0, 0, 0)
GRAY = (60, 60, 60)
LIGHT_GRAY = (180, 180, 180)

img = Image.new("RGB", (WIDTH, HEIGHT), BG)
draw = ImageDraw.Draw(img)

try:
    font_label = ImageFont.truetype("arial.ttf", 9)
    font_msg = ImageFont.truetype("arial.ttf", 8)
except Exception:
    font_label = ImageFont.load_default()
    font_msg = ImageFont.load_default()


def draw_circle(x, y, r, outline_color, width):
    """Draw circle (head)"""
    draw.ellipse([x - r, y - r, x + r, y + r], outline=outline_color, width=width)


def draw_stick(x, y):
    """Draw stick figure"""
    head_r = 5
    draw_circle(x, y, head_r, BLACK, 2)
    # Body
    draw.line([(x, y + head_r), (x, y + 18)], fill=BLACK, width=2)
    # Arms
    draw.line([(x - 8, y + 8), (x + 8, y + 8)], fill=BLACK, width=2)
    # Legs
    draw.line([(x - 5, y + 18), (x, y + 28)], fill=BLACK, width=2)
    draw.line([(x + 5, y + 18), (x, y + 28)], fill=BLACK, width=2)


def draw_system_box(x, y, text):
    """Draw system box"""
    w, h = 60, 22
    draw.rectangle([x - w // 2, y - h // 2, x + w // 2, y + h // 2], outline=BLACK, width=1)
    draw.text((x - len(text) * 2.3, y - 4), text, fill=BLACK, font=font_label)


def draw_lifeline(x, y_start, y_end):
    """Draw dashed lifeline"""
    y = y_start
    while y <= y_end:
        draw.line([(x, y), (x, min(y + 2, y_end))], fill=LIGHT_GRAY, width=1)
        y += 6


def draw_message(x1, y, x2, label, dashed=False):
    """Draw message arrow"""
    # Draw line
    if dashed:
        x = min(x1, x2)
        x_end = max(x1, x2)
        while x < x_end:
            draw.line([(x, y), (min(x + 2, x_end), y)], fill=BLACK, width=1)
            x += 5
    else:
        draw.line([(x1, y), (x2, y)], fill=BLACK, width=1)

    # Arrowhead
    if x2 > x1:
        draw.polygon([(x2, y), (x2 - 4, y - 2), (x2 - 4, y + 2)], fill=BLACK)
    else:
        draw.polygon([(x2, y), (x2 + 4, y - 2), (x2 + 4, y + 2)], fill=BLACK)

    # Label - to the left
    label_x = min(x1, x2) - len(label) * 2.5 - 5
    label_y = y - 7
    draw.text((label_x, label_y), label, fill=GRAY, font=font_msg)


def main():
    # Actor position
    actor_x = 50
    actor_y = 25

    # System boxes
    sys_y = 25
    systems = [
        (120, "Form Login"),
        (200, "Password"),
        (280, "Data\nPetugas"),
        (360, "Halaman"),
    ]

    # Draw actor
    draw_stick(actor_x, actor_y)
    draw.text((actor_x - 14, actor_y + 32), "Petugas", fill=BLACK, font=font_label)

    # Draw system boxes
    for x, name in systems:
        draw_system_box(x, sys_y, name)

    # Lifelines
    lifeline_start = sys_y + 15
    lifeline_end = 420

    draw_lifeline(actor_x, lifeline_start, lifeline_end)
    for x, _ in systems:
        draw_lifeline(x, lifeline_start, lifeline_end)

    # Messages
    y_msg = 65

    # 1 : Isi Username Login()
    draw_message(actor_x, y_msg, systems[0][0], "1 : Isi Username Login()")
    y_msg += 20

    # 2 : Isi Password Login()
    draw_message(systems[0][0], y_msg, systems[1][0], "2 : Isi Password Login()")
    y_msg += 20

    # 3 : Kirim Kredensial()
    draw_message(systems[1][0], y_msg, systems[2][0], "3 : Kirim Kredensial()")
    y_msg += 20

    # 4 : Validasi Petugas() - box at Data Petugas
    box_x = systems[2][0]
    draw.rectangle([box_x - 4, y_msg - 8, box_x + 4, y_msg + 8], outline=BLACK, width=1)
    draw.text((box_x + 10, y_msg - 7), "4 : Validasi Petugas()", fill=GRAY, font=font_msg)
    y_msg += 18

    # 5 : Data Tidak Valid (dashed return)
    draw_message(systems[2][0], y_msg, systems[1][0], "5 : Data Tidak Valid", dashed=True)
    y_msg += 16

    # 6 : Password Salah (dashed return)
    draw_message(systems[1][0], y_msg, actor_x, "6 : Password Salah", dashed=True)
    y_msg += 16

    # 7 : Username Salah (dashed return)
    draw_message(systems[0][0], y_msg, actor_x, "7 : Username Salah", dashed=True)
    y_msg += 28

    # 8 : Buka Halaman Petugas()
    draw_message(systems[2][0], y_msg, systems[3][0], "8 : Buka Halaman Petugas()")
    y_msg += 20

    # 9 : Redirect Dashboard (dashed return)
    draw_message(systems[3][0], y_msg, actor_x, "9 : Redirect Dashboard", dashed=True)
    y_msg += 24

    # 10 : Menampilkan Dashboard (box)
    draw.rectangle([actor_x - 55, y_msg - 9, actor_x + 55, y_msg + 9], outline=BLACK, width=2)
    draw.text((actor_x - 48, y_msg - 6), "10 : Menampilkan Dashboard", fill=BLACK, font=font_msg)

    img.save(OUT_PATH)
    print(f"✓ Sequence diagram generated: {OUT_PATH}")


if __name__ == "__main__":
    main()
