<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 60)->nullable()->after('email');
        });

        $used = [];

        $users = DB::table('users')
            ->select(['id', 'email', 'username'])
            ->orderBy('id')
            ->get();

        foreach ($users as $user) {
            if (! empty($user->username)) {
                $used[] = strtolower($user->username);
                continue;
            }

            $emailLocal = explode('@', (string) $user->email)[0] ?? '';
            $base = strtolower(preg_replace('/[^a-z0-9._-]+/i', '', $emailLocal));
            if ($base === '') {
                $base = 'user';
            }

            $candidate = substr($base, 0, 48);
            if ($candidate === '') {
                $candidate = 'user';
            }

            while (in_array(strtolower($candidate), $used, true)) {
                $candidate = substr($base, 0, 40) . '_' . $user->id;
                if (strlen($candidate) > 60) {
                    $candidate = substr($candidate, 0, 60);
                }
            }

            DB::table('users')
                ->where('id', $user->id)
                ->update(['username' => $candidate]);

            $used[] = strtolower($candidate);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unique('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn('username');
        });
    }
};
