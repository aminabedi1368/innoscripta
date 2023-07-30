<?php
namespace Database\Factories;

use App\Constants\UserIdentifierType;
use App\Models\UserIdentifierModel;
use App\Models\UserModel;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class UserIdentifierModelFactory
 * @package Database\Factories
 */
class UserIdentifierModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserIdentifierModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition()
    {
        $user_count = UserModel::query()->where('is_super_admin', false)->count();

        if($user_count > 0) {
            /** @var UserModel $user */
            $user = UserModel::query()->where('is_super_admin', false)->inRandomOrder()->firstOrFail();
        }
        else {
            /** @var UserModel $user */
            $user = UserModel::factory()->create();
        }

        $identifierType = UserIdentifierType::ALL_TYPES[array_rand(UserIdentifierType::ALL_TYPES)];

        if($identifierType === UserIdentifierType::MOBILE) {
            $phone_prefix = ['0912', '0910', '0913', '0935', '0939', '0901', '0922', '0911'];
            $username = $phone_prefix[array_rand($phone_prefix)]. random_int(1000000, 9999999);
        }
        else {
            $username = $this->faker->email;
        }


        return [
            'type' => $identifierType,
            'value' => $username,
            'user_id' => $user->id,
            'is_verified' => rand_boolean()
        ];

    }

}
