import Link from 'next/link'

import { CompletedTasks } from '../components/tasks/completed-tasks';
import { IncompleteTasks } from '../components/tasks/incomplete-tasks';

const Home = () => {

  return (
    <>
      <div className='container mx-auto flex flex-row justify-end'>
        <Link href="/tasks/create">
          <a className='bg-blue-600 hover:bg-blue-700 text-blue-50 py-2 px-4 rounded-md justify-right'>Create Task</a>
        </Link>
      </div>
      <IncompleteTasks />
      <CompletedTasks />
    </>
  )
}

export default Home;
