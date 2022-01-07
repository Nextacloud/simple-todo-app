<?php

namespace App\Services;

use App\Http\Dtos\Task\TaskDto;
use App\Models\Task;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface TaskServiceInterface
{
    public function paginate(): Paginator;

    public function list(): Collection;

    public function get(int $task_id): ?Task;

    public function create(TaskDto $dto): Task;

    public function update(Task $task, TaskDto $dto): Task;

    public function delete(Task $task): bool;
}
