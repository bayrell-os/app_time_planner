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
				<div class="task_list_item task_list_item--simple" @click="onClick">
					Сделать сайт 1
				</div>
				<div class="task_list_item task_list_item--simple">
					Сделать сайт 2
				</div>
			</div>
		</div>

		<div class="task_list_wrap">
			<div class="task_list_wrap_title">На этой неделе</div>
			<div class="task_list_items">
				<div class="task_list_item task_list_item--full">
					<div class="task_list_item_title">Сделать сайт 1</div>
					<div class="task_list_item_desc">Тестирование сайта</div>
				</div>
				<div class="task_list_item task_list_item--full">
					<div class="task_list_item_title">Сделать сайт 1</div>
					<div class="task_list_item_desc">Показывать цены в зависимости от города</div>
				</div>
				<div class="task_list_item task_list_item--full">
					<div class="task_list_item_title">Сделать сайт 1</div>
					<div class="task_list_item_desc">Параметры товаров, фильтр и поиск товара</div>
				</div>
				<div class="task_list_item task_list_item--full">
					<div class="task_list_item_title">Прочее</div>
					<div class="task_list_item_desc">Закинуть деньги на телефон</div>
				</div>
				<div class="task_list_item task_list_item--full">
					<div class="task_list_item_title">Прочее</div>
					<div class="task_list_item_desc">Сделать уборку дома</div>
				</div>
			</div>
		</div>

		<div class="task_list_wrap">
			<div class="task_list_wrap_title">Сегодня</div>
			<div class="task_list_items">
				<div class="task_list_item task_list_item--full">
					<div class="task_list_item_title">Сделать сайт 1</div>
					<div class="task_list_item_desc">Выгрузка товаров</div>
				</div>
			</div>
		</div>

		<div class="task_list_wrap">
			<div class="task_list_wrap_title">Сегодня</div>
			<div class="task_list_items">
				<div class="task_list_item task_list_item--full">
					<div class="task_list_item_title">Сайт 2</div>
					<div class="task_list_item_desc">Поставить онлайн чат</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script src="./TaskListPageComponent.js" lang="js"></script>
