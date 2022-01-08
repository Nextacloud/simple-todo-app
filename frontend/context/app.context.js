import { createContext } from "react";

/**
 * Return an application wide context to deal with notification and paginations pages
 */
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
