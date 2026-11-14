from PIL import Image, ImageDraw, ImageFont

BG = (255, 255, 255)
LINE = (45, 45, 45)
TEXT = (20, 20, 20)
HEADER_BG = (220, 230, 245)

CANVAS_W = 1200
CANVAS_H = 900
img = None
draw = None

try:
    font = ImageFont.truetype("arial.ttf", 14)
    font_bold = ImageFont.truetype("arialbd.ttf", 15)
except Exception:
    font = ImageFont.load_default()
    font_bold = ImageFont.load_default()


def set_canvas(width, height):
    global img, draw, CANVAS_W, CANVAS_H
    CANVAS_W = width
    CANVAS_H = height
    img = Image.new("RGB", (width, height), BG)
    draw = ImageDraw.Draw(img)


def draw_title(title):
    draw.rectangle([20, 20, CANVAS_W - 20, 60], fill=HEADER_BG, outline=LINE, width=2)
    draw.text((CANVAS_W // 2, 40), title, fill=TEXT, font=font_bold, anchor="mm")


def class_height(attrs):
    return 30 + (len(attrs) * 18) + 12


def draw_class_box(x, y, w, title, attrs):
    h = class_height(attrs)
    draw.rectangle([x, y, x + w, y + h], outline=LINE, width=2)
    draw.rectangle([x, y, x + w, y + 30], fill=HEADER_BG, outline=LINE, width=2)
    draw.text((x + w // 2, y + 15), title, fill=TEXT, font=font_bold, anchor="mm")
    for i, attr in enumerate(attrs):
        draw.text((x + 10, y + 38 + (i * 18)), attr, fill=TEXT, font=font)
    return (x, y, x + w, y + h)


def mid_right(rect):
    return (rect[2], (rect[1] + rect[3]) // 2)


def mid_left(rect):
    return (rect[0], (rect[1] + rect[3]) // 2)


def mid_top(rect):
    return ((rect[0] + rect[2]) // 2, rect[1])


def mid_bottom(rect):
    return ((rect[0] + rect[2]) // 2, rect[3])


def draw_relation(p1, p2, label1, label2, color=LINE, mid_x=None):
    if mid_x is None:
        draw.line([p1, p2], fill=color, width=2)
    else:
        draw.line([p1, (mid_x, p1[1]), (mid_x, p2[1]), p2], fill=color, width=2)
    draw.text((p1[0] - 14, p1[1] - 12), label1, fill=TEXT, font=font)
    draw.text((p2[0] + 6, p2[1] - 12), label2, fill=TEXT, font=font)


def render_core():
    set_canvas(980, 640)
    draw_title("Class Diagram Database WEB_GIS (Core)")

    users_attrs = [
        "id (PK)",
        "name",
        "email (UQ)",
        "username (UQ)",
        "role",
        "email_verified_at",
        "password",
        "remember_token",
        "created_at",
        "updated_at",
    ]

    sampahs_attrs = [
        "id (PK)",
        "user_id (FK)",
        "latitude",
        "longitude",
        "keterangan",
        "created_at",
        "updated_at",
    ]

    trackings_attrs = [
        "id (PK)",
        "user_id (FK)",
        "latitude",
        "longitude",
        "image_before_path",
        "image_after_path",
        "session_id",
        "tracked_at",
        "created_at",
        "updated_at",
    ]

    users = draw_class_box(310, 90, 360, "users", users_attrs)
    sampahs = draw_class_box(80, 330, 360, "sampahs", sampahs_attrs)
    trackings = draw_class_box(540, 330, 360, "trackings", trackings_attrs)

    draw_relation(mid_bottom(users), mid_top(sampahs), "1", "*", color=LINE, mid_x=240)
    draw_relation(mid_bottom(users), mid_top(trackings), "1", "*", color=LINE, mid_x=740)

    img.save("c:/xampp8.1.25/htdocs/web_gis/public/class_diagram_web_gis_core.png")


def render_full():
    set_canvas(1200, 900)
    draw_title("Class Diagram Database WEB_GIS (Full)")

    left_x = 60
    right_x = 720
    box_w = 420

    users_attrs = [
        "id (PK)",
        "name",
        "email (UQ)",
        "username (UQ)",
        "role",
        "email_verified_at",
        "password",
        "remember_token",
        "created_at",
        "updated_at",
    ]

    sampahs_attrs = [
        "id (PK)",
        "user_id (FK)",
        "latitude",
        "longitude",
        "keterangan",
        "created_at",
        "updated_at",
    ]

    trackings_attrs = [
        "id (PK)",
        "user_id (FK)",
        "latitude",
        "longitude",
        "image_before_path",
        "image_after_path",
        "session_id",
        "tracked_at",
        "created_at",
        "updated_at",
    ]

    tokens_attrs = [
        "id (PK)",
        "tokenable_type",
        "tokenable_id",
        "name",
        "token (UQ)",
        "abilities",
        "last_used_at",
        "expires_at",
        "created_at",
        "updated_at",
    ]

    reset_attrs = [
        "email (PK)",
        "token",
        "created_at",
    ]

    failed_attrs = [
        "id (PK)",
        "uuid (UQ)",
        "connection",
        "queue",
        "payload",
        "exception",
        "failed_at",
    ]

    migrations_attrs = [
        "id (PK)",
        "migration",
        "batch",
    ]

    y = 90
    users = draw_class_box(left_x, y, box_w, "users", users_attrs)
    y += class_height(users_attrs) + 26
    sampahs = draw_class_box(left_x, y, box_w, "sampahs", sampahs_attrs)
    y += class_height(sampahs_attrs) + 26
    trackings = draw_class_box(left_x, y, box_w, "trackings", trackings_attrs)

    y2 = 90
    tokens = draw_class_box(right_x, y2, box_w, "personal_access_tokens", tokens_attrs)
    y2 += class_height(tokens_attrs) + 26
    reset = draw_class_box(right_x, y2, box_w, "password_reset_tokens", reset_attrs)
    y2 += class_height(reset_attrs) + 26
    failed = draw_class_box(right_x, y2, box_w, "failed_jobs", failed_attrs)
    y2 += class_height(failed_attrs) + 26
    migrations = draw_class_box(right_x, y2, box_w, "migrations", migrations_attrs)

    color_users_sampahs = (60, 125, 210)
    color_users_trackings = (40, 160, 110)
    color_users_tokens = (200, 90, 90)
    color_users_reset = (150, 110, 210)

    draw_relation(mid_right(users), mid_left(tokens), "1", "*", color=color_users_tokens, mid_x=660)
    draw_relation(mid_right(users), mid_left(reset), "1", "0..1", color=color_users_reset, mid_x=660)
    draw_relation(mid_right(users), mid_right(sampahs), "1", "*", color=color_users_sampahs, mid_x=560)
    draw_relation(mid_right(users), mid_right(trackings), "1", "*", color=color_users_trackings, mid_x=560)

    img.save("c:/xampp8.1.25/htdocs/web_gis/public/class_diagram_web_gis_full.png")


def main():
    render_core()
    render_full()


if __name__ == "__main__":
    main()
