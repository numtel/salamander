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
								thisCol.find('li.tree-item>a').click(itemClick);
								if(active) thisCol.find('li[data-address$="/'+active+'"]').addClass('active');
								
								box.append(thisCol);
								val=input.val();
								if(val.substr(-1)!=='/') val+='/';
								box.find('li[data-address="'+val.substr(0,val.length-1)+'"]').addClass('focused');
								if(box.closest('body').length) updateDisplay();
							});
					},
				itemClick=function(){
						var li=$(this);
						//move up if the <a> is passed
						if(!li.hasClass('tree-item')) li=li.parent();
						box.find('.tree-item.focused').removeClass('focused');
						li.siblings().removeClass('active focused');
						var newAddr=li.addClass('active focused').attr('data-address')+'/',
							columns=newAddr.split('/').length-2;
						loadList(newAddr,columns);
						input.val(newAddr);
						if(callback) callback.call(this,newAddr);
					},
				initList=function(address){
						var addressSplit=address.split('/'),
							curAncestor='/';
						for(var i=0; i<addressSplit.length-1; i++){
							if(i>0) curAncestor+=addressSplit[i]+'/';
							loadList(curAncestor,i,(i+1<addressSplit.length ? addressSplit[i+1] : false));
						}
						
					},
				jumpToRoot=function(){
						box.find('li.tree-item.active').removeClass('active');
						box.find('li.tree-item.focused').removeClass('focused');
						box.children().each(function(){
							if($(this).attr('data-column')*1>=1) $(this).remove();
						});
						input.val('/');
						if(callback) callback.call(this,'/');
					};
			box.wrap('<div class="'+classString+'" />');
			if(val.substr(-1)!=='/') val+='/';
			initList(val==='' ? '/' : val);
			box.parent().bind('update', updateDisplay);
			if(!justReturnElement) box.parent().insertAfter(input);
			retval=box.parent();
			
			input.unbind('keydown.tree-item-sel');
			input.bind('keydown.tree-item-sel','left',function(e){
				e.preventDefault();
				if(this.value!=='/'){
					var parentItem=box.find('li.tree-item.focused').closest('.sel-column').prev().find('li.tree-item.active');
					if(parentItem.length===0) jumpToRoot();
					else itemClick.call(parentItem);
				}
				return false;
			}).bind('keydown.tree-item-sel','down',function(e){
				e.preventDefault();
				if(this.value==='/'){
					var nextItem=box.find('li.tree-item:first-child');
				}else{
					var nextItem=box.find('li.tree-item.focused').next();
					if(nextItem.length===0) nextItem=box.find('li.tree-item.focused').parent().children('.tree-item').first();
				}
				if(nextItem.length) itemClick.call(nextItem);
				return false;
			}).bind('keydown.tree-item-sel','up',function(e){
				e.preventDefault();
				if(this.value==='/'){
					var prevItem=box.find('li.tree-item:last-child');
				}else{
					var prevItem=box.find('li.tree-item.focused').prev();
					if(prevItem.length===0) prevItem=box.find('li.tree-item.focused').parent().children('.tree-item').last();
				}
				if(prevItem.length) itemClick.call(prevItem);
				return false;
			}).bind('keydown.tree-item-sel','right',function(e){
				e.preventDefault();
				if(this.value==='/'){
					var childItem=box.find('li.tree-item:first-child');
				}else{
					var childItem=box.find('li.tree-item.focused').closest('.sel-column').next().find('li.tree-item:first-child');
				}
				if(childItem.length) itemClick.call(childItem);
				return false;
			}).bind('keydown.tree-item-sel','end',function(e){
				e.preventDefault();
				if(this.value==='/'){
					var lastItem=box.find('li.tree-item:last-child');
				}else{
					var lastItem=box.find('li.tree-item.focused').parent().children('.tree-item').last();
				}
				if(lastItem.length) itemClick.call(lastItem);
				return false;
			}).bind('keydown.tree-item-sel','home',function(e){
				e.preventDefault();
				if(this.value==='/'){
					var firstItem=box.find('li.tree-item:first-child');
				}else{
					var firstItem=box.find('li.tree-item.focused').parent().children('.tree-item').first();
				}
				if(firstItem.length) itemClick.call(firstItem);
				return false;
			});
		});
		return retval;
	};
});
