import { createStore } from 'vuex'
import { MainPageStore } from '@/pages/Main/MainPageStore'
import { TaskListPageStore } from '@/pages/TaskList/TaskListPageStore'

export default createStore({
  state: {
  },
  mutations: {
  },
  actions: {
  },
  modules: {
    "MainPage": MainPageStore,
    "TaskListPage": TaskListPageStore
  }
})
