<?php
namespace Database\Seeders;

use App\Models\RoleModel;
use Illuminate\Database\Seeder;

/**
 * Class RoleSeeder
 * @package Database\Seeders
 */
class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        RoleModel::factory()->times(35)->create();
    }

}
