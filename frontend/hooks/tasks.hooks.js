import useSwr, { mutate } from 'swr';
import { axiosFetcher } from '../utils/getAxiosFetcher';

/**
 * Fetch list of tasks
 * @param {string} status - completed or incompleted
 * @param {int} page - The page number of the tasks list to be retrieved
 * @returns
 */
export const useGetTasks = (status, page = 1) => {
  const { data, error } = useSwr(`/api/tasks?status=${status}&page=${page}`, axiosFetcher);

  mutateTasksList(status, page + 1)
  mutateTasksList(status, page - 1)

  return {
    data: data,
    isLoading: !error && !data,
    isError: error,
  }
}

/**
 * Function to revalidate the data of the completed in incomplete task
 * @param {int} incompletedTaskPage - The current page of the incompleted task list
 * @param {int} completedTaskPage - The current page of the completed tasks list
 */
export const mutateTasks = (incompletedTaskPage = 1, completedTaskPage = 1) => {
  mutate(`/api/tasks?status=completed&page=${completedTaskPage}`)
  mutate(`/api/tasks?status=incompleted&page=${incompletedTaskPage}`)
}

export const mutateTasksList = (status, page) => {
  mutate(`/api/tasks?status=${status}&page=${page}`, axiosFetcher(`/api/tasks?status=${status}&page=${page}`))
}

/**
 * Get the task based on task id
 * @param {int} taskId
 */
export const useGetTask = (taskId) => {

  const { data, error } = useSwr(`/api/tasks/${taskId}`, axiosFetcher);

  return {
    data: data,
    isLoading: !error && !data,
    isError: error,
  }

}
