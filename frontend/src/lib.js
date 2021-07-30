export const getModel = (instance) =>
{
	var arr = instance.namespace.slice();
	var obj = instance.$store.state;
	
	while (arr.length != 0)
	{
		var key = arr.shift();
		if (obj[key] == undefined)
		{
			obj = null;
			break;
		}
		obj = obj[key];
	}
	
	return obj;
};

export const mixin =
{
	props:
	{
		namespace: Array
	},
	computed:
	{
		model()
		{
			return getModel(this);
		}
	},
	methods:
	{
		getModel()
		{
			return getModel(this);
		},
		storeCommit (action, params)
		{
			var arr = this.namespace.concat( action.split("/") );
			this.$store.commit(arr.join("/"), params);
		},
		storeDispatch (action, params)
		{
			var arr = this.namespace.concat( action.split("/") );
			this.$store.dispatch(arr.join("/"), params);
		},
	}
};