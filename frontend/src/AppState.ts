import { MainPageState } from '@/pages/Main/MainPageState'
import { TaskListPageState } from '@/pages/TaskList/TaskListPageState'

export class AppState
{
	MainPage: MainPageState = new MainPageState();
	TaskListPage: TaskListPageState = new TaskListPageState();


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
			"MainPage": MainPageState,
			"TaskListPage": TaskListPageState,
		};
		return res;
	}

}
