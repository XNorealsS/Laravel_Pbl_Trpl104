<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Pengguna;
use App\Models\Pesan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\Umkm;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        Pengguna::create([
            'nama' => 'Administrator JajanRia',
            'email' => 'admin@jajanria.test',
            'password' => 'password',
            'role' => 'admin',
            'status_verifikasi' => 'terverifikasi',
        ]);

        // 2. Pengunjung (Customer)
        $pengunjung1 = Pengguna::create([
            'nama' => "Muhammad Rifa'a",
            'email' => 'pengunjung1@jajanria.test',
            'password' => 'password',
            'role' => 'pengunjung',
            'status_verifikasi' => 'terverifikasi',
        ]);

        $pengunjung2 = Pengguna::create([
            'nama' => 'Nadira Ramadhani',
            'email' => 'pengunjung2@jajanria.test',
            'password' => 'password',
            'role' => 'pengunjung',
            'status_verifikasi' => 'terverifikasi',
        ]);

        $pengunjung3 = Pengguna::create([
            'nama' => 'Karin Azrika',
            'email' => 'pengunjung3@jajanria.test',
            'password' => 'password',
            'role' => 'pengunjung',
            'status_verifikasi' => 'terverifikasi',
        ]);

        // 3. Kategori
        $kategoriList = [
            'Makanan Berat' => 'Aneka nasi, mie, sate, dan makanan utama yang mengenyangkan.',
            'Camilan' => 'Gorengan, martabak, roti, dan camilan santai.',
            'Minuman' => 'Aneka es, jus buah, teh segar, dan minuman dingin.',
            'Kopi' => 'Kopi susu gula aren, americano, dan varian kopi espresso.',
            'Tradisional' => 'Kue basah, jajanan pasar khas nusantara, dan olahan tradisional.',
        ];

        $kat = [];
        foreach ($kategoriList as $nama => $desk) {
            $k = Kategori::create([
                'nama_kategori' => $nama,
            ]);
            $kat[$nama] = $k->id_kategori;
        }

        $u = fn (string $id) => "https://images.unsplash.com/photo-{$id}?auto=format&fit=crop&w=800&q=80";

        // 4. Lapak UMKM
        $lapakData = [
            [
                'nama' => 'Warung Bu Tris',
                'area' => 'Kantin Gedung Utama',
                'lokasi' => 'Kantin Gedung Utama Lt. 1, Polibatam',
                'kontak' => '081270019283',
                'foto' => 'img/nasi-goreng.jpg',
                'status' => 'terverifikasi',
                'deskripsi' => 'Nasi campur, ayam geprek, dan masakan rumahan lezat harga mahasiswa.',
                'menu' => [
                    ['Ayam Geprek Sambal Korek', 'Makanan Berat', 15000, 'Ayam krispi digeprek sambal rawit pedas mantap.', $u('1626082927389-6cd097cdc6ec'), true],
                    ['Nasi Goreng Spesial', 'Makanan Berat', 13000, 'Nasi goreng telur, suwir ayam, dan kerupuk.', 'img/nasi-goreng.jpg', true],
                    ['Tahu & Tempe Crispy', 'Camilan', 6000, 'Tahu dan tempe goreng tepung renyah 4 pcs.', $u('1541592106381-b31e9677c0e5'), true],
                    ['Es Teh Manis Jumbo', 'Minuman', 4000, 'Teh melati manis segar porsi jumbo.', $u('1556679343-c7306c1976bc'), true],
                ],
            ],
            [
                'nama' => 'Mie Aceh Bang Din',
                'area' => 'Gerbang Utama',
                'lokasi' => 'Pujasera Gerbang Utama Polibatam Kav. 3',
                'kontak' => '082199881122',
                'foto' => 'img/mie-aceh.jpg',
                'status' => 'terverifikasi',
                'deskripsi' => 'Mie Aceh tumis, goreng, dan rebus dengan bumbu rempah otentik khas Serambi Mekkah.',
                'menu' => [
                    ['Mie Aceh Daging Tumis', 'Makanan Berat', 22000, 'Mie kuning tebal dengan potongan daging sapi kuah nyemek.', 'img/mie-aceh.jpg', true],
                    ['Mie Aceh Telur Rebus', 'Makanan Berat', 16000, 'Mie Aceh rempah kuah gurih dengan telur rebus.', 'img/mie-aceh.jpg', true],
                    ['Teh Tarik Panas / Dingin', 'Minuman', 8000, 'Teh tarik khas racikan susu kental manis berbusa.', $u('1576092768241-dec231879fc3'), true],
                ],
            ],
            [
                'nama' => 'Kedai Pisang Madu Bu Siti',
                'area' => 'Tower A',
                'lokasi' => 'Koridor Tower A samping gazebo Polibatam',
                'kontak' => '081364223311',
                'foto' => 'img/pisang-goreng.jpg',
                'status' => 'terverifikasi',
                'deskripsi' => 'Pisang goreng madu karamel renyah, risoles mayo, dan aneka gorengan hangat.',
                'menu' => [
                    ['Pisang Goreng Madu Wijen', 'Tradisional', 10000, 'Pisang raja matang dibalut madu karamel renyah (3 pcs).', 'img/pisang-goreng.jpg', true],
                    ['Risoles Smoked Beef Mayo', 'Camilan', 12000, 'Kulit lembut isi telur, daging asap, dan mayones melimpah.', $u('1608039829572-78524f79c4c7'), true],
                    ['Es Cincau Susu Gula Aren', 'Minuman', 7000, 'Cincau hitam kenyal dengan sirup gula aren dan susu murni.', $u('1513558161293-cdaf765ed2fd'), true],
                ],
            ],
            [
                'nama' => 'Kedai Kopi Sudut',
                'area' => 'Ruko KDA',
                'lokasi' => 'Ruko KDA Blok B No. 5, Batam Center',
                'kontak' => '087733119002',
                'foto' => 'img/kopi.jpg',
                'status' => 'terverifikasi',
                'deskripsi' => 'Kopi susu aren andalan mahasiswa Polibatam, tempat cozy pas untuk nugas.',
                'menu' => [
                    ['Kopi Susu Gula Aren', 'Kopi', 12000, 'Espresso double shot, susu segar, dan gula aren organik.', 'img/kopi.jpg', true],
                    ['Iced Americano', 'Kopi', 10000, 'Kopi hitam segar asam buah menyegarkan.', $u('1517701604599-bb29b565090c'), true],
                    ['Matcha Latte Ice', 'Minuman', 15000, 'Matcha premium Jepang diseduh susu dingin.', $u('1536256263959-770b48d82b0a'), true],
                    ['Roti Toast Cokelat Keju', 'Camilan', 12000, 'Roti brioche panggang garing isi limpahan cokelat keju.', $u('1528735602780-2552fd46c7af'), true],
                ],
            ],
            [
                'nama' => 'Martabak Bangka Mahasiswa',
                'area' => 'Halte Kampus',
                'lokasi' => 'Depan Halte Bus Kampus Polibatam',
                'kontak' => '085219823401',
                'foto' => $u('1626082927389-6cd097cdc6ec'),
                'status' => 'terverifikasi',
                'deskripsi' => 'Martabak manis legit bersarang dan martabak telur bebek gurih renyah.',
                'menu' => [
                    ['Martabak Manis Cokelat Keju', 'Camilan', 20000, 'Adonan lembut bersarang tebal taburan cokelat & cheddar.', $u('1567620905732-2d1ec7ab7445'), true],
                    ['Martabak Telur Bebek 3 Butir', 'Makanan Berat', 25000, 'Kulit garing isi daging sapi giling dan daun bawang segar.', $u('1626082927389-6cd097cdc6ec'), true],
                ],
            ],
            [
                'nama' => 'Burger Kampus Polibatam',
                'area' => 'Pujasera',
                'lokasi' => 'Pujasera Mahasiswa, gerbang barat Polibatam',
                'kontak' => '082281190099',
                'foto' => $u('1568901346375-23c9450c58cd'),
                'status' => 'terverifikasi',
                'deskripsi' => 'Burger daging sapi homemade, kentang goreng keju, dan aneka milkshake.',
                'menu' => [
                    ['Double Beef Cheese Burger', 'Makanan Berat', 22000, 'Dua lapis daging sapi murni panggang, keju lumer, saus mayo.', $u('1568901346375-23c9450c58cd'), true],
                    ['French Fries Curly', 'Camilan', 12000, 'Kentang goreng bumbu keju gurih renyah.', $u('1576107232684-1279f3908594'), true],
                    ['Milkshake Chocolate Float', 'Minuman', 10000, 'Susu kocok cokelat kental dengan es krim vanila.', $u('1572490122747-3968b75cc699'), true],
                ],
            ],
            [
                // Terverifikasi tetapi di luar sekitar kampus -> muncul hanya saat dicari
                'nama' => 'Warung Sate Cak Har',
                'area' => 'Nagoya',
                'lokasi' => 'Jl. Imam Bonjol No. 12, Nagoya, Batam',
                'kontak' => '081377224455',
                'foto' => $u('1555939594-58d7cb561ad1'),
                'status' => 'terverifikasi',
                'deskripsi' => 'Sate Madura daging empuk bumbu kacang kental dan gule kambing gurih.',
                'menu' => [
                    ['Sate Ayam Bumbu Kacang', 'Makanan Berat', 20000, '10 tusuk daging ayam montok + bumbu kacang lembut + lontong.', $u('1555939594-58d7cb561ad1'), true],
                    ['Gule Kambing Rempah', 'Makanan Berat', 22000, 'Kuah gulai rempah khas Jawa Timur harum sedap.', null, true],
                ],
            ],
            [
                // Belum diverifikasi (Menunggu verifikasi admin untuk UC-09)
                'nama' => 'Seblak Teh Rani',
                'area' => 'Ruko KDA',
                'lokasi' => 'Ruko KDA Blok B No. 4',
                'kontak' => '081200000004',
                'foto' => null,
                'status' => 'menunggu',
                'deskripsi' => 'Seblak Bandung pedas berlevel dengan topping lengkap.',
                'menu' => [
                    ['Seblak Komplit Ceker Sosis', 'Camilan', 14000, 'Kerupuk seblak, ceker ayam empuk, sosis, dan bakso kuah kencur.', null, true],
                ],
            ],
        ];

        $umkmMap = [];
        foreach ($lapakData as $i => $l) {
            $seller = Pengguna::create([
                'nama' => 'Pemilik ' . $l['nama'],
                'email' => 'seller' . ($i + 1) . '@jajanria.test',
                'password' => 'password',
                'role' => 'seller',
                'status_verifikasi' => $l['status'],
            ]);

            $umkm = Umkm::create([
                'id_user' => $seller->id_user,
                'nama_usaha' => $l['nama'],
                'deskripsi' => $l['deskripsi'],
                'lokasi' => $l['lokasi'],
                'area' => $l['area'],
                'kontak' => $l['kontak'],
                'foto_usaha' => $l['foto'],
            ]);
            $umkmMap[$l['nama']] = $umkm;

            foreach ($l['menu'] as [$namaM, $katM, $hrgM, $deskM, $fotoM, $tersediaM]) {
                Produk::create([
                    'id_umkm' => $umkm->id_umkm,
                    'id_kategori' => $kat[$katM],
                    'nama_produk' => $namaM,
                    'deskripsi' => $deskM,
                    'harga' => $hrgM,
                    'foto_produk' => $fotoM,
                    'tersedia' => $tersediaM,
                ]);
            }
        }

        // 5. Riwayat Pesanan & Chat & Ulasan (Untuk demo alur lengkap UC-03, UC-04, UC-07, UC-08)
        $wTris = $umkmMap['Warung Bu Tris'];
        $wMie = $umkmMap['Mie Aceh Bang Din'];
        $wKopi = $umkmMap['Kedai Kopi Sudut'];
        $wBurger = $umkmMap['Burger Kampus Polibatam'];

        // Pesanan 1: Selesai dengan Ulasan di Warung Bu Tris
        $p1 = Pesanan::create([
            'id_pengunjung' => $pengunjung1->id_user,
            'id_umkm' => $wTris->id_umkm,
            'status' => 'selesai',
            'waktu_selesai' => Carbon::now()->subHours(3),
        ]);

        Pesan::create([
            'id_pengunjung' => $pengunjung1->id_user,
            'id_umkm' => $wTris->id_umkm,
            'pengirim' => 'pengunjung',
            'isi_pesan' => 'Halo Bu Tris, apakah Ayam Geprek Sambal Korek masih ada?',
            'waktu' => Carbon::now()->subHours(4),
        ]);
        Pesan::create([
            'id_pengunjung' => $pengunjung1->id_user,
            'id_umkm' => $wTris->id_umkm,
            'pengirim' => 'seller',
            'isi_pesan' => 'Halo kak Rifa! Masih ada kak, mau sambal level berapa?',
            'waktu' => Carbon::now()->subHours(3)->subMinutes(50),
        ]);
        Pesan::create([
            'id_pengunjung' => $pengunjung1->id_user,
            'id_umkm' => $wTris->id_umkm,
            'pengirim' => 'pengunjung',
            'isi_pesan' => 'Level 2 pedas sedang ya bu, saya ambil 10 menit lagi di kantin.',
            'waktu' => Carbon::now()->subHours(3)->subMinutes(40),
        ]);
        Pesan::create([
            'id_pengunjung' => $pengunjung1->id_user,
            'id_umkm' => $wTris->id_umkm,
            'pengirim' => 'seller',
            'isi_pesan' => 'Siap kak, pesanan sudah siap dan selesai disajikan ya!',
            'waktu' => Carbon::now()->subHours(3),
        ]);

        Ulasan::create([
            'id_pesanan' => $p1->id_pesanan,
            'id_pengunjung' => $pengunjung1->id_user,
            'id_umkm' => $wTris->id_umkm,
            'rating' => 5,
            'komentar' => 'Ayam gepreknya sangat gurih dan sambal koreknya nendang banget! Porsi pas di kantin.',
            'balasan_seller' => 'Terima kasih banyak kak Rifa! Ditunggu kedatangannya lagi ya.',
            'disembunyikan' => false,
        ]);

        // Pesanan 2: Status "Diproses" di Mie Aceh Bang Din (Untuk mendemonstrasikan status update oleh Seller)
        $p2 = Pesanan::create([
            'id_pengunjung' => $pengunjung1->id_user,
            'id_umkm' => $wMie->id_umkm,
            'status' => 'diproses',
            'waktu_selesai' => null,
        ]);

        Pesan::create([
            'id_pengunjung' => $pengunjung1->id_user,
            'id_umkm' => $wMie->id_umkm,
            'pengirim' => 'pengunjung',
            'isi_pesan' => 'Bang Din, pesan Mie Aceh Daging Tumis 1 porsi ya.',
            'waktu' => Carbon::now()->subMinutes(25),
        ]);
        Pesan::create([
            'id_pengunjung' => $pengunjung1->id_user,
            'id_umkm' => $wMie->id_umkm,
            'pengirim' => 'seller',
            'isi_pesan' => 'Siap dek, sedang kami masak dengan rempah segar. Ditunggu ya!',
            'waktu' => Carbon::now()->subMinutes(18),
        ]);

        // Pesanan 3: Selesai di Kedai Kopi Sudut
        $p3 = Pesanan::create([
            'id_pengunjung' => $pengunjung2->id_user,
            'id_umkm' => $wKopi->id_umkm,
            'status' => 'selesai',
            'waktu_selesai' => Carbon::now()->subDays(1),
        ]);

        Ulasan::create([
            'id_pesanan' => $p3->id_pesanan,
            'id_pengunjung' => $pengunjung2->id_user,
            'id_umkm' => $wKopi->id_umkm,
            'rating' => 5,
            'komentar' => 'Kopi susu arennya juara, pas manisnya dan aromanya harum!',
            'balasan_seller' => 'Terima kasih kak Nadira!',
            'disembunyikan' => false,
        ]);

        // Pesanan 4: Selesai di Burger Kampus
        $p4 = Pesanan::create([
            'id_pengunjung' => $pengunjung3->id_user,
            'id_umkm' => $wBurger->id_umkm,
            'status' => 'selesai',
            'waktu_selesai' => Carbon::now()->subDays(2),
        ]);

        Ulasan::create([
            'id_pesanan' => $p4->id_pesanan,
            'id_pengunjung' => $pengunjung3->id_user,
            'id_umkm' => $wBurger->id_umkm,
            'rating' => 4,
            'komentar' => 'Burgernya tebal dan kejunya lumer. Mantap untuk santap sore.',
            'balasan_seller' => null,
            'disembunyikan' => false,
        ]);
    }
}
