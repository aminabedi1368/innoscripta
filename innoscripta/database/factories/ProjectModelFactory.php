<?php
namespace Database\Factories;

use App\Models\ProjectModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Class ProjectFactory
 * @package Database\Factories
 */
class ProjectModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /** @var UserModel $rootUser */
        $rootUser = UserModel::query()
            ->where('app_fields->username', 'root')
            ->firstOrFail();

        return [
            'name' => $name = $this->faker->name,
            'slug' => Str::slug($name),
            'project_id' => Str::random(20),
            'description' => $this->faker->text,
            'creator_user_id' => $rootUser->id,
            'is_first_party' => rand_boolean(),
        ];
    }

}
