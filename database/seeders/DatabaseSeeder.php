<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        $admin = User::create([
            'name' => 'Admin BeritaKini',
            'email' => 'admin@beritakini.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'favorite_categories' => ['Technology', 'Business'],
        ]);

        // 2. Akun User Biasa Pertama
        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'favorite_categories' => ['Technology', 'Sports'],
        ]);

        // 3. Akun User Biasa Kedua
        $user2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'favorite_categories' => ['Health', 'Science'],
        ]);

        // 4. Komentar Simulasi (Mhs 3)
        $url1 = 'https://example.com/tech-ai-indonesia';
        $hash1 = md5($url1);

        Comment::create([
            'user_id' => $user1->id,
            'article_url' => $url1,
            'article_url_hash' => $hash1,
            'comment_text' => 'Inisiatif yang luar biasa dari Kemkominfo! Semoga startup lokal bisa bersaing secara global dalam pengembangan AI.',
        ]);

        Comment::create([
            'user_id' => $user2->id,
            'article_url' => $url1,
            'article_url_hash' => $hash1,
            'comment_text' => 'Setuju. Pendanaan dan pelatihan seperti ini yang sangat dibutuhkan agar kita tidak hanya menjadi konsumen teknologi saja.',
        ]);

        Comment::create([
            'user_id' => $admin->id,
            'article_url' => $url1,
            'article_url_hash' => $hash1,
            'comment_text' => 'Terima kasih atas masukannya. Kami (pihak pengelola portal) akan terus memantau perkembangan program ini.',
        ]);

        $url2 = 'https://example.com/sports-timnas-win';
        $hash2 = md5($url2);

        Comment::create([
            'user_id' => $user1->id,
            'article_url' => $url2,
            'article_url_hash' => $hash2,
            'comment_text' => 'Pertandingan yang sangat menegangkan! Gol menit akhir benar-benar membuat merinding. Garuda Jaya!',
        ]);
    }
}