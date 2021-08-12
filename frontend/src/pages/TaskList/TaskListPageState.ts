
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
	 * Position 
	 */
	pos: number = 0;


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
		this.pos = Number(params["pos"] || this.pos);
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

	/**
	 * From object
	 */
	assignValues(params:Record<string, any>): TaskColumn
	{
		this.title = String(params["title"] || this.title);
		this.date = String(params["date"] || this.date);
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
	task_drag_item: Task | null = null;
	task_drag_prev_id: number = -1;


	/**
	 * Returns task by id
	 */
	getTaskById(task_id:number): Task | null
	{
		let task:Task | undefined = this.tasks.find( (task) => task.id == task_id );
		if (task == undefined) return null;
		return task;
	}


	/**
	 * Returns target by id
	 */
	getTargetById(target_id:number): Target | null
	{
		let target:Target | undefined = this.targets.find( (target) => target.id === target_id );
		if (target == undefined) return null;
		return target;
	}


	/**
	 * Returns target name by task id
	 */
	getTargetByTaskID(task_id:number): Target | null
	{
		let task = this.getTaskById(task_id);
		if (task && task.target_id)
		{
			let target = this.getTargetById(task.target_id);
			if (target)
			{
				return target;
			}
		}
		return null;
	}
	

	/**
	 * Returns target name by task id
	 */
	getColumnTasks(column: TaskColumn): Array<Task>
	{
		let res = this.tasks
			/* Get task by date */
			.filter( task => task.date == column.date )
			/* Sort by pos */
			.sort( (a: Task, b: Task) => a.pos - b.pos )
		;
		return res;
	}	


	/**
	 * Insert src before item
	 */
	dragTask(task_id_src: number, task_id_dest: number)
	{
		if (task_id_src == task_id_dest) return;

		let src: Task | null = this.getTaskById(task_id_src);
		let dest: Task | null = this.getTaskById(task_id_dest);
		if (src == null || dest == null) return;

		let column_date: string = dest.date;

		/* Get tasks in column by date */
		let arr: Array<Task> = this.tasks
			.filter( task => task.date == column_date )
			.sort( (a: Task, b: Task) => a.pos - b.pos )
		;

		let kind = "";
		let index_src:number = arr.indexOf(src);
		let index_dest:number = arr.indexOf(dest);

		if (index_src == -1) kind = "before";
		else if (index_src < index_dest) kind = "after";
		else kind = "before";

		/* Remove src */
		if (index_src != -1) arr.splice(index_src, 1);

		/* Insert new item */
		if (kind == "before")
		{
			let index:number = arr.indexOf(dest);
			arr.splice(index, 0, src);
		}
		else
		{
			let index:number = arr.indexOf(dest) + 1;
			arr.splice(index, 0, src);
		}

		/* Set task posistion */
		for (let i=0; i<arr.length; i++)
		{
			arr[i].pos = i;
		}

		/* Update src date */
		src.date = dest.date;
	}


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
