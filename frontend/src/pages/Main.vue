<style>
</style>


<template>
	<div class="page_home">
		Hello {{ model.name }}!
	</div>
</template>


<script>

export default
{
	props: ['namespace'],
	buildStore: (state) =>
	{
		if (state == null || state == undefined)
		{
			state =
			{
				"name": "Username",
			};
		}
		
		var res =
		{
			namespaced: true,
			state: () => { return state; },
			modules:
			{
			},
			mutations:
			{
			},
		}
		
		return res;
	},
	computed:
	{
		model()
		{
			return this.getModel();
		},
	},
	components:
	{
	},
}
</script>
