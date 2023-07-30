<?php
namespace Database\Factories;

use App\Models\ProjectModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Class RoleModelFactory
 * @package Database\Factories
 */
class RoleModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoleModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $projects_count = ProjectModel::query()->count();

        if($projects_count > 0) {
            /** @var ProjectModel $project */
            $project = ProjectModel::query()->inRandomOrder()->firstOrFail();
        }
        else {
            /** @var ProjectModel $project */
            $project = ProjectModel::factory()->create();
        }

        return [
            'name' => $name = $this->faker->name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text,
            'project_id' => $project->id
        ];
    }

}
