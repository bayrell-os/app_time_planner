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
	/*
	{
		path: '/tasks/',
		name: 'TaskListPage',
		// route level code-splitting
		// this generates a separate chunk (about.[hash].js) for this route
		// which is lazy-loaded when the route is visited.
		component: () => import(
			// webpackChunkName: "about"
			'@/pages/TaskListPage.vue'
			)
	}*/
]

const router = createRouter({
	history: createWebHistory("/"),
	routes
})

export default router
