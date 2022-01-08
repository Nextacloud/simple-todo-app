import { axios } from "../utils/getAxios"

export const completeTask = async taskId => {
  const res = await axios.post(`/api/tasks/${taskId}/complete`);
}

export const incompleteTask = async taskId => {
  const res = await axios.post(`/api/tasks/${taskId}/incomplete`);
}
