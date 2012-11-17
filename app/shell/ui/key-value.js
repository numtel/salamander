jQuery(function($){
	admin.initKeyValue=function(element,callbackSubmit){
			element=element.find('ul.key-value:not(.js-applied,.no-write)').addClass('js-applied');
			if(!element.length) return false;
			var insertBlank=function(){
						var boxWidth=element.hasClass('narrow') ? 3 :5,
							newItem=$('<li class="item-key-value new"><input class="key span2" type="text" value=""><input class="span'+boxWidth+'" name="fields[data][]" type="text" value="" /> <a class="btn delete-key-value hide" href="javascript:" title="Delete Attribute"> <i class="icon-trash"></i> </a></li>');
						element.append(newItem);
						linkKeyFields();
					},
				updateNames=function(){
							var extraIndex='';
							if(element.hasClass('insert')){
								extraIndex='['+element.closest('form').find('input.item-name').val()+']';
							}
							$(this).next().attr('name','fields[data]'+extraIndex+'['+this.value+']');
							if(!$(this).hasClass('item-name') && 
								this.value!=='' && 
								$(this).closest('li').next().length==0){
									$(this).parent().children('.btn').removeClass('hide');
									insertBlank();
							}
						},
				linkKeyFields=function(){
						if(element.hasClass('insert')){
							element.closest('form').find('input.item-name').change(updateNames);
						}
						element.find('input.key:not(.link-applied)').addClass('link-applied').change(updateNames);
						element.find('.delete-key-value:not(.js-applied)').addClass('js-applied').click(function(){
							var attribute=$(this).closest('li'),
								itemAddress=element.closest('form').find('input[name="fields[address]"]').val();
							if(attribute.hasClass('new')){
								//remove new attribute
								attribute.remove();
							}else{
								//remove existing attribute
								$.post(appPath+'terminal/command',
										{'action':'record_tree2/delete',
										'fields[address]':itemAddress,
										'fields[key]':attribute.attr('data-key')},
											function(data){
												var error=data.toLowerCase().indexOf('success')===-1;
												admin.addMessage(data,error);
												if(!error) attribute.remove();
											});
							}
						});
					};
			//form validation
			element.closest('form').submit(function(e){
				//make sure the callback passes first
				if(callbackSubmit!==undefined && callbackSubmit.call(this)===false){
					e.preventDefault();
					return false;
				};
				//check for errors
				element.find('li.item-key-value.new.error').removeClass('error');
				var errorCount=0,form=$(this);
				element.find('input[name="fields[data][]"]').each(function(){
					var attribute=$(this).closest('li');
					if(this.value===''){
						attribute.remove();
					}else{
						attribute.addClass('control-group error');
						++errorCount;
					};
				});
				if(errorCount===0){
					//post the form
					$.post(appPath+'terminal/command',form.serialize(),
								function(data){
									var error=data.toLowerCase().indexOf('success')===-1;
									admin.addMessage(data,error);
									admin.reloadItem();
									if(form.hasClass('modal')) form.modal('hide');
								});
				};
				e.preventDefault();
				return false;
			});
			//construct
			insertBlank();
		};
});
