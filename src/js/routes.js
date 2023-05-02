import Dashboard from './Components/Dashboard.vue'
import Rejected from './Components/Rejected.vue'
import Waiting from './Components/Waiting.vue'
import Selected from './Components/Selected.vue'
import Slots from './Components/Slots.vue'
import Events from './Components/Events.vue'
import All from './Components/All.vue'

export const routes = [
  {
    path: '/',
    name: 'events',
    component: Events
  },

  {
    name: 'dashboard',
    path: '/:id',
    component: Dashboard,
    children: [
      {
        path: '/:id/all',
        name: 'applicants',
        component: All
      },
      {
        path: '/:id/selected',
        name: 'selected',
        component: Selected
      },
      {
        path: '/:id/rejected',
        name: 'rejected',
        component: Rejected
      },
      {
        path: '/:id/waiting',
        name: 'waiting',
        component: Waiting
      },
      {
        path: '/:id/slots',
        name: 'slots',
        component: Slots
      }
    ]
  }
]
