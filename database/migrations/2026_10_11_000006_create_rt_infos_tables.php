<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rt_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('rt_announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('category')->default('Informasi');
            $table->date('tanggal')->nullable();
            $table->boolean('is_urgent')->default(false);
            $table->timestamps();
        });

        Schema::create('rt_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('phone')->nullable();
            $table->string('icon')->default('person');
            $table->timestamps();
        });

        Schema::create('rt_gallery', function (Blueprint $table) {
            $table->id();
            $table->text('image');
            $table->timestamps();
        });

        DB::table('rt_settings')->insert([
            ['key' => 'status_text', 'value' => 'Aktif & Kondusif', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'lapak_aktif', 'value' => '24', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'total_warga', 'value' => '156 KK', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'kegiatan_bulan_ini', 'value' => '3', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('rt_announcements')->insert([
            [
                'title' => 'Kerja Bakti Persiapan Musim Hujan',
                'body' => 'Diharapkan kehadiran seluruh warga untuk membersihkan saluran air dan fasilitas umum RT 04 mulai pukul 07:00 WIB.',
                'category' => 'Segera',
                'tanggal' => '2024-10-12',
                'is_urgent' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Iuran Bulanan & Dana Sosial Okotober',
                'body' => 'Pembayaran iuran bulanan dan dana sosial periode Oktober dapat dilakukan melalui Bendahara RT.',
                'category' => 'Administrasi',
                'tanggal' => '2024-10-10',
                'is_urgent' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Jadwal Posyandu Balita & Lansia',
                'body' => 'Posyandu rutin dilaksanakan untuk balita dan lansia sebulan sekali di Balai RT.',
                'category' => 'Kesehatan',
                'tanggal' => '2024-10-08',
                'is_urgent' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('rt_contacts')->insert([
            ['name' => 'Bpk. Haryono', 'role' => 'Ketua RT 04', 'phone' => null, 'icon' => 'person', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pos Satpam', 'role' => 'Keamanan 24 Jam', 'phone' => null, 'icon' => 'security', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bpk. Slamet', 'role' => 'Pengelola Sampah', 'phone' => null, 'icon' => 'recycling', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('rt_gallery')->insert([
            ['image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCP41h2w-qKa_VTP2kzliY4Fdon82yBpc4Lqe1GlbJSYTxRQKPtjusY3aJxosci9s7qOrfAAJBcu4oDCZe2CxH3nOkWl_2Rzh0hc2yTeZMR92fU_pnjJZoeIfTCsG7716lsdPTxk1nFVV7wmHigVYOKU0KizdH62c2783MCW7kczRza0S9MRKlQMj33oLb0sn9JwU7enJVgkBbugt-9IzR4Tet_6sdYBlNJq95--TMmkLI1uB276j7JHA', 'created_at' => now(), 'updated_at' => now()],
            ['image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBShn0OJfmUNjwBBFl_bEuvxAePt0DqjEF4gWeCQsPzWg7VL6CLsnVk3CFN4v1gdbA4vbvxvDwXUBia154t8idlfKsIbD3dRG05hVpl1z2LzasjT9WhUqK7W2op5kUqtosGkiGjEIopmO2JTmGyjLbUqtWXbMxtkksg8c-fb8NC1IZwKsw6peZF3Shjgox5MtdZlmRDnzO77CcHpkwSLQg9YQ9Atgg7qyRXkn8HfWjp3NEFaWffioaxeA', 'created_at' => now(), 'updated_at' => now()],
            ['image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuASWKA2zMSHwXJ2T97Kxs9KNsFwRtz5KTsMxn8U8TEBqMajA5uEinj2TlSpBGb-rvVlnNpqGM-hEi5hQ8zzRVxdDZsIwt64VybRIhI-0cf0cRQKJ6vcIB__01D1kTv0e5trPmbtqd5SK_AW81g0hnaOb_BszjNQfrCzPVOo83I_2qo28ujlB9qjnqNWo5zxmkRNk_khmUxm5PCjdQ6IsUtm46ch3R2ergKWf05NC96yglPig6ilv44CQA', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('rt_gallery');
        Schema::dropIfExists('rt_contacts');
        Schema::dropIfExists('rt_announcements');
        Schema::dropIfExists('rt_settings');
    }
};