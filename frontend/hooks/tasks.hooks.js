import useSwr, { mutate } from 'swr';
import { axiosFetcher } from '../utils/getAxiosFetcher';

export const useGetTasks = (status) => {
  const { data, error } = useSwr(`/api/tasks?status=${status}`, axiosFetcher);

  return {
    data: data,
    isLoading: !error && !data,
    isError: error,
  }
}

export const mutateTasks = () => {
  mutate(`/api/tasks?status=completed`)
  mutate(`/api/tasks?status=incompleted`)
}
