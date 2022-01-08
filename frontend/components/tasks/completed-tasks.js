import { mutateTasks, useGetTasks } from "../../hooks/tasks.hooks";
import { incompleteTask } from "../../services/tasks.service";
import { TaskContainer } from "./task-container";
import { TasksListContainer } from "./tasks-list-container";

export const CompletedTasks = () => {
  const { data, isLoading } = useGetTasks('completed');

  const markTaskAsIncomplete = async (taskId) => {
    await incompleteTask(taskId);
    mutateTasks();
  }

  return (
    <TasksListContainer>
      <h2 className='text-xl font-semibold text-blue-600'>Completed Tasks</h2>

      {isLoading && <div>Loading</div>}

      {data && data.data.map(task => (
        <TaskContainer task={task} onClick={() => markTaskAsIncomplete(task.id)} />
      ))}
    </TasksListContainer>
  )
}
