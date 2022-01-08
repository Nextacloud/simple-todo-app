import { useRouter } from "next/router";
import { Container } from "../../components/common/container";
import { TaskForm } from "../../components/tasks/task-form"
import { useGetTask } from "../../hooks/tasks.hooks";

const TaskUpdate = () => {

  const router = useRouter()

  const { taskId } = router.query

  const { data, isError, isLoading } = useGetTask(taskId);


  return (
    <Container>
      <h2 className="text-2xl font-bold text-blue-600 mb-4">Update Task</h2>
      {data && <TaskForm task={data.data}/>}
    </Container>
  )
}

export default TaskUpdate;
