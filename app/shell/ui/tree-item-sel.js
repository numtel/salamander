jQuery(function($){
	admin.initTreeItemSel=function(element,classString,callback,justReturnElement){
		var retval;
		element.each(function(){
			var input=$(this),val=input.val();
			var box=$('<div class="tree-sel-wrapper clearfix" />'),
				updateDisplay=function(){
							// get array of elements
							var lists = box.children();

							// sort based on column attribute
							lists.sort(function(a, b) {

								// convert to integers from strings
								a = parseInt($(a).attr("data-column"), 10);
								b = parseInt($(b).attr("data-column"), 10);

								// compare
								if (a > b) {
									return 1;
								} else if (a < b) {
									return -1;
								} else {
									return 0;
								}
							});

							// put sorted results back on page
							box.append(lists);
							lists.filter(':has(.active)').scrollTo('.active');
							//set wrapper width
							var fullWidth=lists.length*box.children(':eq(0)').outerWidth(true);
							box.css('width',fullWidth).parent().scrollLeft(fullWidth);
							/*//set all heights equal
							box.children().css({'min-height':''});
							box.children().css({'min-height':box.innerHeight()});*/
						},
				loadList=function(address,column,active){
						//remove any lists in this column or after
						box.children().each(function(){
							if($(this).attr('data-column')*1>=column) $(this).remove();
						});
						//load children
						$.post(appPath+'terminal/command',
							{'action':'record_tree2/get',
							'template':appDir+'/blocks/list',
							'fields[address]':address,
							'fields[depth]':0},
							function(data){
								var thisCol=$('<div class="sel-column" data-column-address="'+address+'" data-column="'+column+'"/>');
								thisCol.html(data);
								thisCol.find('ul[data-roles*=s]').sortable({
									cancel: '.nav-header',
									delay: 100,
									update: function(event, ui) {
										thisCol.addClass('loading');
										var itemOrderString='';
										$(this).children().each(function(){
											itemOrderString+='&fields[data][]='+$(this).attr('data-address');
										});
										$.post(appPath+'terminal/command',
											'action=record_tree2/sort&fields[address]='+
													address.substr(0, address.length===1 ? 1 :address.length-1)
												+itemOrderString,
											function(data){
												thisCol.removeClass('loading');
												if(data.toLowerCase().indexOf('success')<0) 
													admin.addMessage("Item sort failure!",true);
											});
										}
								});
								thisCol.find('li.tree-item>a').click(function(){
										var li=$(this).parent();
										li.siblings().removeClass('active');
										input.val(li.attr('data-address')+'/');
										loadList(li.addClass('active').attr('data-address')+'/',column+1);
										if(callback) callback.call(this,input.val());
									});
								if(active) thisCol.find('li[data-address$="/'+active+'"]').addClass('active');
								box.append(thisCol);
								if(box.closest('body').length) updateDisplay();
							});
					},
				initList=function(address){
						var addressSplit=address.split('/'),
							curAncestor='/';
						for(var i=0; i<addressSplit.length-1; i++){
							if(i>0) curAncestor+=addressSplit[i]+'/';
							loadList(curAncestor,i,(i+1<addressSplit.length ? addressSplit[i+1] : false));
						}
					};
			box.wrap('<div class="'+classString+'" />');
			if(val.substr(-1)!=='/') val+='/';
			initList(val==='' ? '/' : val);
			box.parent().bind('update', updateDisplay);
			if(!justReturnElement) box.parent().insertAfter(input);
			retval=box.parent();
		});
		return retval;
	};
});
