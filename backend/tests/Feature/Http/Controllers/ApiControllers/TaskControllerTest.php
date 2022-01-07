<?php

namespace Tests\Feature\Http\Controllers\ApiControllers;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_task_controller_index_has_tasks()
    {
        $task = Task::factory()->create();

        $response = $this->getJson(route('tasks.index'));

        $response->assertStatus(200);

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('meta')
                    ->has('links')
                    ->has('data', 1)
                    ->has('data.0', fn ($json) =>
                        $json->where('id', $task->id)
                            ->where('title', $task->title)
                            ->where('description', $task->description)
                            ->etc()
                    )
            );
    }

    public function test_task_controller_store_creates_task()
    {
        $response = $this->postJson(route('tasks.store'), [
            'title' => $title = str_repeat('a', 10),
            'description' => $description = str_repeat('a', 10),
        ]);

        $response->assertStatus(201);

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('data', fn ($json) =>
                            $json->where('title', $title)
                            ->where('description', $description)
                            ->etc()
                    )
            );

        $this->assertDatabaseHas('tasks', [
            'title' => $title,
            'description' => $description,
        ]);
    }

    public function test_task_controller_title_is_required()
    {
        $response = $this->postJson(route('tasks.store'), [
            'description' => $description = str_repeat('a', 10),
        ]);

        $response->assertStatus(422);

        $response->assertInvalid('title');
    }

    public function test_task_controller_title_min_validation()
    {
        $response = $this->postJson(route('tasks.store'), [
            'title' => 'a',
        ]);

        $response->assertStatus(422);

        $response->assertInvalid('title');
    }

    public function test_task_controller_title_max_validation()
    {
        $response = $this->postJson(route('tasks.store'), [
            'title' => str_repeat('a', 600),
        ]);

        $response->assertStatus(422);

        $response->assertInvalid('title');
    }

    public function test_task_controller_description_max_validation()
    {
        $response = $this->postJson(route('tasks.store'), [
            'title' => str_repeat('a', 10),
            'description' => str_repeat('a', 1200),
        ]);

        $response->assertStatus(422);

        $response->assertInvalid('description');
    }

    public function test_task_controller_update_updates_task()
    {
        $task = Task::factory()->create();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => $original_title = $task->title,
            'description' => $original_description = $task->description,
        ]);

        $response = $this->patchJson(route('tasks.update', ['task_id' => $task->id]), [
            'title' => $updated_title = str_repeat('a', 10),
            'description' => $updated_description = str_repeat('a', 10),
        ]);

        $response->assertStatus(200);

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('data', fn ($json) =>
                            $json->where('title', $updated_title)
                            ->where('description', $updated_description)
                            ->etc()
                    )
            );

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
            'title' => $original_title,
            'description' => $original_description,
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => $updated_title,
            'description' => $updated_description,
        ]);
    }

    public function test_task_controller_destroy_deletes_task()
    {
        $task = Task::factory()->create();

        $this->assertDatabaseHas('tasks', [
            'id' => $original_id = $task->id,
            'title' => $original_title = $task->title,
            'description' => $original_description = $task->description,
        ]);

        $response = $this->deleteJson(route('tasks.destroy', ['task_id' => $task->id]));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', [
            'id' => $original_id,
            'title' => $original_title,
            'description' => $original_description,
        ]);
    }
}
