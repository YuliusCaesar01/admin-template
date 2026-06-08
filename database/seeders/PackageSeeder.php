<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {

        $packages = [

            // ══════════════════════════════════════════════
            // CAT-001 — Plastic Testing
            // ══════════════════════════════════════════════

            [
                'category_id'     => 'CAT-001',
                'name'            => 'Charpy Impact Test',
                'description'     => 'Pengujian ketangguhan impak metode Charpy (notched) untuk menentukan energi serap material sesuai ISO 179 / ASTM E23.',
                'base_price'      => 300000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'Flexural Test - 3 Point Bending',
                'description'     => 'Pengujian flexural strength dan flexural modulus metode 3-point bending sesuai ISO 178 / ASTM D790.',
                'base_price'      => 300000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'Hardness Test',
                'description'     => 'Pengujian kekerasan material plastik dan logam menggunakan metode Rockwell, Brinell, atau Shore sesuai standar ASTM.',
                'base_price'      => 150000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'Heat Deflection Temp.',
                'description'     => 'Pengujian suhu defleksi panas (HDT) pada material plastik untuk mengetahui batas temperatur kerja sesuai ISO 75 / ASTM D648.',
                'base_price'      => 350000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'Izod Impact Test',
                'description'     => 'Pengujian ketangguhan impak metode Izod pada spesimen plastik dan polimer sesuai ISO 180 / ASTM D256.',
                'base_price'      => 250000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'Melt Flow Index',
                'description'     => 'Pengujian Melt Flow Index (MFI) untuk mengukur kemampuan alir material termoplastik dalam kondisi leleh sesuai ISO 1133 / ASTM D1238.',
                'base_price'      => 275000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'SEM',
                'description'     => 'Analisis morfologi permukaan material menggunakan Scanning Electron Microscopy (SEM) untuk evaluasi struktur mikro.',
                'base_price'      => 750000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'Tensile Test',
                'description'     => 'Pengujian tensile strength, yield strength, dan elongation at break pada spesimen plastik sesuai standar ISO 527 / ASTM D638.',
                'base_price'      => 275000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'Vicat Softening Temp.',
                'description'     => 'Pengujian suhu pelunakan Vicat pada material termoplastik untuk menentukan stabilitas termal sesuai ISO 306 / ASTM D1525.',
                'base_price'      => 325000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'Compression Test',
                'description'     => 'Pengujian kuat tekan pada material plastik dan komposit sesuai ISO 604 / ASTM D695.',
                'base_price'      => 300000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'Density Test',
                'description'     => 'Pengujian densitas dan berat jenis material plastik menggunakan metode Archimedes sesuai ISO 1183 / ASTM D792.',
                'base_price'      => 200000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'XRF',
                'description'     => 'Analisis komposisi unsur material menggunakan X-Ray Fluorescence (XRF) untuk identifikasi elemen dan kandungan logam berat.',
                'base_price'      => 500000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'SEM-EDX',
                'description'     => 'Analisis morfologi permukaan sekaligus komposisi unsur menggunakan SEM dilengkapi Energy Dispersive X-Ray (EDX).',
                'base_price'      => 950000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'Flexural Test - 4 Point Bending',
                'description'     => 'Pengujian flexural strength metode 4-point bending untuk distribusi momen yang lebih merata sesuai ISO 14125 / ASTM D6272.',
                'base_price'      => 325000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-001',
                'name'            => 'Notching Impact Test',
                'description'     => 'Pembuatan notch (takikan) pada spesimen impak sesuai dimensi standar ISO 179 / ISO 180 sebelum pengujian Charpy atau Izod.',
                'base_price'      => 100000,
                'is_active'       => true,
            ],

            // ══════════════════════════════════════════════
            // CAT-002 — Product Development
            // ══════════════════════════════════════════════

            [
                'category_id'     => 'CAT-002',
                'name'            => 'Analysis Mold Flow',
                'description'     => 'Analisis simulasi aliran material dalam cetakan untuk optimasi desain produk dan parameter proses injeksi.',
                'base_price'      => 1500000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-002',
                'name'            => 'Design & Development Product',
                'description'     => 'Layanan desain dan pengembangan produk plastik dari konsep hingga prototipe, termasuk gambar teknis dan pemilihan material.',
                'base_price'      => 2500000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-002',
                'name'            => 'Laser Cutting',
                'description'     => 'Pemotongan presisi menggunakan laser untuk material plastik, akrilik, dan komposit tipis sesuai gambar teknis.',
                'base_price'      => 500000,
                'is_active'       => true,
            ],

            // ══════════════════════════════════════════════
            // CAT-003 — Plastic Processing
            // ══════════════════════════════════════════════

            [
                'category_id'     => 'CAT-003',
                'name'            => 'Extrusion',
                'description'     => 'Layanan proses ekstrusi plastik untuk menghasilkan profil, pipa, sheet, atau filamen sesuai spesifikasi. Material PE, PP, PVC, dan ABS tersedia.',
                'base_price'      => 1200000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-003',
                'name'            => 'Injection',
                'description'     => 'Layanan proses injeksi molding untuk pembuatan komponen plastik presisi dengan berbagai material termoplastik.',
                'base_price'      => 1500000,
                'is_active'       => true,
            ],
            [
                'category_id'     => 'CAT-003',
                'name'            => 'Vacuum Forming',
                'description'     => 'Layanan thermoforming vakum untuk pembuatan produk plastik tipis seperti tray, packaging, dan panel. Material HIPS, PET, ABS, dan PP tersedia.',
                'base_price'      => 1000000,
                'is_active'       => true,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::create($pkg);
        }
    }
}