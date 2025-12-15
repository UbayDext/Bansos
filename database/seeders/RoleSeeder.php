<?php

namespace Database\Seeders;

use App\Models\{Role, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Buat role (roles table hanya punya 'name')
        $admin   = Role::firstOrCreate(['name' => 'admin']);
        $partner = Role::firstOrCreate(['name' => 'partner']);

        // 2) (Opsional) Pastikan ada 1 user admin default
        //    Kalau belum ada user sama sekali, kita buat 1 akun admin.
        $user = User::first();
        if (! $user) {
            $user = User::create([
                'name'     => 'admin',
                'email'    => 'admin@gmail.com',
                'password' => Hash::make('password'), // ganti setelah login ya
            ]);
        }

        // 3) Assign role admin ke user pertama
        //    Bisa lewat pivot langsung atau method assignRole dari trait HasRoles
        // $user->roles()->syncWithoutDetaching([$admin->id]);
        $user->assignRole('admin'); // gunakan trait HasRoles yang sudah kamu buat
    }
}
