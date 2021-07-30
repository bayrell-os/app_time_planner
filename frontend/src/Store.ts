import { createStore } from 'vuex'
import { TaskListStore } from '@/pages/TaskList/TaskListStore'

export default createStore({
  state: {
  },
  mutations: {
  },
  actions: {
  },
  modules: {
    "TaskList": TaskListStore
  }
})
