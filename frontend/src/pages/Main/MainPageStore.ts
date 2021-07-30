import { createStore } from 'vuex'

export interface MainPageState
{
	username: string;
}

export const MainPageStore = createStore<MainPageState>({
	state: {
		username: "Test"
	},
	mutations: {
	},
	actions: {
	},
	modules: {
	}
})
