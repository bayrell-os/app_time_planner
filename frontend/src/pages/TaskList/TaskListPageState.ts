
import { BaseObject, findIndexByKey, findItemByKey, removeDuplicates } from "@/lib"


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
export class Target extends BaseObject
{
	/**
	 * Target id
	 */
	id: number = 0;

	/**
	 * Target name
	 */
	name: string = "";


	/**
	 * From object
	 */
	assignValues(params:Record<string, any>): Target
	{
		this.id = Number(params["id"] || this.id);
		this.name = String(params["name"] || this.name);
		super.assignValues(params);
		return this;
	}
}


/**
 * Task
 */
export class Task extends BaseObject
{
	/**
	 * Task id
	 */
	id: number = 0;

	/**
	 * Target id
	 */
	target_id: number | null = null;

	/**
	 * Task name
	 */
	name: string = "";

	/**
	 * Task date
	 */
	date: string = "";

	/**
	 * Task status
	 */
	status: string = "";

	/**
	 * User id
	 */
	user_id: number | null = null;


	/**
	 * From object
	 */
	assignValues(params:Record<string, any>): Task
	{
		this.id = Number(params["id"] || this.id);
		this.name = String(params["name"] || this.name);
		this.status = String(params["status"] || this.status);
		this.target_id = Number(params["target_id"] || this.target_id);
		this.user_id = Number(params["user_id"] || this.user_id);
		this.date = String(params["date"] || this.date);
		super.assignValues(params);
		return this;
	}
}


/**
 * Task column
 */
export class TaskColumn extends BaseObject
{
	title: string = "";
	date: string = "";
	tasks: Array<number> = new Array<number>();

	/**
	 * From object
	 */
	assignValues(params:Record<string, any>): TaskColumn
	{
		this.title = String(params["title"] || this.title);
		this.date = String(params["date"] || this.date);
		if (params["tasks"] != undefined && params["tasks"] instanceof Array)
		{
			this.tasks = params["tasks"].slice().map( item => Number(item) );
		}
		super.assignValues(params);
		return this;
	}
}


/**
 * Task list page state
 */
export class TaskListPageState extends BaseObject
{
	tasks: Array<Task> = new Array<Task>();
	targets: Array<Target> = new Array<Target>();
	columns: Array<TaskColumn> = new Array<TaskColumn>();


	/**
	 * Init columns
	 */
	static initColumns(state:TaskListPageState)
	{
		state.columns = Array<TaskColumn>();
		
		/* Get tasks dates sorted by asc */
		let dates:Array<string> = removeDuplicates( state.tasks.map( task => task.date ) )
			.sort();

		/* Add task.id into columns */
		dates.forEach
		(
			(value: string, index: number) =>
			{
				state.columns.push
				(
					new TaskColumn().assignValues
					({
						"title": value,
						"date": value,
						"tasks": state.tasks
							.filter( task => task.date == value )
							.map( task => task.id )
					})
				)
			}
		);

	}
	

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
