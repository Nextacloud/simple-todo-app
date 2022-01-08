import { useEffect, useState } from 'react'
import { Notification } from '../components/common/notification'
import { Layout } from '../components/layouts/layout'
import { AppContext } from '../context/app.context'
import '../styles/globals.css'

function MyApp({ Component, pageProps }) {
  const [notification, setNotification] = useState({shown: false, type: 'success', message: 'test'})

  const [completedTaskPage, setCompletedTaskPage] = useState(1);

  const [incompletedTaskPage, setIncompletedTaskPage] = useState(1);


  useEffect(() => {
    if (notification.shown) {
      setTimeout(() => {
        setNotification({...notification, shown: false})
      }, 3000  )
    }
  }, [notification])

  return (
    <AppContext.Provider value={{notification, setNotification, completedTaskPage, setCompletedTaskPage, incompletedTaskPage, setIncompletedTaskPage}}>
      <Layout>
        <Notification />
        <Component {...pageProps} />
      </Layout>
    </AppContext.Provider>
  )
}

export default MyApp
