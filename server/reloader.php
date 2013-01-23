<script>
		Ext.onReady(function() {
			
			Ext.MessageBox.show({
				title 		: 'Success',
				msg	  		: action.result.message,
				icon  		: Ext.MessageBox.INFO,
				buttons		: Ext.Msg.OK,
				fn			: function(btnString) {
					//Reload the page if our update was a success
					location.reload(true);
				}
			});

		});

		</script>

