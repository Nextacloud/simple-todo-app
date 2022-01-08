<?php

namespace Tests\Feature\Services;

use App\Http\Dtos\Task\TaskDto;
use App\Models\Task;
use App\Services\TaskServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    protected $task_service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->task_service = $this->app->make(TaskServiceInterface::class);
    }

    public function test_get_paginated_tasks_returns_paginator_instance()
    {
        $paginator = $this->task_service->paginate();

        $this->assertInstanceOf(Paginator::class, $paginator);
    }

    public function test_paginated_tasks_should_return_tasks()
    {
        $task = Task::factory()->create();

        $paginator = $this->task_service->paginate();

        $first_task = $paginator->items()[0];

        $this->assertEquals($task->title, $first_task->title);
    }

    public function test_paginated_completed_tasks_should_return_completed_tasks()
    {
        Task::factory(5)->completed()->create();

        Task::factory(5)->incompleted()->create();

        $paginator = $this->task_service->paginate('completed');

        // To ensure all tasks returned are completed
        foreach ($paginator->items() as $task) {
            $this->assertTrue($task->is_completed);

            $this->assertNotTrue(!$task->is_completed);
        }

    }

    public function test_paginated_incompleted_tasks_should_return_incompleted_tasks()
    {
        Task::factory(5)->completed()->create();

        Task::factory(5)->incompleted()->create();

        $paginator = $this->task_service->paginate('incompleted');

        // To ensure all tasks returned are incompleted
        foreach ($paginator->items() as $task) {
            $this->assertTrue(!$task->is_completed);

            $this->assertNotTrue($task->is_completed);
        }
    }

    public function test_get_task_should_return_task()
    {
        $task = Task::factory()->create();

        $get_task = $this->task_service->get($task->id);

        $this->assertEquals($get_task->title, $task->title);
    }

    public function test_can_create_task()
    {
        $dto = new TaskDto(
            title: $this->faker->sentence(10),
            description: $this->faker->sentence(50),
        );

        /** @var Task $task */
        $task = $this->task_service->create($dto);

        $this->assertEquals($task->title, $dto->getTitle());
        $this->assertEquals($task->description, $dto->getDescription());

        $this->assertDatabaseHas('tasks', [
            'title' => $dto->getTitle(),
            'description' => $dto->getDescription(),
        ]);
    }

    public function test_can_update_task()
    {
        $original_task = Task::factory()->create([
            'title' => $original_title = $this->faker->sentence(10),
            'description' => $original_description = $this->faker->sentence(10),
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => $original_task->title,
            'description' => $original_task->description,
        ]);

        $dto = new TaskDto(
            title: $this->faker->sentence(10),
            description: $this->faker->sentence(50),
        );

        $this->task_service->update($original_task, $dto);

        $this->assertDatabaseMissing('tasks', [
            'id' => $original_task->id,
            'title' => $original_title,
            'description' => $original_description,
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $original_task->id,
            'title' => $dto->getTitle(),
            'description' => $dto->getDescription(),
        ]);
    }

    public function test_can_delete_task()
    {
        $task = Task::factory()->create([
            'title' => $original_title = $this->faker->sentence(10),
            'description' => $original_description = $this->faker->sentence(10),
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => $original_title,
            'description' => $original_description,
        ]);

        $task_id = $task->id;

        $this->task_service->delete($task);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task_id,
            'title' => $original_title,
            'description' => $original_description,
        ]);
    }
}
