<?php

namespace Database\Seeders;

use App\Models\Operation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class OperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operation::insert([
            [
                'cle' => Str::slug('dépôt de caisse'),
                'valeur' => 'dépôt de caisse',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'cle' => Str::slug('remise en banque'),
                'valeur' => 'remise en banque',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'cle' => Str::slug('retrait'),
                'valeur' => 'retrait',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
