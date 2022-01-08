<?php

namespace App\Services;

use App\Http\Dtos\Task\TaskDto;
use App\Models\Task;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class TaskService implements TaskServiceInterface
{

    public function paginate(?string $status = null): Paginator
    {
        $tasks_query = Task::query()->latest();

        if ($status === 'completed') $tasks_query = $tasks_query->isCompleted();

        if ($status === 'incompleted') $tasks_query = $tasks_query->isIncompleted();

        return $tasks_query->paginate();
    }

    public function list(): Collection
    {
        $tasks = Task::all();

        return $tasks;
    }

    public function get(int $task_id): ?Task
    {
        $task = Task::find($task_id);
        return $task;
    }

    public function create(TaskDto $dto): Task
    {
        return Task::create([
            'title' => $dto->getTitle(),
            'description' => $dto->getDescription(),
        ]);
    }

    public function update(Task $task, TaskDto $dto): Task
    {
        return tap($task, fn(Task $task) =>
            $task->update([
                'title' => $dto->getTitle(),
                'description' => $dto->getDescription(),
            ])
        );
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }
}
