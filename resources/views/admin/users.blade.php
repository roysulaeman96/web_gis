<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran User Admin | Web GIS Monitoring</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-a: #ecfff7;
            --bg-b: #fff6e7;
            --bg-c: #e3f4ff;
            --card: rgba(255, 255, 255, .92);
            --line: #d1e5db;
            --ink: #153a2d;
            --muted: #5a7568;
            --accent: #0e84d8;
            --accent-2: #00aa77;
            --ok-bg: #e9fff3;
            --ok-ink: #0f7448;
            --error-bg: #ffe8e8;
            --error-ink: #a62727;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Sora', sans-serif;
            color: var(--ink);
            overflow-x: hidden;
            background:
                radial-gradient(circle at 10% 10%, rgba(14, 132, 216, .2), transparent 35%),
                radial-gradient(circle at 92% 86%, rgba(0, 170, 119, .22), transparent 34%),
                radial-gradient(circle at 88% 14%, rgba(255, 147, 78, .2), transparent 32%),
                linear-gradient(145deg, var(--bg-a), var(--bg-b) 50%, var(--bg-c));
        }

        .layout {
            width: min(1220px, 100%);
            margin: 0 auto;
            padding: 18px;
            display: grid;
            gap: 12px;
        }

        .card {
            background: var(--card);
            border: 1px solid rgba(255, 255, 255, .8);
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(20, 57, 44, .11);
            padding: 14px;
        }

        .head {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .head h1 {
            margin: 0;
            font-size: 1.15rem;
        }

        .head p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: .84rem;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .btn {
            border: 1px solid #c9e0d4;
            border-radius: 12px;
            padding: 9px 11px;
            text-decoration: none;
            color: #1b5f46;
            background: #f0fff8;
            font-size: .84rem;
            font-weight: 700;
        }

        .btn-danger {
            border: 1px solid #e8b9b9;
            border-radius: 12px;
            padding: 9px 11px;
            background: #ffeaea;
            color: #9c2525;
            font-size: .84rem;
            font-weight: 700;
            cursor: pointer;
        }

        .mini-btn {
            border: 1px solid #c9e0d4;
            border-radius: 10px;
            padding: 6px 10px;
            font-size: .78rem;
            font-weight: 700;
            background: #f1fff8;
            color: #1b5f46;
            cursor: pointer;
        }

        .muted {
            color: var(--muted);
            font-size: .8rem;
        }

        .notice {
            margin-top: 10px;
            border-radius: 12px;
            padding: 10px 12px;
            font-size: .85rem;
        }

        .notice.ok {
            background: var(--ok-bg);
            border: 1px solid #caecd9;
            color: var(--ok-ink);
        }

        .notice.error {
            background: var(--error-bg);
            border: 1px solid #f2c3c3;
            color: var(--error-ink);
        }

        .grid {
            margin-top: 12px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .field label {
            display: block;
            margin-bottom: 6px;
            font-size: .81rem;
            font-weight: 700;
            color: #2f5d4b;
        }

        .field input,
        .field select {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 10px 11px;
            font: inherit;
            font-size: .88rem;
            background: #fff;
            color: var(--ink);
        }

        .field input:focus,
        .field select:focus {
            outline: none;
            border-color: var(--accent-2);
            box-shadow: 0 0 0 4px rgba(0, 170, 119, .14);
        }

        .grid .full {
            grid-column: 1 / -1;
        }

        .submit-btn {
            border: none;
            border-radius: 12px;
            padding: 11px;
            cursor: pointer;
            font: inherit;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(130deg, var(--accent), #3aa7ef 45%, var(--accent-2));
            box-shadow: 0 10px 20px rgba(14, 132, 216, .24);
        }

        .submit-wrap {
            margin-top: 20px;
        }

        .table-wrap {
            margin-top: 14px;
            overflow-x: auto;
            border: 1px solid #dcede6;
            border-radius: 12px;
            background: #fff;
        }

        .table-actions {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
            justify-content: space-between;
        }

        .table-actions-left {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .check-all-inline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border: 1px solid #cfe4d9;
            border-radius: 10px;
            background: #f7fffb;
            font-size: .8rem;
            font-weight: 700;
            color: #255b47;
            user-select: none;
        }

        .check-all-inline input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #00aa77;
            cursor: pointer;
        }

        .checkbox-col {
            width: 44px;
            text-align: center;
        }

        .checkbox-col input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #00aa77;
            cursor: pointer;
        }

        .edit-box {
            margin-top: 12px;
            border: 1px dashed #cfe5d9;
            border-radius: 14px;
            padding: 12px;
            background: #f9fffc;
        }

        .edit-box h3 {
            margin: 0;
            font-size: .95rem;
        }

        .edit-box p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: .8rem;
        }

        .edit-box[hidden] {
            display: none !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 640px;
            font-size: .86rem;
        }

        th,
        td {
            border-bottom: 1px solid #edf5f0;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f8fefb;
            color: var(--muted);
            font-weight: 700;
        }

        td.empty-cell {
            text-align: center;
        }

        .action-cell {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .role {
            display: inline-flex;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: .74rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .role.admin {
            background: #e4f2ff;
            color: #0c5ea6;
        }

        .role.petugas {
            background: #e5fff3;
            color: #0c7448;
        }

        @media (max-width: 900px) {
            .layout {
                padding: 14px;
            }

            .card {
                border-radius: 16px;
                padding: 12px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .actions,
            .btn,
            .submit-btn,
            .btn-danger {
                width: 100%;
            }

            .table-actions {
                align-items: stretch;
            }

            .table-actions-left {
                width: 100%;
                flex-direction: column;
                align-items: flex-start;
            }

            .submit-wrap {
                margin-top: 16px;
            }

            .head {
                align-items: stretch;
            }

            .muted {
                font-size: .76rem;
            }
        }

        @media (max-width: 640px) {
            table {
                min-width: 100%;
                border-collapse: separate;
                border-spacing: 0;
            }

            thead {
                display: none;
            }

            tbody tr {
                display: block;
                border-bottom: 1px solid #edf5f0;
                padding: 10px 0;
            }

            tbody tr:last-child {
                border-bottom: none;
            }

            td {
                display: grid;
                grid-template-columns: 110px 1fr;
                gap: 8px;
                padding: 4px 10px;
                border: none;
                font-size: .81rem;
                word-break: break-word;
            }

            td::before {
                content: attr(data-label);
                font-weight: 700;
                color: #355f4f;
            }

            td.checkbox-col {
                display: flex;
                justify-content: flex-start;
                align-items: center;
                gap: 8px;
            }

            td.checkbox-col::before {
                content: none;
            }

            td.action-cell {
                display: block;
            }

            td.action-cell::before {
                content: 'Aksi';
                display: block;
                margin-bottom: 6px;
                font-weight: 700;
                color: #355f4f;
            }

            td.empty-cell {
                display: block;
                padding: 10px;
            }

            td.empty-cell::before {
                content: none;
            }
        }
    </style>
</head>

<body>
    <div class="layout">
        <section class="card">
            <div class="head">
                <div>
                    <h1>Pendaftaran User oleh Admin</h1>
                    <p>Admin: {{ $user->name }}. Tambahkan user baru dengan role Admin atau Petugas.</p>
                </div>
                <div class="actions">
                    <a class="btn" href="{{ route('dashboard', [], false) }}">Dashboard</a>
                </div>
            </div>

            @if (session('status'))
            <div class="notice ok">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
            <div class="notice error">{{ $errors->first() }}</div>
            @endif

            <form method="post" action="{{ route('admin.users.store', [], false) }}">
                @csrf
                <div class="grid">
                    <div class="field">
                        <label for="name">Nama</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="field">
                        <label for="username">Username</label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required>
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="field">
                        <label for="role">Role</label>
                        <select id="role" name="role" required>
                            <option value="petugas" @selected(old('role')==='petugas' )>Petugas</option>
                            <option value="admin" @selected(old('role')==='admin' )>Admin</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="kelompok_id">Nama Kelompok</label>
                        <select id="kelompok_id" name="kelompok_id">
                            <option value="">Pilih Kelompok</option>
                            @foreach ($kelompoks as $kelompok)
                            <option value="{{ $kelompok->id }}" @selected(old('kelompok_id') == $kelompok->id)>{{ $kelompok->nama_kelompok }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required>
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required>
                    </div>

                    <div class="field full submit-wrap">
                        <button type="submit" class="submit-btn">Simpan User</button>
                    </div>
                </div>
            </form>

            <div class="edit-box" id="editUserBox" hidden>
                <h3>Edit User</h3>
                <p>Perbarui data user. Kosongkan password jika tidak ingin mengubah password.</p>
                <form id="editUserForm" method="post" style="margin-top:10px;">
                    @csrf
                    @method('PUT')
                    <div class="grid" style="margin-top:0;">
                        <div class="field">
                            <label for="edit_name">Nama</label>
                            <input id="edit_name" type="text" name="name" required>
                        </div>

                        <div class="field">
                            <label for="edit_username">Username</label>
                            <input id="edit_username" type="text" name="username" required>
                        </div>

                        <div class="field">
                            <label for="edit_email">Email</label>
                            <input id="edit_email" type="email" name="email" required>
                        </div>

                        <div class="field">
                            <label for="edit_role">Role</label>
                            <select id="edit_role" name="role" required>
                                <option value="petugas">Petugas</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="edit_kelompok_id">Nama Kelompok</label>
                            <select id="edit_kelompok_id" name="kelompok_id">
                                <option value="">Pilih Kelompok</option>
                                @foreach ($kelompoks as $kelompok)
                                <option value="{{ $kelompok->id }}">{{ $kelompok->nama_kelompok }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="edit_password">Password Baru (opsional)</label>
                            <input id="edit_password" type="password" name="password">
                        </div>

                        <div class="field">
                            <label for="edit_password_confirmation">Konfirmasi Password Baru</label>
                            <input id="edit_password_confirmation" type="password" name="password_confirmation">
                        </div>

                        <div class="field full submit-wrap" style="margin-top: 12px;">
                            <button type="submit" class="submit-btn">Update User</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <section class="card">
            <h2 style="margin:0;font-size:1rem;">Daftar User Terdaftar</h2>
            <form id="bulkDeleteForm" method="post" action="{{ route('admin.users.bulk-delete', [], false) }}">
                @csrf
                @method('DELETE')
                <div class="table-actions">
                    <div class="table-actions-left">
                        <label class="check-all-inline" for="checkAllUsersInline">
                            <input id="checkAllUsersInline" type="checkbox" aria-label="Centang semua user">
                            <span>Semua</span>
                        </label>
                        <button type="submit" id="bulkDeleteBtn" class="btn-danger" disabled>Hapus User Terpilih</button>
                        <span class="muted">Centang 1 user untuk hapus satu, atau centang semua untuk hapus massal.</span>
                    </div>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th class="checkbox-col"><input id="checkAllUsers" type="checkbox" aria-label="Pilih semua user"></th>
                                <th>Nama</th>
                                <th>Nama Kelompok</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $item)
                            <tr>
                                <td class="checkbox-col">
                                    <input
                                        class="user-check"
                                        type="checkbox"
                                        name="user_ids[]"
                                        value="{{ $item->id }}"
                                        @disabled($item->id === $user->id)
                                    aria-label="Pilih user {{ $item->name }}">
                                </td>
                                <td data-label="Nama">{{ $item->name }}</td>
                                <td data-label="Nama Kelompok">{{ $item->kelompok?->nama_kelompok ?? '-' }}</td>
                                <td data-label="Username">{{ $item->username ?? '-' }}</td>
                                <td data-label="Email">{{ $item->email }}</td>
                                <td data-label="Role">
                                    <span class="role {{ $item->role }}">{{ $item->role }}</span>
                                </td>
                                <td data-label="Dibuat">{{ optional($item->created_at)->format('d-m-Y H:i') }}</td>
                                <td class="action-cell">
                                    <button
                                        type="button"
                                        class="mini-btn edit-user-btn"
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        data-username="{{ $item->username }}"
                                        data-email="{{ $item->email }}"
                                        data-role="{{ $item->role }}"
                                        data-kelompok-id="{{ $item->kelompok_id ?? '' }}">Edit</button>
                                    @if ($item->id === $user->id)
                                    <span class="muted">Akun Anda</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="empty-cell">Belum ada user.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </section>
    </div>

    <script>
        const checkAllUsersEl = document.getElementById('checkAllUsers');
        const checkAllUsersInlineEl = document.getElementById('checkAllUsersInline');
        const userCheckEls = Array.from(document.querySelectorAll('.user-check'));
        const bulkDeleteBtnEl = document.getElementById('bulkDeleteBtn');
        const bulkDeleteFormEl = document.getElementById('bulkDeleteForm');

        const editUserBoxEl = document.getElementById('editUserBox');
        const editUserFormEl = document.getElementById('editUserForm');
        const editNameEl = document.getElementById('edit_name');
        const editUsernameEl = document.getElementById('edit_username');
        const editEmailEl = document.getElementById('edit_email');
        const editRoleEl = document.getElementById('edit_role');
        const editKelompokEl = document.getElementById('edit_kelompok_id');
        const editPasswordEl = document.getElementById('edit_password');
        const editPasswordConfirmEl = document.getElementById('edit_password_confirmation');
        const createRoleEl = document.getElementById('role');
        const createKelompokEl = document.getElementById('kelompok_id');

        const updateUrlTemplate = @json(route('admin.users.update', ['targetUser' => '__USER_ID__'], false));

        function syncRoleFields(roleEl, kelompokEl, anggotaEl) {
            const isPetugas = roleEl?.value === 'petugas';

            if (kelompokEl) {
                kelompokEl.required = isPetugas;
            }
        }

        function initRoleFieldState() {
            syncRoleFields(createRoleEl, createKelompokEl);
            syncRoleFields(editRoleEl, editKelompokEl);
        }

        function applyMasterCheckboxState(checked, indeterminate) {
            if (checkAllUsersEl) {
                checkAllUsersEl.checked = checked;
                checkAllUsersEl.indeterminate = indeterminate;
            }

            if (checkAllUsersInlineEl) {
                checkAllUsersInlineEl.checked = checked;
                checkAllUsersInlineEl.indeterminate = indeterminate;
            }
        }

        function refreshBulkDeleteState() {
            const enabledChecks = userCheckEls.filter((input) => !input.disabled);
            const checkedChecks = enabledChecks.filter((input) => input.checked);

            bulkDeleteBtnEl.disabled = checkedChecks.length === 0;

            if (enabledChecks.length === 0) {
                applyMasterCheckboxState(false, false);
                return;
            }

            applyMasterCheckboxState(
                checkedChecks.length === enabledChecks.length,
                checkedChecks.length > 0 && checkedChecks.length < enabledChecks.length
            );
        }

        function toggleAllUsers(isChecked) {
            userCheckEls.forEach((input) => {
                if (!input.disabled) {
                    input.checked = isChecked;
                }
            });
            refreshBulkDeleteState();
        }

        checkAllUsersEl?.addEventListener('change', () => {
            toggleAllUsers(checkAllUsersEl.checked);
        });

        checkAllUsersInlineEl?.addEventListener('change', () => {
            toggleAllUsers(checkAllUsersInlineEl.checked);
        });

        userCheckEls.forEach((input) => {
            input.addEventListener('change', refreshBulkDeleteState);
        });

        bulkDeleteFormEl?.addEventListener('submit', (event) => {
            if (bulkDeleteBtnEl.disabled) {
                event.preventDefault();
                return;
            }

            const confirmed = window.confirm('Hapus user yang dipilih? Tindakan ini tidak bisa dibatalkan.');
            if (!confirmed) {
                event.preventDefault();
            }
        });

        document.querySelectorAll('.edit-user-btn').forEach((button) => {
            button.addEventListener('click', () => {
                const userId = button.dataset.id;
                editUserFormEl.action = updateUrlTemplate.replace('__USER_ID__', userId);

                editNameEl.value = button.dataset.name || '';
                editUsernameEl.value = button.dataset.username || '';
                editEmailEl.value = button.dataset.email || '';
                editRoleEl.value = button.dataset.role || 'petugas';
                editKelompokEl.value = button.dataset.kelompokId || '';
                editPasswordEl.value = '';
                editPasswordConfirmEl.value = '';

                syncRoleFields(editRoleEl, editKelompokEl);

                editUserBoxEl.hidden = false;
                editUserBoxEl.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });

        createRoleEl?.addEventListener('change', () => syncRoleFields(createRoleEl, createKelompokEl));
        editRoleEl?.addEventListener('change', () => syncRoleFields(editRoleEl, editKelompokEl));

        initRoleFieldState();
        refreshBulkDeleteState();
    </script>
</body>

</html>