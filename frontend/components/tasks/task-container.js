import Link from 'next/link'

export const TaskContainer = ({ task, onClick }) => {
  const taskUrl = `/tasks/${task.id}`;

  return (
    <div className="hover:underline my-1 cursor-pointer" onClick={onClick}>
      <Link href={taskUrl}><a>{task.title}</a></Link>
    </div>
  )
}
