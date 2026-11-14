import os
from PIL import Image, ImageDraw, ImageFont

OUT_PATH = "c:/xampp8.1.25/htdocs/web_gis/public/diagrams/sequence_admin_input_lokasi_sampah.png"
os.makedirs(os.path.dirname(OUT_PATH), exist_ok=True)

WIDTH = 920
HEIGHT = 520
BG = (255, 255, 255)
LINE = (60, 60, 60)
TEXT = (40, 40, 40)
HEADER_BG = (230, 238, 250)
LIFELINE = (180, 180, 180)

img = Image.new("RGB", (WIDTH, HEIGHT), BG)
draw = ImageDraw.Draw(img)

try:
    font = ImageFont.truetype("arial.ttf", 11)
    font_bold = ImageFont.truetype("arialbd.ttf", 11)
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


def draw_dashed_line(x1, y1, x2, y2, dash=5, gap=4):
    if x1 == x2:
        y = min(y1, y2)
        y_end = max(y1, y2)
        while y < y_end:
            draw.line([(x1, y), (x2, min(y + dash, y_end))], fill=LIFELINE, width=1)
            y += dash + gap
    else:
        x = min(x1, x2)
        x_end = max(x1, x2)
        while x < x_end:
            draw.line([(x, y1), (min(x + dash, x_end), y2)], fill=LINE, width=1)
            x += dash + gap


def draw_lifeline(x, y_top, y_bottom):
    draw_dashed_line(x, y_top, x, y_bottom, dash=6, gap=6)


def draw_actor(x, y, label):
    r = 7
    draw.ellipse([x - r, y - r, x + r, y + r], outline=LINE, width=2)
    draw.line([(x, y + r), (x, y + 22)], fill=LINE, width=2)
    draw.line([(x - 10, y + 10), (x + 10, y + 10)], fill=LINE, width=2)
    draw.line([(x - 6, y + 22), (x, y + 32)], fill=LINE, width=2)
    draw.line([(x + 6, y + 22), (x, y + 32)], fill=LINE, width=2)
    draw_centered_text(x, y + 46, label, font_bold)


def draw_arrow(x1, y, x2, label=None, dashed=False):
    if dashed:
        draw_dashed_line(x1, y, x2, y, dash=6, gap=4)
    else:
        draw.line([(x1, y), (x2, y)], fill=LINE, width=1)

    if x2 >= x1:
        tip = (x2, y)
        left = (x2 - 6, y - 3)
        right = (x2 - 6, y + 3)
    else:
        tip = (x2, y)
        left = (x2 + 6, y - 3)
        right = (x2 + 6, y + 3)
    draw.polygon([tip, left, right], fill=LINE)

    if label:
        draw_centered_text((x1 + x2) // 2, y - 9, label, font)


def draw_activation(x, y_top, y_bottom):
    draw.rectangle([x - 4, y_top, x + 4, y_bottom], outline=LINE, width=1)


def main():
    lifelines = [
        ("Admin", 60, "actor"),
        ("Halaman Tracking", 220, "header"),
        ("API Tracking", 400, "header"),
        ("Database", 580, "header"),
        ("Peta GIS", 760, "header"),
    ]

    header_y = 40
    header_w = 140
    header_h = 28
    line_top = 70
    line_bottom = 470

    for name, x, kind in lifelines:
        if kind == "actor":
            draw_actor(x, 40, name)
        else:
            draw_header(x, header_y, header_w, header_h, name)
        draw_lifeline(x, line_top, line_bottom)

    y = 95
    step = 20

    draw_arrow(lifelines[0][1], y, lifelines[1][1], "1 : Buka Halaman Tracking()")
    y += step
    draw_arrow(lifelines[1][1], y, lifelines[2][1], "2 : Ambil Daftar Petugas()")
    y += step
    draw_arrow(lifelines[2][1], y, lifelines[3][1], "3 : Daftar Petugas", dashed=True)
    y += step
    draw_arrow(lifelines[1][1], y, lifelines[0][1], "4 : Menampilkan Halaman Tracking", dashed=True)
    y += step
    draw_arrow(lifelines[0][1], y, lifelines[1][1], "5 : Pilih Petugas()")
    y += step
    draw_arrow(lifelines[0][1], y, lifelines[1][1], "6 : Pilih Periode Filter()")
    y += step
    draw_arrow(lifelines[1][1], y, lifelines[2][1], "7 : Request Data Tracking()")
    y += step
    draw_arrow(lifelines[2][1], y, lifelines[3][1], "8 : Query Data Tracking()")

    y += step
    draw_arrow(lifelines[3][1], y, lifelines[2][1], "9 : Data Tracking Kosong", dashed=True)
    y += step
    draw_arrow(lifelines[2][1], y, lifelines[1][1], "10 : Response Data Kosong", dashed=True)
    y += step
    draw_arrow(lifelines[1][1], y, lifelines[0][1], "11 : Menampilkan Pesan Tidak Ada Data", dashed=True)

    y += step
    draw_arrow(lifelines[3][1], y, lifelines[2][1], "12 : Data Tracking Ditemukan", dashed=True)
    y += step
    draw_arrow(lifelines[2][1], y, lifelines[1][1], "13 : Response Data Tracking", dashed=True)
    y += step
    draw_arrow(lifelines[1][1], y, lifelines[4][1], "14 : Tampilkan Polyline Rute()")
    y += step
    draw_arrow(lifelines[1][1], y, lifelines[4][1], "15 : Tampilkan Titik Tracking()")
    y += step
    draw_arrow(lifelines[1][1], y, lifelines[0][1], "16 : Menampilkan Rute Tracking pada Peta", dashed=True)

    img.save(OUT_PATH)


if __name__ == "__main__":
    main()
