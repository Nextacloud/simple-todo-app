import { axios } from "../utils/getAxios"

export const createTask = async ({ title, description }) => {
  const res = await axios.post(`/api/tasks`, {
    title, description,
  });

  return res;
}

export const completeTask = async taskId => {
  const res = await axios.post(`/api/tasks/${taskId}/complete`);
}

export const incompleteTask = async taskId => {
  const res = await axios.post(`/api/tasks/${taskId}/incomplete`);
}
