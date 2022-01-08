import { createContext } from "react";

export const AppContext = createContext({
  notification: {
    shown: false,
    type: 'success',
    message: ''
  },
  setNotification: () => {},
});
