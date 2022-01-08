import { useEffect } from 'react';
import useSwr, { mutate } from 'swr';
import { axiosFetcher } from '../utils/getAxiosFetcher';

export const useGetTasks = (status, page = 1) => {
  const { data, error } = useSwr(`/api/tasks?status=${status}&page=${page}`, axiosFetcher);

  useEffect(() => {
    console.log(status, page);
  }, [page])

  return {
    data: data,
    isLoading: !error && !data,
    isError: error,
  }
}

export const mutateTasks = (incompletedTaskPage = 1, completedTaskPage = 1) => {
  mutate(`/api/tasks?status=completed&page=${completedTaskPage}`)
  mutate(`/api/tasks?status=incompleted&page=${incompletedTaskPage}`)
}

export const useGetTask = (taskId) => {

  const { data, error } = useSwr(`/api/tasks/${taskId}`, axiosFetcher);

  return {
    data: data,
    isLoading: !error && !data,
    isError: error,
  }

}
