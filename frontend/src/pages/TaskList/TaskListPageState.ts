
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

export class TaskListPageState
{
	tasks: Array<Task> = new Array<Task>();
	targets: Array<Target> = new Array<Target>();


	/**
	 * Returns methods list
	 */
	static mutations(): Array<string>
	{
		let res: Array<string> =
		[
		];
		return res;
	}


	/**
	 * Returns modules
	 */
	static modules(): Record<string, any>
	{
		let res: Record<string, any> =
		{
		};
		return res;
	}
}
