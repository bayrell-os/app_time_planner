<style lang="scss" scoped>
.task_list{
	display: flex;
	flex-direction: row;
	justify-content: flex-start;
}
.task_list_wrap{
	width: 300px;
	padding: 10px;
}
.task_list_wrap_title{
	/*margin-top: 10px;*/
	margin-bottom: 10px;
	font-weight: bold;
}
.task_list_item{
	background-color: white;
	border: 1px #ccc solid;
	margin-bottom: 10px;
	/*cursor: pointer;*/
	&--simple{
		padding: 5px;
	}
	&_title{
		background-color: rgb(204, 200, 200);
		padding: 5px;
		cursor: pointer;
	}
	&_desc{
		padding: 5px;
	}
}
</style>


<template>
	<div class="task_list">

		<div class="task_list_wrap task_list_wrap--target">
			<div class="task_list_wrap_title">Цели</div>
			<div class="task_list_items">
				<div class="task_list_item task_list_item--simple"
					v-for="target in model.targets"
					v-bind:key="target.id"
					v-bind:data-target-id="target.id"
				>
					{{ target["name"] }}
				</div>
			</div>
		</div>

		<div class="task_list_wrap task_list_wrap--column"
			v-for="column, index in model.columns"
			v-bind:key="index"
			v-bind:data-column-id="column.id"
			v-bind:data-column-date="column.date"

		>
			<div class="task_list_wrap_title">{{ column.title }}</div>
			<div class="task_list_items"
				@drop="onDrop($event, column)"
				@dragover.prevent
         		@dragenter="onDragEnterColumn($event, column)"
			>
				<div class="task_list_item task_list_item--full"
					v-for="task, index in model.getColumnTasks(column)"
					v-bind:key="index"
					v-bind:data-task-id="task.id"
					@dragenter="onDragEnterTask($event, task)"
					@dragover="onDragOverTask($event, task)"
				>
					<div class="task_list_item_title"
						@dragstart="onDragStart($event, task)"
						draggable="true"
					>
						{{ attr(model.getTargetById(task.target_id), "name", "") }}
					</div>
					<div class="task_list_item_desc">
						{{ task.name }}
					</div>
				</div>
			</div>
		</div>
		
	</div>
</template>

<script lang="js">

import { defineComponent } from 'vue';
import { mixin } from "vue-helper";
import { mixin_lib } from "@/lib";

export default defineComponent({
	mixins: [ mixin, mixin_lib ],
	computed:
	{
	},
	methods:
	{
		onClick()
		{
			console.log("!!!");
		},
		onDragStart(event, task)
		{
			this.model.task_drag_item = task;
			this.model.task_drag_elem = event.target;
			event.dataTransfer.dropEffect = 'move';
			event.dataTransfer.effectAllowed = 'move';
			this.model.task_drag_prev_id = -1;
		},
		onDrop(event, column)
		{
			this.model.task_drag_item = null;
		},
		onDragEnterColumn(event, column)
		{
			// this.model.task_drag_prev_id = -1;
			/*event.dataTransfer.setData('enter_item', column)*/
		},
		onDragEnterTask(event, task)
		{
			if (this.model.task_drag_item)
			{
				if (
					this.model.task_drag_item.id != task.id &&
					this.model.task_drag_prev_id != task.id
				)
				{
					this.model.dragTask(this.model.task_drag_item.id, task.id);
					this.model.task_drag_prev_id = task.id;
				}
			}
		},
		onDragOverTask(event, task)
		{
			if (this.model.task_drag_prev_id == task.id)
			{
				// console.log(task.id);
			}
			else
			{
				this.model.task_drag_prev_id = -1;
			}
			event.preventDefault();
		}
	}
});

</script>
