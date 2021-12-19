<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Campaign;
use App\Models\Voucher;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campaign = Campaign::factory()
            ->has(Voucher::factory()->count(1000), 'vouchers')
            ->create([
                'name' => 'Anniversary Celebration'
            ]);
    }
}
