
	   function showNotification(color,msg){
				 

				 $.notify({
					  icon: "nc-icon nc-bell-55",
					  message: msg

				 }, {
				 type: color,
				 timer: 6000,
				 placement: {
					  from: 'top',
					  align: 'right'
				 }
				 });
		}

		$('.switch-class').change(function() {
			var status = $(this).prop('checked') == true ? 1 : 0;
			var item = $(this).data('name');
			var id = $(this).data('id');
			$.ajax({
				type: "GET",
				dataType: "json",
				url: 'change',
				data: {
					'status': status,
					'item': item,
					'id':id
				},
				success: function(data) {
					if (data.success)
						showNotification('success', data.message);
				}
			});
		});