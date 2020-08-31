<?php

use Illuminate\Database\Seeder;

class MyProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('provinces')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'country_id' => 169,
                    'name' => 'Abra',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            1 =>
                array (
                    'id' => 2,
                    'country_id' => 169,
                    'name' => 'Agusan del Norte',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            2 =>
                array (
                    'id' => 3,
                    'country_id' => 169,
                    'name' => 'Agusan del Sur',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            3 =>
                array (
                    'id' => 4,
                    'country_id' => 169,
                    'name' => 'Aklan',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            4 =>
                array (
                    'id' => 5,
                    'country_id' => 169,
                    'name' => 'Albay',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            5 =>
                array (
                    'id' => 6,
                    'country_id' => 169,
                    'name' => 'Antique',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            6 =>
                array (
                    'id' => 7,
                    'country_id' => 169,
                    'name' => 'Apayao',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            7 =>
                array (
                    'id' => 8,
                    'country_id' => 169,
                    'name' => 'Aurora',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            8 =>
                array (
                    'id' => 9,
                    'country_id' => 169,
                    'name' => 'Basilan',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            9 =>
                array (
                    'id' => 10,
                    'country_id' => 169,
                    'name' => 'Bataan',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            10 =>
                array (
                    'id' => 11,
                    'country_id' => 169,
                    'name' => 'Batanes',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            11 =>
                array (
                    'id' => 12,
                    'country_id' => 169,
                    'name' => 'Batangas',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            12 =>
                array (
                    'id' => 13,
                    'country_id' => 169,
                    'name' => 'Benguet',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            13 =>
                array (
                    'id' => 14,
                    'country_id' => 169,
                    'name' => 'Biliran',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            14 =>
                array (
                    'id' => 15,
                    'country_id' => 169,
                    'name' => 'Bohol',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            15 =>
                array (
                    'id' => 16,
                    'country_id' => 169,
                    'name' => 'Bukidnon',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            16 =>
                array (
                    'id' => 17,
                    'country_id' => 169,
                    'name' => 'Bulacan',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            17 =>
                array (
                    'id' => 18,
                    'country_id' => 169,
                    'name' => 'Cagayan',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            18 =>
                array (
                    'id' => 19,
                    'country_id' => 169,
                    'name' => 'Camarines Norte',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            19 =>
                array (
                    'id' => 20,
                    'country_id' => 169,
                    'name' => 'Camarines Sur',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            20 =>
                array (
                    'id' => 21,
                    'country_id' => 169,
                    'name' => 'Camiguin',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            21 =>
                array (
                    'id' => 22,
                    'country_id' => 169,
                    'name' => 'Capiz',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            22 =>
                array (
                    'id' => 23,
                    'country_id' => 169,
                    'name' => 'Catanduanes',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            23 =>
                array (
                    'id' => 24,
                    'country_id' => 169,
                    'name' => 'Cavite',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            24 =>
                array (
                    'id' => 25,
                    'country_id' => 169,
                    'name' => 'Cebu',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            25 =>
                array (
                    'id' => 26,
                    'country_id' => 169,
                    'name' => 'Compostela Valley',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            26 =>
                array (
                    'id' => 27,
                    'country_id' => 169,
                    'name' => 'Cotabato',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            27 =>
                array (
                    'id' => 28,
                    'country_id' => 169,
                    'name' => 'Davao del Norte',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            28 =>
                array (
                    'id' => 29,
                    'country_id' => 169,
                    'name' => 'Davao del Sur',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            29 =>
                array (
                    'id' => 30,
                    'country_id' => 169,
                    'name' => 'Davao Oriental',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            30 =>
                array (
                    'id' => 31,
                    'country_id' => 169,
                    'name' => 'Eastern Samar',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            31 =>
                array (
                    'id' => 32,
                    'country_id' => 169,
                    'name' => 'Guimaras',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            32 =>
                array (
                    'id' => 33,
                    'country_id' => 169,
                    'name' => 'Ifugao',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            33 =>
                array (
                    'id' => 34,
                    'country_id' => 169,
                    'name' => 'Ilocos Norte',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            34 =>
                array (
                    'id' => 35,
                    'country_id' => 169,
                    'name' => 'Ilocos Sur',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            35 =>
                array (
                    'id' => 36,
                    'country_id' => 169,
                    'name' => 'Iloilo',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            36 =>
                array (
                    'id' => 37,
                    'country_id' => 169,
                    'name' => 'Isabela',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            37 =>
                array (
                    'id' => 38,
                    'country_id' => 169,
                    'name' => 'Kalinga',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            38 =>
                array (
                    'id' => 39,
                    'country_id' => 169,
                    'name' => 'La Union',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            39 =>
                array (
                    'id' => 40,
                    'country_id' => 169,
                    'name' => 'Laguna',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            40 =>
                array (
                    'id' => 41,
                    'country_id' => 169,
                    'name' => 'Lanao del Norte',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            41 =>
                array (
                    'id' => 42,
                    'country_id' => 169,
                    'name' => 'Lanao del Sur',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            42 =>
                array (
                    'id' => 43,
                    'country_id' => 169,
                    'name' => 'Leyte',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            43 =>
                array (
                    'id' => 44,
                    'country_id' => 169,
                    'name' => 'Maguindanao',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            44 =>
                array (
                    'id' => 45,
                    'country_id' => 169,
                    'name' => 'Marinduque',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            45 =>
                array (
                    'id' => 46,
                    'country_id' => 169,
                    'name' => 'Masbate',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            46 =>
                array (
                    'id' => 47,
                    'country_id' => 169,
                    'name' => 'Metro Manila',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            47 =>
                array (
                    'id' => 48,
                    'country_id' => 169,
                    'name' => 'Misamis Occidental',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            48 =>
                array (
                    'id' => 49,
                    'country_id' => 169,
                    'name' => 'Misamis Oriental',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            49 =>
                array (
                    'id' => 50,
                    'country_id' => 169,
                    'name' => 'Mountain Province',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            50 =>
                array (
                    'id' => 51,
                    'country_id' => 169,
                    'name' => 'Negros Occidental',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            51 =>
                array (
                    'id' => 52,
                    'country_id' => 169,
                    'name' => 'Negros Oriental',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            52 =>
                array (
                    'id' => 53,
                    'country_id' => 169,
                    'name' => 'Northern Samar',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            53 =>
                array (
                    'id' => 54,
                    'country_id' => 169,
                    'name' => 'Nueva Ecija',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            54 =>
                array (
                    'id' => 55,
                    'country_id' => 169,
                    'name' => 'Nueva Vizcaya',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            55 =>
                array (
                    'id' => 56,
                    'country_id' => 169,
                    'name' => 'Occidental Mindoro',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            56 =>
                array (
                    'id' => 57,
                    'country_id' => 169,
                    'name' => 'Oriental Mindoro',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            57 =>
                array (
                    'id' => 58,
                    'country_id' => 169,
                    'name' => 'Palawan',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            58 =>
                array (
                    'id' => 59,
                    'country_id' => 169,
                    'name' => 'Pampanga',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            59 =>
                array (
                    'id' => 60,
                    'country_id' => 169,
                    'name' => 'Pangasinan',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            60 =>
                array (
                    'id' => 61,
                    'country_id' => 169,
                    'name' => 'Quezon',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            61 =>
                array (
                    'id' => 62,
                    'country_id' => 169,
                    'name' => 'Quirino',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            62 =>
                array (
                    'id' => 63,
                    'country_id' => 169,
                    'name' => 'Rizal',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            63 =>
                array (
                    'id' => 64,
                    'country_id' => 169,
                    'name' => 'Romblon',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            64 =>
                array (
                    'id' => 65,
                    'country_id' => 169,
                    'name' => 'Samar',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            65 =>
                array (
                    'id' => 66,
                    'country_id' => 169,
                    'name' => 'Sarangani',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            66 =>
                array (
                    'id' => 67,
                    'country_id' => 169,
                    'name' => 'Siquijor',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            67 =>
                array (
                    'id' => 68,
                    'country_id' => 169,
                    'name' => 'Sorsogon',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            68 =>
                array (
                    'id' => 69,
                    'country_id' => 169,
                    'name' => 'South Cotabato',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            69 =>
                array (
                    'id' => 70,
                    'country_id' => 169,
                    'name' => 'Southern Leyte',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            70 =>
                array (
                    'id' => 71,
                    'country_id' => 169,
                    'name' => 'Sultan Kudarat',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            71 =>
                array (
                    'id' => 72,
                    'country_id' => 169,
                    'name' => 'Sulu',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            72 =>
                array (
                    'id' => 73,
                    'country_id' => 169,
                    'name' => 'Surigao del Norte',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            73 =>
                array (
                    'id' => 74,
                    'country_id' => 169,
                    'name' => 'Surigao del Sur',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            74 =>
                array (
                    'id' => 75,
                    'country_id' => 169,
                    'name' => 'Tarlac',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            75 =>
                array (
                    'id' => 76,
                    'country_id' => 169,
                    'name' => 'Tawi-Tawi',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            76 =>
                array (
                    'id' => 77,
                    'country_id' => 169,
                    'name' => 'Zambales',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            77 =>
                array (
                    'id' => 78,
                    'country_id' => 169,
                    'name' => 'Zamboanga del Norte',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            78 =>
                array (
                    'id' => 79,
                    'country_id' => 169,
                    'name' => 'Zamboanga del Sur',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
            79 =>
                array (
                    'id' => 80,
                    'country_id' => 169,
                    'name' => 'Zamboanga Sibugay',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                ),
        ));
    }
}
