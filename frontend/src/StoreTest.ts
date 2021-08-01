import { Store } from "vuex";
import { AppState } from "./AppState";
import { Target, Task, TaskListPageState } from "./pages/TaskList/TaskListPageState";
import * as dayjs from 'dayjs'

/**
 * Create test store
 */
export function initTestStore (store: Store<AppState>)
{
	let time:number = new Date().getTime();
	let today:string = dayjs( new Date(time) ).format("YYYY-MM-DD");
	let tomorrow:string = dayjs( new Date(time + 24*60*60*1000) ).format("YYYY-MM-DD");
	let tomorrow2:string = dayjs( new Date(time + 2*24*60*60*1000) ).format("YYYY-MM-DD");

	/* Main Page */
	store.state.MainPage.username = "Test12345";

	/* Task List Page */
	store.state.TaskListPage.targets.push( new Target().assignValues({
		id: 1,
		name: "Сделать сайт 1",
	}) );
	store.state.TaskListPage.targets.push( new Target().assignValues({
		id: 2,
		name: "Сделать сайт 2",
	}) );
	store.state.TaskListPage.targets.push( new Target().assignValues({
		id: 3,
		name: "Прочее",
	}) );

	/* Tasks */
	store.state.TaskListPage.tasks.push( new Task().assignValues({
		id: 1,
		target_id: 1,
		name: "Тестирование сайта",
		date: today,
	}) );
	store.state.TaskListPage.tasks.push( new Task().assignValues({
		id: 2,
		target_id: 1,
		name: "Показывать цены в зависимости от города",
		date: today,
	}) );
	store.state.TaskListPage.tasks.push( new Task().assignValues({
		id: 3,
		target_id: 1,
		name: "Параметры товаров, фильтр и поиск товара",
		date: today,
	}) );
	store.state.TaskListPage.tasks.push( new Task().assignValues({
		id: 4,
		target_id: 1,
		name: "Выгрузка товаров",
		date: tomorrow,
	}) );
	store.state.TaskListPage.tasks.push( new Task().assignValues({
		id: 5,
		target_id: 2,
		name: "Поставить онлайн чат",
		date: tomorrow2,
	}) );
	store.state.TaskListPage.tasks.push( new Task().assignValues({
		id: 6,
		target_id: 3,
		name: "Закинуть деньги на телефон",
		date: tomorrow,
	}) );
	store.state.TaskListPage.tasks.push( new Task().assignValues({
		id: 7,
		target_id: 3,
		name: "Сделать уборку дома",
		date: tomorrow,
	}) );

	/* Init columns */
	TaskListPageState.initColumns(store.state.TaskListPage);
}

function generateTarget(id: number, name: string): Target
{
	let target = new Target();
	target.id = id;
	target.name = name;
	return target;
}
