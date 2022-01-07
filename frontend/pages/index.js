import Head from 'next/head'
import { useGetTasks } from '../hooks/useGetTasks';

import { useEffect } from 'react';

const Home = () => {
  const { data, isLoading, isError } = useGetTasks();

  useEffect(() => {
    console.log(data)
  }, [data])

  return (
    <div className="bg-gray-100 h-screen py-4">
      <div className="container mx-auto bg-white rounded-lg p-4">
        <h1 className="text-center font-bold text-4xl">To Do List</h1>

        <ul className="space-y-2">
          {data.data.map(task => (
            <li className={`cursor-pointer ${task.is_completed ? 'line-through' : ''}`}>{task.title}</li>
          ))}
        </ul>
      </div>
    </div>
    
  )
}

export default Home;