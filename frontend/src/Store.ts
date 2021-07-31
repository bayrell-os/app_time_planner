import { createStore } from 'vuex'
import { buildStore } from '@/lib'
import { MainPageState } from '@/pages/Main/MainPageState'
import { TaskListPageState } from '@/pages/TaskList/TaskListPageState'


/**
 * Create store
 */
export default createStore({
	state: {
	},
	mutations: {
	},
	actions: {
	},
	modules: {
		"MainPage": buildStore(MainPageState),
		"TaskListPage": buildStore(TaskListPageState),
	}
})
