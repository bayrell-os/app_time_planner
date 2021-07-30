import { createStore, Store } from 'vuex'
import { MainPageStore, MainPageState } from '@/pages/Main/MainPageStore'
import { TaskListPageStore } from '@/pages/TaskList/TaskListPageStore'


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
		"MainPage": MainPageStore,
		"TaskListPage": TaskListPageStore
	}
})


/**
 * Create test store
 */
export function createTestStore (store: Store<{}>)
{
	let state: Record<string, any> = store.state;
	
	/* Main Page */
	let main_page: MainPageState = state["MainPage"];
	main_page.username = "Test12345";

}