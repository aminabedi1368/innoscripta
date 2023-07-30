<?php
namespace Database\Seeders;

use App\Models\ScopeModel;
use Illuminate\Database\Seeder;

/**
 * Class ScopeSeeder
 * @package Database\Seeders
 */
class ScopeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ScopeModel::factory()->times(200)->create();
    }

}
