import { Store } from "vuex";
import { MainPageState } from "./pages/Main/MainPageState";
import { Target, TaskListPageState } from "./pages/TaskList/TaskListPageState";

/**
 * Create test store
 */
export function createTestStore (store: Store<{}>)
{
	let state: Record<string, any> = store.state;
	
	/* Main Page */
	let main_page: MainPageState = new MainPageState();
	main_page.username = "Test12345";
	state["MainPage"] = main_page;

	/* Task List Page */
	let task_list_page: TaskListPageState = new TaskListPageState();
	task_list_page.targets.push( generateTarget(1) );
	task_list_page.targets.push( generateTarget(2) );
	state["TaskListPage"] = task_list_page;
}

function generateTarget(id: number): Target
{
	let target = new Target();
	target.id = id;
	target.name = generateTargetTitle(id);
	return target;
}

function generateTargetTitle(id: number): string
{
	return "Target " + id;
}