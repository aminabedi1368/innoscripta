<?php
namespace Database\Seeders;

use App\Models\UserIdentifierModel;
use Illuminate\Database\Seeder;

/**
 * Class UserIdentifierSeeder
 * @package Database\Seeders
 */
class UserIdentifierSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        UserIdentifierModel::factory()->times(1000)->create();
    }

}
