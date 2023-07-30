<?php
namespace Database\Factories;

use App\Models\BadLoginModel;
use App\Models\UserIdentifierModel;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class BadLoginModelFactory
 * @package Database\Factories
 */
class BadLoginModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BadLoginModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition()
    {
        $loginTypes = ['password', 'otp'];
        $deviceOs = ['mac', 'windows', 'ios', 'android', 'linux'];
        $deviceType = ['desktop', 'mobile'];
        $identifierType = ['email', 'mobile'];

        $user_identifier_id_options = [null, "identifier"];

        if(is_null($user_identifier_id_options[array_rand($user_identifier_id_options)])) {
            $identifier = $identifierType[array_rand($identifierType)];
            if($identifier === 'email') {
                $username = $this->faker->email;
            }
            else {
                $phone_prefix = ['0912', '0910', '0913', '0935', '0939', '0901', '0922', '0911'];
                $username = $phone_prefix[array_rand($phone_prefix)]. random_int(1000000, 9999999);
            }
            $userIdentifier_id = null;
        }
        else {
            /** @var UserIdentifierModel $userIdentifier */
            $userIdentifier = UserIdentifierModel::query()->inRandomOrder()->first();
            $username = $userIdentifier->value;
            $userIdentifier_id = $userIdentifier->id;
        }

        return [
            'device_type' => $deviceType[array_rand($deviceType)],
            'device_os' => $deviceOs[array_rand($deviceOs)],
            'login_type' => $loginTypes[array_rand($loginTypes)],
            'username' => $username,
            'user_identifier_id' => $userIdentifier_id,
            'password' => $this->faker->password,
            'ip' => $this->faker->ipv4
        ];
    }

}
