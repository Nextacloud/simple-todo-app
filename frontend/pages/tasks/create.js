import { Container } from "../../components/common/container";
import { TaskForm } from "../../components/tasks/task-form"

const TaskCreate = () => {

  return (
    <Container>
      <h2 className="text-2xl font-bold text-blue-600 mb-4">Create Task</h2>
      <TaskForm />
    </Container>
  )
}

export default TaskCreate;
