<?php
namespace Database\Seeders;

use App\Models\ClientModel;
use Illuminate\Database\Seeder;

/**
 * Class ClientSeeder
 * @package Database\Seeders
 */
class ClientSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ClientModel::factory()->times(3)->create();
    }

}
