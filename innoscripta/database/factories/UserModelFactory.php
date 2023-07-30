<?php
namespace Database\Factories;

use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserModelFactory
 * @package Database\Factories
 */
class UserModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserModel::class;

    const DEFAULT_PASSWORD = '123456';

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = ['active', 'locked'];
        $appFields = [
            'app_id' => rand(1000, 9999),
            'national_id' => '00'.rand(11297800, 18297800),
            'sid' => randomString(3). rand(4578, 57893). randomString(2)
        ];

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'is_super_admin' => false,
            'status' => $status[array_rand($status)],
            'avatar' => null,
            'app_fields' => $appFields,
            'password' => Hash::make(self::DEFAULT_PASSWORD)
        ];
    }

}
