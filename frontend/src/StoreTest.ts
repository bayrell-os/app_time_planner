import { Store } from "vuex";
import { AppState } from "./AppState";
import { Target } from "./pages/TaskList/TaskListPageState";

/**
 * Create test store
 */
export function initTestStore (store: Store<AppState>)
{
	/* Main Page */
	store.state.MainPage.username = "Test12345";

	/* Task List Page */
	store.state.TaskListPage.targets.push( generateTarget(1) );
	store.state.TaskListPage.targets.push( generateTarget(2) );
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