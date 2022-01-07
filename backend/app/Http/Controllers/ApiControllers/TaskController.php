<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskServiceInterface;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Log\Logger;

class TaskController extends Controller
{

    public function __construct(
        private TaskServiceInterface $task_service,
        private Logger $logger,
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {

        $this->logger->info('Fetching tasks');

        $tasks = $this->task_service->paginate();

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return TaskResource
     */
    public function store(StoreTaskRequest $request)
    {
        $this->logger->info('Creating new task');

        $task_dto = $request->getTaskDto();


        $this->logger->info('Task DTO: ' . json_encode($task_dto));

        try {
            $task = $this->task_service->create($task_dto);

            $this->logger->info('Task created!');

            return new TaskResource($task);

        } catch (Exception $err) {

            $this->logger->emergency('Fail to create new task');

            $this->logger->debug($err->getTraceAsString());

            return response()->json(['message' => 'Fail to create new task'], 500);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return TaskResource
     */
    public function show(int $task_id)
    {
        $this->logger->info('Fetching task id ' . $task_id);

        $task = $this->task_service->get($task_id);

        if (!$task) abort(404, 'Task not found!');

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  int  $task_id
     * @return TaskResource
     */
    public function update(UpdateTaskRequest $request, int $task_id)
    {
        $this->logger->info('Attempt to update task id ' . $task_id);

        $task = $this->task_service->get($task_id);

        if (!$task) abort(404, 'Task not found!');

        $task_dto = $request->getTaskDto();

        try {

            $updated_task = $this->task_service->update($task, $task_dto);

            $this->logger->info('Task updated!');

            return new TaskResource($updated_task);

        } catch (Exception $err) {

            $this->logger->emergency('Fail to update task id : ' . $task_id);

            $this->logger->debug($err->getTraceAsString());

            return response()->json(['message' => 'Fail to update the task!'], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $task_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $task_id)
    {
        $this->logger->info('Attempt to delete task id ' . $task_id);

        $task = $this->task_service->get($task_id);

        if (!$task) abort(404, 'Task not found!');

        try {

            $this->task_service->delete($task);

            $this->logger->info('Task delete!');

            return response()->json(null, 204);

        } catch (Exception $err) {

            $this->logger->emergency('Fail to delete task id : ' . $task_id);

            $this->logger->debug($err->getTraceAsString());

            return response()->json(['message' => 'Fail to delete the task!'], 500);

        }

    }
}
