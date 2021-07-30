import { createStore } from 'vuex'

/**
 * Task status
 */
export const TaskStatus =
{
	NEW: "new",
	WORK: "work",
	COMPLETE: "complete",
};
 
 
/**
 * Target
 */
export class Target
{
	/**
	 * Target id
	 */
	id = 0;

	/**
	 * Target name
	 */
	name = "";
}
 
 
/**
 * Task
 */
export class Task
{
	/**
	 * Task id
	 */
	id = 0;

	/**
	 * Target id
	 */
	target_id = null;

	/**
	 * Task name
	 */
	name = "";

	/**
	 * Task date
	 */
	date = null;

	/**
	 * Task status
	 */
	status = "";

	/**
	 * User id
	 */
	user_id = null;
}

export interface TaskListPageState
{
	tasks: Array<Task>;
	targets: Array<Target>;
}

export const TaskListPageStore = createStore<TaskListPageState>({
	state:
	{
		tasks: new Array<Task>(),
		targets: new Array<Target>(),
	},
	mutations:
	{
		addTask (state: TaskListPageState, task: Task)
		{
		}
	},
	actions:
	{
	},
	modules:
	{
	}
})
