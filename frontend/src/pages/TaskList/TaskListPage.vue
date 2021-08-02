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
	cursor: pointer;
	&--simple{
		padding: 5px;
	}
	&_title{
		background-color: rgb(204, 200, 200);
		padding: 5px;
	}
	&_desc{
		padding: 5px;
	}
}
</style>


<template>
	<div class="task_list">

		<div class="task_list_wrap">
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

		<div class="task_list_wrap"
			v-for="column, index in model.columns"
			v-bind:key="index"

		>
			<div class="task_list_wrap_title">{{ column.title }}</div>
			<div class="task_list_items">
				<div class="task_list_item task_list_item--full"
					v-for="task_id, index in column.tasks"
					v-bind:key="index"
					v-bind:data-task-id="task_id"
				>
					<div class="task_list_item_title">
						{{ attr(model.getTargetByTaskID(task_id), "name", "") }}
					</div>
					<div class="task_list_item_desc">
						{{ attr(model.getTaskById(task_id), "name", "") }}
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
	}
});

</script>
