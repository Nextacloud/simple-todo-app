<?php

namespace Tests\Feature\Http\Controllers\ApiControllers;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TaskCompletionControllerTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function test_can_mark_as_completed_an_incompleted_task()
    {
        $task = Task::factory()->incomplete()->create();

        $this->assertTrue(!$task->is_completed);

        $response = $this->postJson(route('tasks.completion.complete', ['task' => $task->id]));

        $response->assertStatus(200);

        $task->refresh();

        $this->assertTrue($task->is_completed);
    }

    public function test_cannot_mark_as_completed_a_completed_task()
    {
        $task = Task::factory()->complete()->create();

        $this->assertTrue($task->is_completed);

        $response = $this->postJson(route('tasks.completion.complete', ['task' => $task->id]));

        $response->assertStatus(400);

        $task->refresh();

        $this->assertTrue($task->is_completed);
    }

    public function test_can_mark_as_incompleted_a_completed_task()
    {
        $task = Task::factory()->complete()->create();

        $response = $this->postJson(route('tasks.completion.incomplete', ['task' => $task->id]));

        $response->assertStatus(200);

        $task->refresh();

        $this->assertTrue(!$task->is_completed);
    }

    public function test_cannot_mark_as_incompleted_an_incompleted_task()
    {
        $task = Task::factory()->incomplete()->create();

        $this->assertTrue(!$task->is_completed);

        $response = $this->postJson(route('tasks.completion.incomplete', ['task' => $task->id]));

        $response->assertStatus(400);

        $task->refresh();

        $this->assertTrue(!$task->is_completed);
    }
}
