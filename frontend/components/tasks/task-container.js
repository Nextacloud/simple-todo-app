export const TaskContainer = ({ task, onClick }) => {
  return (
    <div className={`my-1 cursor-pointer ${task.is_completed ? 'line-through' : ''}`} onClick={onClick}>
      {task.title}
    </div>
  )
}
