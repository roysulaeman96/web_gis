<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Web Monitoring</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-a: #e9fff6;
            --bg-b: #fff4df;
            --bg-c: #dcf3ff;
            --card: rgba(255, 255, 255, .9);
            --ink: #143629;
            --muted: #567163;
            --line: #d4e8de;
            --accent: #f67a35;
            --accent-2: #00a774;
            --ok-bg: #e8fff3;
            --ok-ink: #0f7348;
            --error-bg: #ffe7e7;
            --error-ink: #a12626;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Sora', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 10% 14%, rgba(246, 122, 53, .25), transparent 36%),
                radial-gradient(circle at 90% 88%, rgba(0, 167, 116, .22), transparent 35%),
                radial-gradient(circle at 86% 16%, rgba(22, 134, 214, .2), transparent 33%),
                linear-gradient(145deg, var(--bg-a), var(--bg-b) 50%, var(--bg-c));
            display: grid;
            place-items: center;
            padding: 20px;
        }

        .card {
            width: min(460px, 100%);
            background: var(--card);
            border: 1px solid rgba(255, 255, 255, .75);
            border-radius: 20px;
            box-shadow: 0 26px 54px rgba(20, 54, 41, .14);
            backdrop-filter: blur(8px);
            padding: 26px;
            animation: rise .5s ease;
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            margin: 0;
            font-size: 1.45rem;
            line-height: 1.3;
        }

        .sub {
            margin: 8px 0 18px;
            color: var(--muted);
            font-size: .9rem;
        }

        .notice {
            border-radius: 12px;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-size: .86rem;
        }

        .notice.ok {
            background: var(--ok-bg);
            color: var(--ok-ink);
            border: 1px solid #c6ebd9;
        }

        .notice.error {
            background: var(--error-bg);
            color: var(--error-ink);
            border: 1px solid #f2c2c2;
        }

        .field {
            margin-bottom: 12px;
        }

        .field label {
            display: block;
            margin-bottom: 6px;
            font-size: .82rem;
            font-weight: 700;
            color: #2f5d4b;
        }

        .field input {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 11px 12px;
            font: inherit;
            background: #fff;
        }

        .field input:focus {
            outline: none;
            border-color: var(--accent-2);
            box-shadow: 0 0 0 4px rgba(0, 167, 116, .15);
        }

        .submit-btn {
            width: 100%;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font: inherit;
            font-weight: 800;
            color: #fff;
            cursor: pointer;
            background: linear-gradient(130deg, var(--accent), #ff9a50 45%, var(--accent-2));
            box-shadow: 0 12px 22px rgba(0, 167, 116, .25);
            transition: transform .15s ease;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
        }

        .foot {
            margin-top: 14px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            font-size: .82rem;
            color: var(--muted);
        }

        .link-btn {
            color: #1e6148;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid #cae2d6;
            border-radius: 999px;
            padding: 7px 10px;
            background: #f2fff8;
        }

        .help {
            margin-top: 14px;
            font-size: .78rem;
            line-height: 1.55;
            color: var(--muted);
            border: 1px dashed #cfe4d8;
            border-radius: 10px;
            padding: 9px;
            background: rgba(255, 255, 255, .72);
        }
    </style>
</head>

<body>
    <main class="card">
        <h1>Login Web Monitoring</h1>
        <p class="sub">Login sebagai Admin atau Petugas.</p>

        @if (session('status'))
        <div class="notice ok">{{ session('status') }}</div>
        @endif

        @if($errors->any())
        <div class="notice error">{{ $errors->first() }}</div>
        @endif

        <form method="post" action="{{ route('login.submit', [], false) }}">
            @csrf
            <div class="field">
                <label for="login">Email atau Username</label>
                <input id="login" type="text" name="login" value="{{ old('login') }}" required autocomplete="username">
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>

            <button class="submit-btn" type="submit">Masuk</button>
        </form>



    </main>
</body>

</html>