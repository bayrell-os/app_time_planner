import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import MainPage from '@/pages/Main/MainPage.vue'
import TaskListPage from '@/pages/TaskList/TaskListPage.vue'

const routes: Array<RouteRecordRaw> = [
	{
		path: '/',
		name: 'MainPage',
		component: MainPage,
		props: { store_path: ["MainPage"] }
	},
	{
		path: '/tasks/',
		name: 'TaskListPage',
		component: TaskListPage,
		props: { store_path: ["TaskListPage"] }
	},
]

const router = createRouter({
	history: createWebHistory("/"),
	routes
})

export default router
