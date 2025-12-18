<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Forklift;

class ForkliftSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kode_forklift' => 'FL-001',
                'merk'          => 'Toyota',
                'tipe'          => '8FD30'
            ],
            [
                'kode_forklift' => 'FL-002',
                'merk'          => 'Mitsubishi',
                'tipe'          => 'FD30N'
            ],
            [
                'kode_forklift' => 'FL-003',
                'merk'          => 'Komatsu',
                'tipe'          => 'FD25T'
            ],
            [
                'kode_forklift' => 'FL-004',
                'merk'          => 'Nissan',
                'tipe'          => 'DX30'
            ],
            [
                'kode_forklift' => 'FL-005',
                'merk'          => 'TCM',
                'tipe'          => 'FD30Z'
            ],
        ];

        foreach ($data as $item) {
            Forklift::updateOrCreate(
                ['kode_forklift' => $item['kode_forklift']],
                $item
            );
        }
    }
}
