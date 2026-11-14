import os
from PIL import Image, ImageDraw, ImageFont

OUT_PATH = "c:/xampp8.1.25/htdocs/web_gis/public/diagrams/sequence_admin_kelola_user.png"
os.makedirs(os.path.dirname(OUT_PATH), exist_ok=True)

WIDTH = 1200
HEIGHT = 650
BG = (255, 255, 255)
LINE = (40, 40, 40)
TEXT = (20, 20, 20)
HEADER_BG = (220, 230, 245)

img = Image.new("RGB", (WIDTH, HEIGHT), BG)
draw = ImageDraw.Draw(img)

try:
    font = ImageFont.truetype("arial.ttf", 13)
    font_bold = ImageFont.truetype("arialbd.ttf", 13)
except Exception:
    font = ImageFont.load_default()
    font_bold = ImageFont.load_default()


def text_size(text, use_font):
    bbox = draw.textbbox((0, 0), text, font=use_font)
    return (bbox[2] - bbox[0], bbox[3] - bbox[1])


def draw_centered_text(x, y, text, use_font):
    w, h = text_size(text, use_font)
    draw.text((x - w // 2, y - h // 2), text, fill=TEXT, font=use_font)


def draw_header(x, y, w, h, text):
    draw.rectangle([x - w // 2, y - h // 2, x + w // 2, y + h // 2], fill=HEADER_BG, outline=LINE, width=2)
    draw_centered_text(x, y, text, font_bold)


def draw_dashed_line(x1, y1, x2, y2, dash=6, gap=4):
    if x1 == x2:
        y = min(y1, y2)
        y_end = max(y1, y2)
        while y < y_end:
            draw.line([(x1, y), (x2, min(y + dash, y_end))], fill=LINE, width=1)
            y += dash + gap
    else:
        x = min(x1, x2)
        x_end = max(x1, x2)
        while x < x_end:
            draw.line([(x, y1), (min(x + dash, x_end), y2)], fill=LINE, width=1)
            x += dash + gap


def draw_lifeline(x, y_top, y_bottom):
    draw_dashed_line(x, y_top, x, y_bottom, dash=8, gap=6)


def draw_arrow(x1, y, x2, label=None, dashed=False):
    if dashed:
        draw_dashed_line(x1, y, x2, y, dash=8, gap=6)
    else:
        draw.line([(x1, y), (x2, y)], fill=LINE, width=2)

    # arrow head
    if x2 >= x1:
        tip = (x2, y)
        left = (x2 - 8, y - 4)
        right = (x2 - 8, y + 4)
    else:
        tip = (x2, y)
        left = (x2 + 8, y - 4)
        right = (x2 + 8, y + 4)
    draw.polygon([tip, left, right], fill=LINE)

    if label:
        draw_centered_text((x1 + x2) // 2, y - 12, label, font)


def main():
    draw_centered_text(WIDTH // 2, 30, "Sequence Diagram - Admin Kelola User", font_bold)

    lifelines = [
        ("Admin", 100),
        ("Halaman Kelola User", 330),
        ("UserManagementController", 590),
        ("User Model", 860),
        ("Database", 1080),
    ]

    header_y = 70
    header_w = 180
    header_h = 34
    line_top = 90
    line_bottom = 610

    for name, x in lifelines:
        draw_header(x, header_y, header_w, header_h, name)
        draw_lifeline(x, line_top, line_bottom)

    y = 120
    step = 32

    # Open page
    draw_arrow(lifelines[0][1], y, lifelines[1][1], "Buka halaman kelola user")
    y += step
    draw_arrow(lifelines[1][1], y, lifelines[2][1], "GET /admin/users")
    y += step
    draw_arrow(lifelines[2][1], y, lifelines[3][1], "query users")
    y += step
    draw_arrow(lifelines[3][1], y, lifelines[4][1], "SELECT users")
    y += step
    draw_arrow(lifelines[4][1], y, lifelines[3][1], "result", dashed=True)
    y += step
    draw_arrow(lifelines[3][1], y, lifelines[2][1], "users list", dashed=True)
    y += step
    draw_arrow(lifelines[2][1], y, lifelines[1][1], "render admin.users", dashed=True)
    y += step

    # Create user
    y += 10
    draw_arrow(lifelines[0][1], y, lifelines[1][1], "Submit tambah user")
    y += step
    draw_arrow(lifelines[1][1], y, lifelines[2][1], "POST /admin/users")
    y += step
    draw_arrow(lifelines[2][1], y, lifelines[3][1], "create user")
    y += step
    draw_arrow(lifelines[3][1], y, lifelines[4][1], "INSERT users")
    y += step
    draw_arrow(lifelines[4][1], y, lifelines[3][1], "OK", dashed=True)
    y += step
    draw_arrow(lifelines[3][1], y, lifelines[2][1], "created", dashed=True)
    y += step
    draw_arrow(lifelines[2][1], y, lifelines[1][1], "redirect + status", dashed=True)
    y += step
    draw_arrow(lifelines[1][1], y, lifelines[0][1], "Tampilkan status", dashed=True)

    img.save(OUT_PATH)


if __name__ == "__main__":
    main()
