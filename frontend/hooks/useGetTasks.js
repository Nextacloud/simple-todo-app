import useSwr from 'swr';
import { axiosFetcher } from '../utils/getAxiosFetcher';
export const useGetTasks = () => {

    const { data, error } = useSwr('/api/tasks', axiosFetcher);

    return {
        data: data,
        isLoading: !error && !data,
        isError: error
    }
}