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

export class TaskListState
{
	tasks: Array<Task> = new Array<Task>();
	targets: Array<Target> = new Array<Target>();
}

export const TaskListPageStore = createStore({
	state: new TaskListState(),
	mutations:
	{
	},
	actions:
	{
	},
	modules:
	{
	}
})
