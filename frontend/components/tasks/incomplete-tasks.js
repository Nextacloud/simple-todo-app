import { mutateTasks, useGetTasks } from "../../hooks/tasks.hooks";
import { completeTask, deleteTask } from "../../services/tasks.service";
import { TaskContainer } from "./task-container";
import { Container } from "../common/container";

export const IncompleteTasks = () => {
  const { data, isLoading } = useGetTasks('incompleted');

  const markTaskAsCompleted = async (taskId) => {
    await completeTask(taskId);
    mutateTasks();
  }

  const _deleteTask = async (taskId) => {
    await deleteTask(taskId);
    mutateTasks();
  }


  return (
    <Container>
      <h2 className='text-xl font-semibold text-blue-600 my-4'>Incomplete Tasks</h2>

      {isLoading && <div>Loading</div>}

      <div className="flex flex-col space-y-2">
        {data && data.data.map(task => (
          <div className="flex flex-row space-x-2" key={data.data.id}>
            <button className="bg-green-300 rounded-lg p-2" onClick={() => markTaskAsCompleted(task.id)}>
              <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
              </svg>
            </button>
            <button className="bg-red-300 rounded-lg p-2" onClick={() => _deleteTask(task.id)}>
              <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
            <TaskContainer task={task} />
          </div>
        ))}
      </div>
    </Container>
  )
}
