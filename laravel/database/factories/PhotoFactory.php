<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\User;
use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    protected $model = Photo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $id = (string)Uuid::uuid4();
        return [
            'id' => $id,
            'user_id' => fn() => User::factory()->create()->id,
            'filename' => $id . '.jpg',
            'created_at' => DateTime::dateTimeThisDecade(),
            'updated_at' => DateTime::dateTimeThisDecade(),
        ];
    }
}
