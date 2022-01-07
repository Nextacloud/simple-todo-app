<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Exception;
use Illuminate\Log\Logger;

class TaskCompletionController extends Controller
{
    public function __construct(
        private Logger $logger,
    ) {}

    public function markAsCompleted(Task $task)
    {
        $this->logger->info('Attempt to mark as completed for task id: ' . $task->id);

        if ($task->is_completed) {
            $this->logger->info('Task is already completed, task id: ' . $task->id);
            return response()->json(['message' => 'Task is already completed'], 400);
        }

        try {

            $completed_task = $task->markAsCompleted();

            return new TaskResource($completed_task);

        } catch (Exception $error) {
            $this->logger->emergency('Fail to mark as completed for task id: ' . $task->id);

            return response()->json(['message' => 'Fail to mark as completed'], 500);
        }
    }

    public function markAsIncompleted(Task $task)
    {
        $this->logger->info('Attempt to mark as incompleted for task id: ' . $task->id);

        if (!$task->is_completed) {
            $this->logger->info('Task is not yet completed, task id: ' . $task->id);
            return response()->json(['message' => 'Task is not yet completed'], 400);
        }

        try {

            $completed_task = $task->markAsIncompleted();

            return new TaskResource($completed_task);

        } catch (Exception $error) {
            $this->logger->emergency('Fail to mark as incompleted for task id: ' . $task->id);

            return response()->json(['message' => 'Fail to mark as incompleted'], 500);
        }
    }
}
