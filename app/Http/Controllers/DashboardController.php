<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard utama pengguna.
     */
    public function index()
    {
        // Data pengguna aktif
        $user = [
            'name' => "Muhammad Rifa'a",
            'role' => 'Pengguna',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80',
            'unread_notifications' => 1,
            'current_location' => [
                'name' => 'Sekitar Kampus',
                'detail' => 'STIKes Muhammadiyah Lhokseumawe',
            ],
        ];

        // Banner Promo Dinamis (Render Gambar Banner Asli / Siap Diunggah Admin)
        // Gambar banner siap pakai yang memadukan promosi kuliner kampus
        $banners = [
            [
                'id' => 1,
                'title' => 'Jajanan Favorit Di Sekitar Kampus!',
                'subtitle' => 'Dukung UMKM lokal, nikmati rasa terbaik.',
                'image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=900&auto=format&fit=crop&q=80',
                'link' => '#umkm-terdekat',
                'badge' => 'Promo Hari Ini',
                'cta' => 'Lihat Promo'
            ],
            [
                'id' => 2,
                'title' => 'Diskon Mahasiswa Akhir Bulan Hemat 30%',
                'subtitle' => 'Makan kenyang kantong tetap aman.',
                'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=900&auto=format&fit=crop&q=80',
                'link' => '#menu-pilihan',
                'badge' => 'Diskon Spesial',
                'cta' => 'Klaim Diskon'
            ],
            [
                'id' => 3,
                'title' => 'Ngopi Santai Sore Nugas Bareng Teman',
                'subtitle' => 'Kopi susu gula aren & cemilan nikmat terdekat.',
                'image' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=900&auto=format&fit=crop&q=80',
                'link' => '#menu-pilihan',
                'badge' => 'Tempat Nugas',
                'cta' => 'Cek Kedai'
            ],
            [
                'id' => 4,
                'title' => 'Jajanan Tradisional Manis & Renyah',
                'subtitle' => 'Pisang goreng madu, risoles mayo, dan kue basah.',
                'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=900&auto=format&fit=crop&q=80',
                'link' => '#umkm-terdekat',
                'badge' => 'Jajanan Sore',
                'cta' => 'Pesan Sekarang'
            ],
        ];

        // Daftar Kategori (Icon Squircle dengan Label di Bawahnya)
        $categories = [
            ['id' => 'all', 'name' => 'Semua', 'slug' => 'all', 'active' => true, 'icon' => 'grid'],
            ['id' => 'makanan-berat', 'name' => 'Makanan Berat', 'slug' => 'makanan-berat', 'active' => false, 'icon' => 'bowl'],
            ['id' => 'cemilan', 'name' => 'Cemilan', 'slug' => 'cemilan', 'active' => false, 'icon' => 'snack'],
            ['id' => 'minuman', 'name' => 'Minuman', 'slug' => 'minuman', 'active' => false, 'icon' => 'drink'],
            ['id' => 'tradisional', 'name' => 'Tradisional', 'slug' => 'tradisional', 'active' => false, 'icon' => 'traditional'],
            ['id' => 'snack', 'name' => 'Snack', 'slug' => 'snack', 'active' => false, 'icon' => 'snack-box'],
            ['id' => 'kopi', 'name' => 'Kopi', 'slug' => 'kopi', 'active' => false, 'icon' => 'coffee'],
            ['id' => 'lainnya', 'name' => 'Lainnya', 'slug' => 'lainnya', 'active' => false, 'icon' => 'more'],
        ];

        // Section 1: UMKM Terdekat
        $nearby_stores = [
            [
                'id' => 1,
                'name' => 'Warung Bu Nita',
                'category_slug' => 'makanan-berat',
                'distance' => '0.3 km',
                'distance_num' => 0.3,
                'rating' => 4.8,
                'reviews_count' => 124,
                'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=500&auto=format&fit=crop&q=80',
                'whatsapp' => '6281234567890',
            ],
            [
                'id' => 2,
                'name' => 'Kedai Kopi Sudut',
                'category_slug' => 'minuman',
                'distance' => '0.7 km',
                'distance_num' => 0.7,
                'rating' => 4.6,
                'reviews_count' => 89,
                'image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=500&auto=format&fit=crop&q=80',
                'whatsapp' => '6281234567891',
            ],
            [
                'id' => 3,
                'name' => 'Pisang Goreng Madu',
                'category_slug' => 'cemilan',
                'distance' => '0.5 km',
                'distance_num' => 0.5,
                'rating' => 4.7,
                'reviews_count' => 67,
                'image' => 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=500&auto=format&fit=crop&q=80',
                'whatsapp' => '6281234567892',
            ],
            [
                'id' => 4,
                'name' => 'Seblak Teh Rani',
                'category_slug' => 'cemilan',
                'distance' => '0.4 km',
                'distance_num' => 0.4,
                'rating' => 4.7,
                'reviews_count' => 15,
                'image' => 'https://images.unsplash.com/photo-1617093727343-374698b1b08d?w=500&auto=format&fit=crop&q=80',
                'whatsapp' => '6281234567893',
            ],
            [
                'id' => 5,
                'name' => 'Warung Lestari',
                'category_slug' => 'makanan-berat',
                'distance' => '0.6 km',
                'distance_num' => 0.6,
                'rating' => 4.5,
                'reviews_count' => 52,
                'image' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=500&auto=format&fit=crop&q=80',
                'whatsapp' => '6281234567894',
            ],
        ];

        // Section 2: Menu Pilihan
        $recommended_menus = [
            [
                'id' => 101,
                'name' => 'Nasi Goreng Spesial',
                'seller' => 'Warung Bu Nita',
                'price' => 'Rp 12.000',
                'price_num' => 12000,
                'rating' => 4.8,
                'category_slug' => 'makanan-berat',
                'tags' => ['Makanan Berat', 'Nasi Goreng'],
                'image' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=500&auto=format&fit=crop&q=80',
                'description' => 'Nasi goreng racikan bumbu khas dengan telur ceplok, suwiran ayam, acar segar, dan kerupuk renyah.',
                'whatsapp' => '6281234567890',
            ],
            [
                'id' => 102,
                'name' => 'Es Teh Manis',
                'seller' => 'Es Teh Pakde',
                'price' => 'Rp 5.000',
                'price_num' => 5000,
                'rating' => 4.6,
                'category_slug' => 'minuman',
                'tags' => ['Minuman', 'Es Teh Segar'],
                'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=500&auto=format&fit=crop&q=80',
                'description' => 'Es teh melati segar manis alami dengan es batu kristal higienis pelepas dahaga.',
                'whatsapp' => '6281234567895',
            ],
            [
                'id' => 103,
                'name' => 'Mie Aceh',
                'seller' => 'Mie Aceh Bang Din',
                'price' => 'Rp 18.000',
                'price_num' => 18000,
                'rating' => 4.7,
                'category_slug' => 'makanan-berat',
                'tags' => ['Makanan Berat', 'Mie Aceh'],
                'image' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=500&auto=format&fit=crop&q=80',
                'description' => 'Mie kuning kenyal dengan kuah kari pedas kental khas Aceh, irisan daging empuk dan emping.',
                'whatsapp' => '6281234567892',
            ],
            [
                'id' => 104,
                'name' => 'Kopi Susu Aren',
                'seller' => 'Kedai Kopi Sudut',
                'price' => 'Rp 12.000',
                'price_num' => 12000,
                'rating' => 4.7,
                'category_slug' => 'minuman',
                'tags' => ['Minuman', 'Kopi'],
                'image' => 'https://images.unsplash.com/photo-1517256064527-09c73fc73e38?w=500&auto=format&fit=crop&q=80',
                'description' => 'Espresso blend lokal berpadu susu segar creamy dan gula aren murni.',
                'whatsapp' => '6281234567891',
            ],
            [
                'id' => 105,
                'name' => 'Pisang Goreng Madu',
                'seller' => 'Pisang Madu Juara',
                'price' => 'Rp 10.000',
                'price_num' => 10000,
                'rating' => 4.7,
                'category_slug' => 'cemilan',
                'tags' => ['Cemilan', 'Tradisional'],
                'image' => 'https://images.unsplash.com/photo-1528975604071-b4dc52a2d18c?w=500&auto=format&fit=crop&q=80',
                'description' => 'Pisang raja legit berlapis madu digoreng garing renyah karamel.',
                'whatsapp' => '6281234567892',
            ],
            [
                'id' => 106,
                'name' => 'Dimsum Komplit',
                'seller' => 'Dimsum Jaya',
                'price' => 'Rp 15.000',
                'price_num' => 15000,
                'rating' => 4.5,
                'category_slug' => 'cemilan',
                'tags' => ['Cemilan', 'Dimsum'],
                'image' => 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?w=500&auto=format&fit=crop&q=80',
                'description' => 'Dimsum ayam udang lembut disajikan hangat dengan chili oil dan saus asam manis.',
                'whatsapp' => '6281234567896',
            ],
        ];

        return view('dashboard', compact(
            'user',
            'banners',
            'categories',
            'nearby_stores',
            'recommended_menus'
        ));
    }
}
