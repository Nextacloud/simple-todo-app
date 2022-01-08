import { mutateTasks, useGetTasks } from "../../hooks/tasks.hooks";
import { incompleteTask } from "../../services/tasks.service";
import { TaskContainer } from "./task-container";
import { Container } from "../common/container";

export const CompletedTasks = () => {
  const { data, isLoading } = useGetTasks('completed');

  const markTaskAsIncomplete = async (taskId) => {
    await incompleteTask(taskId);
    mutateTasks();
  }

  return (
    <Container>
      <h2 className='text-xl font-semibold text-blue-600'>Completed Tasks</h2>

      {isLoading && <div>Loading</div>}

      {data && data.data.map(task => (
        <TaskContainer task={task} onClick={() => markTaskAsIncomplete(task.id)} />
      ))}
    </Container>
  )
}
