<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class SeasonalGuideController extends Controller
{
    // Seasonal data per province slug
    const SEASONAL_DATA = [
        'bali' => [
            'best_months'   => [4,5,6,7,8,9],
            'avoid_months'  => [1,2,12],
            'festivals'     => [
                3  => ['Nyepi (Tahun Baru Saka)', 'Ogoh-ogoh Parade'],
                6  => ['Bali Arts Festival'],
                10 => ['Galungan & Kuningan'],
            ],
            'monthly' => [
                1  => ['weather' => 'hujan', 'crowd' => 'sedang',   'price' => 'rendah',   'tip' => 'Banyak hujan tapi murah. Cocok untuk spa dan budaya.'],
                2  => ['weather' => 'hujan', 'crowd' => 'sepi',     'price' => 'rendah',   'tip' => 'Musim tersepi. Harga terbaik.'],
                3  => ['weather' => 'berawan','crowd' => 'sedang',  'price' => 'sedang',   'tip' => 'Nyepi! Seluruh Bali berhenti 1 hari — pengalaman unik.'],
                4  => ['weather' => 'cerah', 'crowd' => 'sedang',   'price' => 'sedang',   'tip' => 'Mulai musim kering. Ideal untuk pantai.'],
                5  => ['weather' => 'cerah', 'crowd' => 'sedang',   'price' => 'sedang',   'tip' => 'Cuaca sempurna, belum ramai. Waktu terbaik!'],
                6  => ['weather' => 'cerah', 'crowd' => 'ramai',    'price' => 'tinggi',   'tip' => 'Bali Arts Festival. Sangat ramai tapi spektakuler.'],
                7  => ['weather' => 'cerah', 'crowd' => 'sangat ramai','price'=>'tertinggi','tip'=>'Puncak turis. Pesan jauh-jauh hari.'],
                8  => ['weather' => 'cerah', 'crowd' => 'sangat ramai','price'=>'tertinggi','tip'=>'Tetap puncak. Pantai sangat padat.'],
                9  => ['weather' => 'cerah', 'crowd' => 'ramai',    'price' => 'tinggi',   'tip' => 'Masih cerah, mulai berkurang turisnya.'],
                10 => ['weather' => 'berawan','crowd' => 'sedang',  'price' => 'sedang',   'tip' => 'Galungan! Hiasan penjor di mana-mana. Sangat indah.'],
                11 => ['weather' => 'hujan', 'crowd' => 'sepi',     'price' => 'rendah',   'tip' => 'Awal hujan. Alam sangat hijau.'],
                12 => ['weather' => 'hujan', 'crowd' => 'ramai',    'price' => 'tinggi',   'tip' => 'Natal & Tahun Baru mendongkrak harga meski hujan.'],
            ],
        ],
        'yogyakarta' => [
            'best_months'   => [5,6,7,8,9],
            'avoid_months'  => [1,2],
            'festivals'     => [
                1  => ['Sekaten (Maulid Nabi)'],
                5  => ['Waisak di Borobudur'],
                6  => ['Festival Kesenian Yogyakarta'],
                10 => ['Sekaten'],
            ],
            'monthly' => [
                1  => ['weather'=>'hujan',  'crowd'=>'sepi',    'price'=>'rendah', 'tip'=>'Hujan lebat. Borobudur sering berkabut — justru fotogenik!'],
                2  => ['weather'=>'hujan',  'crowd'=>'sepi',    'price'=>'rendah', 'tip'=>'Sepi pengunjung. Harga hotel sangat murah.'],
                3  => ['weather'=>'berawan','crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Mulai membaik. Nyaman untuk jalan kaki di Malioboro.'],
                4  => ['weather'=>'cerah',  'crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Cuaca bagus, belum ramai. Ideal!'],
                5  => ['weather'=>'cerah',  'crowd'=>'ramai',   'price'=>'tinggi', 'tip'=>'Waisak di Borobudur — momen paling sakral dan indah.'],
                6  => ['weather'=>'cerah',  'crowd'=>'ramai',   'price'=>'tinggi', 'tip'=>'Festival Kesenian Yogyakarta. Seni dan budaya di mana-mana.'],
                7  => ['weather'=>'cerah',  'crowd'=>'sangat ramai','price'=>'tertinggi','tip'=>'Liburan sekolah & wisatawan asing puncak. Sangat ramai.'],
                8  => ['weather'=>'cerah',  'crowd'=>'ramai',   'price'=>'tinggi', 'tip'=>'Masih cerah. Sedikit lebih sepi dari Juli.'],
                9  => ['weather'=>'cerah',  'crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Cuaca sempurna, mulai sepi. Waktu terbaik kedua.'],
                10 => ['weather'=>'berawan','crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Sekaten — pasar malam bersejarah di Alun-Alun Utara.'],
                11 => ['weather'=>'hujan',  'crowd'=>'sepi',    'price'=>'rendah', 'tip'=>'Awal hujan. Merapi sering tertutup awan.'],
                12 => ['weather'=>'hujan',  'crowd'=>'ramai',   'price'=>'tinggi', 'tip'=>'Natal & Tahun Baru ramai. Malioboro sangat padat.'],
            ],
        ],
        'jawa-timur' => [
            'best_months'   => [4,5,6,7,8,9],
            'avoid_months'  => [1,2],
            'festivals'     => [
                7  => ['Yadnya Kasada (Bromo)'],
                8  => ['Festival Reog Ponorogo'],
            ],
            'monthly' => [
                1  => ['weather'=>'hujan',  'crowd'=>'sepi',    'price'=>'rendah', 'tip'=>'Bromo berkabut tebal. Sunrise sering tidak terlihat.'],
                2  => ['weather'=>'hujan',  'crowd'=>'sepi',    'price'=>'rendah', 'tip'=>'Musim tersepi. Harga terbaik.'],
                3  => ['weather'=>'berawan','crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Mulai membaik untuk Bromo.'],
                4  => ['weather'=>'cerah',  'crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Cuaca mulai bagus. Bromo sunrise mulai jelas.'],
                5  => ['weather'=>'cerah',  'crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Musim kering dimulai. Ideal untuk Bromo dan Ijen.'],
                6  => ['weather'=>'cerah',  'crowd'=>'ramai',   'price'=>'tinggi', 'tip'=>'Kawah Ijen blue fire terbaik saat musim kering.'],
                7  => ['weather'=>'cerah',  'crowd'=>'sangat ramai','price'=>'tertinggi','tip'=>'Yadnya Kasada di Bromo — ritual lempar sesaji ke kawah.'],
                8  => ['weather'=>'cerah',  'crowd'=>'ramai',   'price'=>'tinggi', 'tip'=>'Festival Reog Ponorogo. Bromo sangat jelas.'],
                9  => ['weather'=>'cerah',  'crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Akhir musim kering. Masih sangat bagus.'],
                10 => ['weather'=>'berawan','crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Mulai berawan tapi masih bisa menikmati Bromo.'],
                11 => ['weather'=>'hujan',  'crowd'=>'sepi',    'price'=>'rendah', 'tip'=>'Awal hujan. Ijen dan Bromo kurang optimal.'],
                12 => ['weather'=>'hujan',  'crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Liburan Natal menaikkan kunjungan meski hujan.'],
            ],
        ],
        'default' => [
            'best_months'   => [5,6,7,8,9],
            'avoid_months'  => [1,2,12],
            'festivals'     => [],
            'monthly' => [
                1  => ['weather'=>'hujan',  'crowd'=>'sepi',    'price'=>'rendah', 'tip'=>'Musim hujan. Harga rendah, destinasi lebih sepi.'],
                2  => ['weather'=>'hujan',  'crowd'=>'sepi',    'price'=>'rendah', 'tip'=>'Puncak musim hujan di banyak daerah.'],
                3  => ['weather'=>'berawan','crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Mulai transisi ke musim kering.'],
                4  => ['weather'=>'cerah',  'crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Cuaca mulai membaik. Nyaman untuk wisata.'],
                5  => ['weather'=>'cerah',  'crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Musim kering dimulai. Waktu yang baik untuk berkunjung.'],
                6  => ['weather'=>'cerah',  'crowd'=>'ramai',   'price'=>'tinggi', 'tip'=>'Liburan sekolah mulai. Destinasi ramai.'],
                7  => ['weather'=>'cerah',  'crowd'=>'sangat ramai','price'=>'tertinggi','tip'=>'Puncak wisata. Pesan jauh-jauh hari.'],
                8  => ['weather'=>'cerah',  'crowd'=>'ramai',   'price'=>'tinggi', 'tip'=>'Masih musim puncak. Cuaca terbaik.'],
                9  => ['weather'=>'cerah',  'crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Mulai sepi, cuaca masih bagus. Waktu ideal.'],
                10 => ['weather'=>'berawan','crowd'=>'sedang',  'price'=>'sedang', 'tip'=>'Transisi ke musim hujan.'],
                11 => ['weather'=>'hujan',  'crowd'=>'sepi',    'price'=>'rendah', 'tip'=>'Awal musim hujan. Harga turun.'],
                12 => ['weather'=>'hujan',  'crowd'=>'sedang',  'price'=>'tinggi', 'tip'=>'Natal & Tahun Baru mendongkrak harga.'],
            ],
        ],
    ];

    public function index()
    {
        $provinces = Province::orderBy('name')->get();
        $currentMonth = (int) date('n');
        return view('seasonal-guide.index', compact('provinces', 'currentMonth'));
    }

    public function show(Request $request)
    {
        $request->validate(['province' => 'required|string']);
        $slug = $request->province;

        $province = Province::where('slug', $slug)->firstOrFail();
        $data = self::SEASONAL_DATA[$slug] ?? self::SEASONAL_DATA['default'];
        $currentMonth = (int) date('n');

        $months = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
        ];

        $provinces = Province::orderBy('name')->get();

        return view('seasonal-guide.show', compact(
            'province', 'data', 'currentMonth', 'months', 'provinces', 'slug'
        ));
    }
}