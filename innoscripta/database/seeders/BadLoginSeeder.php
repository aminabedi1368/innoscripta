<?php
namespace Database\Seeders;

use App\Models\BadLoginModel;
use Illuminate\Database\Seeder;

/**
 * Class BadLoginSeeder
 * @package Database\Seeders
 */
class BadLoginSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        BadLoginModel::factory()->times(1000)->create();
    }

}
