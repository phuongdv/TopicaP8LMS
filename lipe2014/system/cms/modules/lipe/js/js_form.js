(function($) {
	$(function(){ 
        // Thêm mới thể loại  
		$('.item a#create_new_category').colorbox({
			srollable: false,
			innerWidth: 600,
			innerHeight: 600,
			href: SITE_URL + 'admin/article_category/create_ajax',
			onComplete: function() {
				$.colorbox.resize();
				$('form#category_form').removeAttr('action');
				$('form#category_form').live('submit', function(e) { 
					var form_data = $(this).serialize();  
					$.ajax({
						url: SITE_URL + 'admin/article_category/create_ajax',
						type: "POST",
					        data: form_data,
						success: function(obj) {
							if(obj.status == 'ok') {
								//succesfull db insert do this stuff
								var select = 'select[name=category_id]';
								var opt_val = obj.category_id;
								var opt_text = obj.name;
								var option = '<option value="'+opt_val+'" selected="selected">'+opt_text+'</option>';
								//append to dropdown the new option
								$(select).append(option);    
								//close the colorbox
								$.colorbox.close();
							} else {  
								//no dice    
								//append the message to the dom
								$('#cboxLoadedContent').html(obj.message + obj.form);
								$('#cboxLoadedContent p:first').addClass('alert error').show();
							}
						}  
					});
					e.preventDefault();
				});   
			}
		});
	});
})(jQuery);