<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User | Web Monitoring</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-a: #e9fff6;
            --bg-b: #fff5e5;
            --bg-c: #e2f4ff;
            --card: rgba(255, 255, 255, .92);
            --ink: #15392b;
            --muted: #567265;
            --line: #d2e6dc;
            --accent: #00a976;
            --error-bg: #ffe8e8;
            --error-ink: #a22727;
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
                radial-gradient(circle at 8% 14%, rgba(254, 151, 84, .22), transparent 35%),
                radial-gradient(circle at 88% 88%, rgba(0, 169, 118, .24), transparent 35%),
                linear-gradient(145deg, var(--bg-a), var(--bg-b) 50%, var(--bg-c));
            display: grid;
            place-items: center;
            padding: 20px;
        }

        .card {
            width: min(520px, 100%);
            background: var(--card);
            border: 1px solid rgba(255, 255, 255, .82);
            border-radius: 20px;
            box-shadow: 0 24px 50px rgba(21, 57, 43, .13);
            padding: 24px;
        }

        h1 {
            margin: 0;
            font-size: 1.35rem;
        }

        .sub {
            margin: 8px 0 16px;
            font-size: .9rem;
            color: var(--muted);
        }

        .error {
            background: var(--error-bg);
            color: var(--error-ink);
            border: 1px solid #f3c1c1;
            border-radius: 12px;
            padding: 10px;
            margin-bottom: 12px;
            font-size: .86rem;
        }

        .grid {
            display: grid;
            gap: 12px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: .82rem;
            font-weight: 700;
            color: #2f5e4b;
        }

        input {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 11px 12px;
            font: inherit;
            background: #fff;
        }

        input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(0, 169, 118, .15);
        }

        .submit-btn {
            width: 100%;
            margin-top: 14px;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font: inherit;
            font-weight: 800;
            cursor: pointer;
            color: #fff;
            background: linear-gradient(130deg, #00a976, #21c390);
            box-shadow: 0 12px 22px rgba(0, 169, 118, .23);
        }

        .foot {
            margin-top: 14px;
            display: flex;
            justify-content: space-between;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
            font-size: .82rem;
            color: var(--muted);
        }

        .link-btn {
            text-decoration: none;
            border: 1px solid #cae2d6;
            border-radius: 999px;
            padding: 7px 10px;
            background: #f2fff8;
            color: #1d6249;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <main class="card">
        <h1>Pendaftaran User</h1>
        <p class="sub">Daftar akun baru sebagai petugas untuk masuk ke sistem monitoring.</p>

        @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="post" action="{{ route('register.submit', [], false) }}">
            @csrf
            <div class="grid">
                <div>
                    <label for="name">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div>
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required>
                </div>

                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <div>
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>
            </div>

            <button type="submit" class="submit-btn">Daftar</button>
        </form>

        <div class="foot">
            <span>Sudah punya akun?</span>
            <a class="link-btn" href="{{ route('login', [], false) }}">Kembali ke Login</a>
        </div>
    </main>
</body>

</html>