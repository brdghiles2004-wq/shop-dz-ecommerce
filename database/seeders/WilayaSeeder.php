<?php
namespace Database\Seeders;

use App\Models\Wilaya;
use Illuminate\Database\Seeder;

class WilayaSeeder extends Seeder
{
    public function run(): void
    {
        $wilayas = [
            ['name' => 'Adrar',                 'stopdesk_price' => 800,  'home_price' => 1000],
            ['name' => 'Chlef',                 'stopdesk_price' => 400,  'home_price' => 550],
            ['name' => 'Laghouat',              'stopdesk_price' => 500,  'home_price' => 650],
            ['name' => 'Oum El Bouaghi',        'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Batna',                 'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Béjaïa',               'stopdesk_price' => 400,  'home_price' => 550],
            ['name' => 'Biskra',                'stopdesk_price' => 500,  'home_price' => 650],
            ['name' => 'Béchar',               'stopdesk_price' => 800,  'home_price' => 1000],
            ['name' => 'Blida',                 'stopdesk_price' => 300,  'home_price' => 450],
            ['name' => 'Bouira',                'stopdesk_price' => 350,  'home_price' => 500],
            ['name' => 'Tamanrasset',           'stopdesk_price' => 1000, 'home_price' => 1200],
            ['name' => 'Tébessa',              'stopdesk_price' => 500,  'home_price' => 650],
            ['name' => 'Tlemcen',               'stopdesk_price' => 500,  'home_price' => 650],
            ['name' => 'Tiaret',                'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Tizi Ouzou',            'stopdesk_price' => 350,  'home_price' => 500],
            ['name' => 'Alger',                 'stopdesk_price' => 200,  'home_price' => 350],
            ['name' => 'Djelfa',                'stopdesk_price' => 500,  'home_price' => 650],
            ['name' => 'Jijel',                 'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Sétif',                'stopdesk_price' => 400,  'home_price' => 550],
            ['name' => 'Saïda',                'stopdesk_price' => 500,  'home_price' => 650],
            ['name' => 'Skikda',                'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Sidi Bel Abbès',       'stopdesk_price' => 500,  'home_price' => 650],
            ['name' => 'Annaba',                'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Guelma',                'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Constantine',           'stopdesk_price' => 400,  'home_price' => 550],
            ['name' => 'Médéa',                'stopdesk_price' => 350,  'home_price' => 500],
            ['name' => 'Mostaganem',            'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'M\'Sila',              'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Mascara',               'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Ouargla',               'stopdesk_price' => 700,  'home_price' => 850],
            ['name' => 'Oran',                  'stopdesk_price' => 400,  'home_price' => 550],
            ['name' => 'El Bayadh',             'stopdesk_price' => 700,  'home_price' => 850],
            ['name' => 'Illizi',                'stopdesk_price' => 1000, 'home_price' => 1200],
            ['name' => 'Bordj Bou Arréridj',   'stopdesk_price' => 400,  'home_price' => 550],
            ['name' => 'Boumerdès',            'stopdesk_price' => 300,  'home_price' => 450],
            ['name' => 'El Tarf',               'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Tindouf',               'stopdesk_price' => 1000, 'home_price' => 1200],
            ['name' => 'Tissemsilt',            'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'El Oued',               'stopdesk_price' => 600,  'home_price' => 750],
            ['name' => 'Khenchela',             'stopdesk_price' => 500,  'home_price' => 650],
            ['name' => 'Souk Ahras',            'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Tipaza',                'stopdesk_price' => 300,  'home_price' => 450],
            ['name' => 'Mila',                  'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Aïn Defla',            'stopdesk_price' => 400,  'home_price' => 550],
            ['name' => 'Naâma',                'stopdesk_price' => 700,  'home_price' => 850],
            ['name' => 'Aïn Témouchent',       'stopdesk_price' => 500,  'home_price' => 650],
            ['name' => 'Ghardaïa',             'stopdesk_price' => 700,  'home_price' => 850],
            ['name' => 'Relizane',              'stopdesk_price' => 450,  'home_price' => 600],
            ['name' => 'Timimoun',              'stopdesk_price' => 900,  'home_price' => 1100],
            ['name' => 'Bordj Badji Mokhtar',   'stopdesk_price' => 1000, 'home_price' => 1200],
            ['name' => 'Ouled Djellal',         'stopdesk_price' => 600,  'home_price' => 750],
            ['name' => 'Béni Abbès',           'stopdesk_price' => 900,  'home_price' => 1100],
            ['name' => 'In Salah',              'stopdesk_price' => 1000, 'home_price' => 1200],
            ['name' => 'In Guezzam',            'stopdesk_price' => 1000, 'home_price' => 1200],
            ['name' => 'Touggourt',             'stopdesk_price' => 650,  'home_price' => 800],
            ['name' => 'Djanet',                'stopdesk_price' => 1000, 'home_price' => 1200],
            ['name' => 'M\'Ghair',             'stopdesk_price' => 650,  'home_price' => 800],
            ['name' => 'El Meniaa',             'stopdesk_price' => 800,  'home_price' => 1000],
        ];

        Wilaya::truncate();
        foreach ($wilayas as $w) {
            Wilaya::create($w);
        }
    }
}