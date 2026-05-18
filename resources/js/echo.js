import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import axios from 'axios'

window.Pusher = Pusher

Pusher.logToConsole = import.meta.env.DEV

const echo = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: true,
  // Use axios so the Bearer token header is always included automatically
  authorizer: (channel) => ({
    authorize: (socketId, callback) => {
      axios.post('broadcasting/auth', {
        socket_id: socketId,
        channel_name: channel.name,
      })
        .then(res => callback(null, res.data))
        .catch(err => callback(err))
    },
  }),
})

export default echo
