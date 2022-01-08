import { createContext } from "react";

export const AppContext = createContext({
  notification: {
    shown: false,
    type: 'success',
    message: ''
  },
  setNotification: () => {},

  completedTaskPage: 1,
  setCompletedTaskPage: () => {},
  incompletedTaskPage: 1,
  setIncompletedTaskPage: () => {},
});
