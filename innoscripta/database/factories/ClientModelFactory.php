<?php
namespace Database\Factories;

use App\Constants\ClientConstants;
use App\Models\ClientModel;
use App\Models\ProjectModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Class ClientModelFactory
 * @package Database\Factories
 */
class ClientModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientModel::class;

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

        $numberOfRedirectUrls = rand(1, 10);
        $redirectUrls = [];

        for ($i=0; $i<$numberOfRedirectUrls; $i++ ) {
            $redirectUrls[] = $this->faker->url;
        }

        return [
            'name' => $name = $this->faker->name,
            'slug' => Str::slug($name),
            'type' => ClientConstants::ALL_TYPES[array_rand(ClientConstants::ALL_TYPES)],
            'client_id' => Str::random(20),
            'client_secret' => Str::random(20),
            'is_active' => rand_boolean(),
            'project_id' => $project->id,
            'redirect_urls' => json_encode($redirectUrls),
        ];
    }

}
