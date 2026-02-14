<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;
use App\Models\Sport;
use Illuminate\Support\Facades\DB;

class VenueSportSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Ambil Default User (Admin) untuk 'created_by'
        $admin = \App\Models\User::first();
        if (!$admin) {
            $admin = \App\Models\User::create([
                'name' => 'System Admin',
                'email' => 'admin_seeder@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]);
        }
        $adminId = $admin->id;

        // 1. Ambil Referensi Sport ID (Pastikan Sport sudah ada di DatabaseSeeder)
        $futsal = Sport::firstOrCreate(['name' => 'Futsal'], ['created_by' => $adminId]);
        // Handle alias or alternative names if needed, but for seeding simplicity let's stick to unique names
        // If "Sepak Bola" is desired as a separate sport but mapped similarly:
        $soccer = Sport::firstOrCreate(['name' => 'Sepak Bola'], ['created_by' => $adminId]);

        $basket = Sport::firstOrCreate(['name' => 'Basketball'], ['created_by' => $adminId]);
        $badminton = Sport::firstOrCreate(['name' => 'Badminton'], ['created_by' => $adminId]);
        $voli = Sport::firstOrCreate(['name' => 'Volleyball'], ['created_by' => $adminId]);
        $hoki = Sport::firstOrCreate(['name' => 'Hockey'], ['created_by' => $adminId]);
        $tennis = Sport::firstOrCreate(['name' => 'Tennis'], ['created_by' => $adminId]);

        // 2. Definisi Kategori Venue berdasarkan Nama (Keyword Mapping)
        // Format: [SportObject => ['Keyword1', 'Keyword2']]
        $sharedSoccerKeywords = [
            'Stadion',
            'Futsal',
            'Soccer',
            'Bola',
            'Siliwangi',
            'GBLA',
            'Sidolig',
            'Gelora',
            'PTIK',
            'Pakansari',
            'Patriot',
            'Wibawa Mukti',
            'Jatidiri',
            'Manahan',
            'Maguwoharjo',
            'Sultan Agung',
            'Surajaya',
            'Queen',
            'Progresif',
            'Scudetto',
            'Muara',
            'Tubagus',
            'Zone 73',
            'Muhibbin',
            'Vidi',
            'TIBI',
            'Orion',
            'Venom',
            'Golden Stick',
            'Andik',
            'Pamularsih',
            'Planet',
            'Jogja Futsal',
            'Bardosono',
            'Ole',
            'Gool',
            'Champions',
            'Saparua',
            'Pajajaran',
            'C-Tra',
            'Lodaya',
            'Batununggal',
            'Cikutra',
            'Soemantri',
            'Bulungan',
            'Ciracas',
            'Otista',
            'Grogol',
            'Dimyati',
            'Tri Lomba',
            'Satria',
            'UNY',
            'Among Rogo',
            'Klebengan',
            'Delta',
            'Jayabaya',
            'Cempaka Putih',
            'Kertajaya',
            'Ken Arok',
            'Indomilk',
            'Bintaro' // Tambahan
        ];

        $mappings = [
            $futsal->id => $sharedSoccerKeywords,
            $soccer->id => $sharedSoccerKeywords,
            $basket->id => [
                'Britama',
                'DBL',
                'Sritex',
                'C-Tra',
                'El Cavana',
                'Saparua',
                'Soemantri',
                'Arcamanik',
                'Cilandak',
                'Arcici',
                'Gor',
                'Hall',
                'Arena' // Asumsi GOR Serbaguna punya basket
            ],
            $badminton->id => [
                'Istora',
                'Sabuga',
                'Graha Manggala',
                'Saparua',
                'Bulungan',
                'Among Rogo',
                'Pajajaran',
                'Lodaya',
                'Batununggal',
                'Cikutra',
                'Soemantri',
                'Ciracas',
                'Otista',
                'Grogol',
                'Dimyati',
                'Padjajaran',
                'Tri Lomba',
                'Satria',
                'UNY',
                'Klebengan',
                'Delta',
                'Jayabaya',
                'Cempaka Putih',
                'Kertajaya',
                'Ken Arok',
                'Bikasoga',
                'Sampoerna',
                'Pasaga' // Tambahan umum Bandung
            ],
            $voli->id => [
                'Saparua',
                'Bulungan',
                'Among Rogo',
                'Arcamanik',
                'Banteng',
                'Pajajaran',
                'C-Tra',
                'Lodaya',
                'Batununggal',
                'Soemantri',
                'Ciracas',
                'Otista',
                'Grogol',
                'Dimyati',
                'Padjajaran',
                'Tri Lomba',
                'Satria',
                'UNY',
                'Klebengan',
                'Delta',
                'Jayabaya',
                'Cempaka Putih',
                'Kertajaya',
                'Ken Arok'
            ],
            $hoki->id => ['Golden Stick'],
            $tennis->id => ['Tennis', 'Springs', 'Cilandak', 'Siliwangi', 'Pujasera', 'Bikasoga', 'Saparua']
        ];

        // 3. Loop Semua Venue dan Attach Sport
        $allVenues = Venue::all();

        foreach ($allVenues as $venue) {
            $venueName = $venue->name;
            $attachedSports = [];

            foreach ($mappings as $sportId => $keywords) {
                foreach ($keywords as $keyword) {
                    // Cek jika nama venue mengandung keyword (Case Insensitive)
                    if (stripos($venueName, $keyword) !== false) {
                        $attachedSports[] = $sportId;
                        break; // Masuk kategori ini, lanjut ke sport berikutnya
                    }
                }
            }

            // Sync memastikan tidak ada duplikat per venue
            if (!empty($attachedSports)) {
                $venue->sports()->syncWithoutDetaching($attachedSports);
            }
        }

        $this->command->info('Venue Sport Association Completed!');
    }
}
