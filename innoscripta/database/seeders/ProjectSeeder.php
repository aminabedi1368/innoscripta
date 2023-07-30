<?php
namespace Database\Seeders;

use App\Models\ProjectModel;
use Illuminate\Database\Seeder;

/**
 * Class ProjectSeeder
 * @package Database\Seeders
 */
class ProjectSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ProjectModel::factory()->times(1)->create();
    }

}
