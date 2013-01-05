var nodeTools={};

nodeTools.modal=function(whichTool,address,id,title,callback,noFocus){
	$.get(nodeToolsDir+'tools',
			{'tool':whichTool,
			'modalId':id,
			'modalTitle':title,
			'address':address},
			function(data){
				var existing=$('#'+id);
				if(existing.length) existing.remove();
				$('body').append(data);
				$('#'+id).on('show',function(){
					if(callback!==undefined) callback.call(this);
				}).on('shown',function(){
					if(noFocus!==true) $(this).find('input:not([type="hidden"]),button').eq(0).focus();
				}).modal();
				nodeTools.addCheckboxFix();
			});
};
	
nodeTools.initAjaxForm=function(element,callbackDone,callbackSubmit){
	element.submit(function(e){
		if(callbackSubmit!==undefined && callbackSubmit.call(this)===false){
			e.preventDefault();
			return false;
		};
		$.post(nodeToolsDir+'tools',$(this).serialize()+'&ajax=true',
				function(data){
					var error=data.toLowerCase().indexOf('success')===-1;
					//nodeTools.addMessage(data,error);
					//nodeTools.reloadItem();
					if(element.hasClass('modal')) element.modal('hide');
					if(callbackDone!==undefined && callbackDone!==false) callbackDone.call(this,data);
				});
		e.preventDefault();
		return false;

	});
};

nodeTools.addCheckboxFix=function(){
	//add a hidden field for checkboxes so something is sent back when not checked
	$("label.field-checkbox input").not('.hidden-applied').addClass('hidden-applied').each(function(){
		$(this).after('<input name="'+this.name+'" type="hidden" value="'+(this.checked ? '1' : '0')+'" />');
		this.name='';
		$(this).change(function(){
			$(this).parent().find('input[type=hidden]').val(this.checked ? '1' : '0');
		});
	
	});
		
}

nodeTools.initTreeItemSel=function(element,classString){
	element.each(function(){
		var input=$(this),val=input.val(),
			box=$('<div class="tree-sel-wrapper clearfix" />').insertAfter(input),
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
				
							//set wrapper width
							var fullWidth=lists.length*box.children(':eq(0)').outerWidth(true);
							box.css('width',fullWidth).parent().scrollLeft(fullWidth);
							//set all heights equal
							box.children().css({'min-height':''});
							box.children().css({'min-height':box.innerHeight()});
						},
			loadList=function(address,column,active){
					//remove any lists in this column or after
					box.children().each(function(){
						if($(this).attr('data-column')*1>=column) $(this).remove();
					});
					//load children
					$.post(shellPath+'terminal/command',
						{'action':'record_tree2/get',
						'template':shellDir+'/blocks/list',
						'fields[address]':address,
						'fields[depth]':0},
						function(data){
							var thisCol=$('<div class="sel-column" data-column="'+column+'"/>');
							thisCol.html(data);
							thisCol.find('li.tree-item>a').click(function(){
									var li=$(this).parent();
									li.siblings().removeClass('active');
									input.val(li.attr('data-address')+'/');
									loadList(li.addClass('active').attr('data-address')+'/',column+1);
								});
							if(active) thisCol.find('li[data-address$="/'+active+'"]').addClass('active');
							box.append(thisCol);
							updateDisplay();
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
		initList(val==='' ? '/' : val);
	});
};

nodeTools.perms=[{value:1,name:'Read',key:'r'},
			{value:2,name:'Write',key:'w'},
			{value:4,name:'Insert',key:'i'},
			{value:8,name:'Delete',key:'d'},
			{value:16,name:'Sort',key:'s'},
			{value:32,name:'Move',key:'m'},
			{value:64,name:'Owner',key:'o'},
			{value:128,name:'Permissions',key:'p'}];

nodeTools.initModeChoose=function(element){
	element.each(function(){
		var input=$(this).css({'display':'none'}),
			selector=$('<div class="btn-group" data-toggle="buttons-checkbox" />'),
			roles=input.attr('data-mode');
		for(var i=0;i<nodeTools.perms.length;++i){
			if(roles.indexOf(nodeTools.perms[i].key)>-1)
				selector.append('<a class="btn" href="javascript:" data-value="'+nodeTools.perms[i].value+'">'+nodeTools.perms[i].name+'</a>');
		}
		selector.children().click(function(){
			setTimeout(function(){
				var total=0;
				selector.children().each(function(){
					if($(this).hasClass('active'))
						total+=$(this).attr('data-value')*1;
				});
				input.val(total);
			},1);
		});
		selector.insertBefore(input);
	});
};

nodeTools.initCKEditors=function(){
	var editors=$('textarea.ckeditor').not('.js-applied').addClass('js-applied');
	if(editors.length){
			editors.each(function(){
				var editor = CKEDITOR.instances[$(this).attr('name')];
				if (editor) { editor.destroy(true); }
			});
			editors.ckeditor(function(){
					//$.colorbox.resize();
				},{width:editors.outerWidth(), 
					height:editors.outerHeight()-62,
					toolbarCanCollapse:false,
					toolbar:[['Bold', 'Italic', 'Underline', 'Strike', 'FontSize', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'], ['JustifyLeft', 'JustifyCenter', 'JustifyRight'],[ 'Link', 'Unlink'],[ 'Source']],
					resize_enabled:false});

	};

};

nodeTools.ajaxMsg=function(data){
	var error=data.toLowerCase().indexOf('success')===-1;
	$.pnotify({
		title: data,
		type: error ? 'error' : 'success',
		history:false
	});
};

nodeTools.itemInsert=function(address){
	nodeTools.modal('insert', address, 'tool-insert-item', 'Insert Item', function(){
		var typeSelector=$('#tool-insert-item select.pattern-match');
		typeSelector.change(function(){
			$('#tool-insert-item .pattern-type').addClass('hide')
				.filter('[data-address="'+typeSelector.val()+'"]').removeClass('hide');
		}).change();
		nodeTools.initCKEditors();
		nodeTools.initAjaxForm($('#tool-insert-item'),function(data){
			nodeTools.ajaxMsg(data);
			nodeTools.refreshItem(address);
		},function(){
			$('#tool-insert-item .pattern-type.hide').remove();
		});

	});
};

nodeTools.itemEdit=function(address){
	nodeTools.modal('edit', address, 'tool-edit-item', 'Edit Item', function(){
		nodeTools.initCKEditors();
		nodeTools.initAjaxForm($('#tool-edit-item'),function(data){
			nodeTools.ajaxMsg(data);
			nodeTools.refreshItem(address);
		});
	});
};

nodeTools.itemMove=function(address){
	nodeTools.modal('move', address, 'tool-move-item', 'Move Item', function(){
		nodeTools.initAjaxForm($('#tool-move-item'),function(data){
			nodeTools.ajaxMsg(data);
		});
		$('#make-copy-not-move').change(function(){
			$('#tool-move-item input[name="action"]').val('record_tree2/'+($(this).is(':checked') ? 'copy' : 'move'));
		}).change();
		nodeTools.initTreeItemSel($('#tool-move-item .new-address'),'well span5 tree-sel')
	});
};

nodeTools.itemRename=function(address){
	nodeTools.modal('rename', address, 'tool-rename-item', 'Rename Item', function(){
		nodeTools.initAjaxForm($('#tool-rename-item'),function(data){
			nodeTools.ajaxMsg(data);
		});
	});
};
nodeTools.itemDelete=function(address){
	nodeTools.modal('delete', address, 'tool-delete-item', 'Delete Item', function(){
		nodeTools.initAjaxForm($('#tool-delete-item'),function(data){
			nodeTools.ajaxMsg(data);
			toolButton.detach().appendTo('body');
			$("li.item[data-item-address='"+address+"']").remove();

		});
	});
};
nodeTools.itemSetOwner=function(address){
	nodeTools.modal('owner', address, 'tool-item-owner', 'Set Item Owner', function(){
		nodeTools.initAjaxForm($('#tool-item-owner'),function(data){
			nodeTools.ajaxMsg(data);
		});
		$('#tool-item-owner select.select-users').chosen();
	},true);
};
nodeTools.itemSetPermission=function(address){
	nodeTools.modal('permission', address, 'tool-item-permission', 'Set Item Permission', function(){
		nodeTools.initAjaxForm($('#tool-item-permission'),function(data){
			nodeTools.ajaxMsg(data);
		});
		$('#tool-item-permission select.select-users').chosen();
		nodeTools.initModeChoose($('#tool-item-permission .select-mode'));
		$('#tool-item-permission .delete-permission a').click(function(){
			var cThis=$(this).parent(),
				cAddress=cThis.attr('data-address'),
				cAccessors=cThis.attr('data-accessors');
			$.post(nodeToolsDir+'tools',{
				'ajax':'true',
				'action':'record_tree2/chmod',
				'fields[address]':cAddress,
				'fields[mode]':'delete',
				'fields[accessors][]':cAccessors
			},
			function(data){
				var error=data.toLowerCase().indexOf('success')===-1;
				if(error===false) cThis.closest('tr').remove();
			});
		});
	},true);
};

jQuery(function($){
	//tool button handlers
	var toolButton=$('<div id="tool-dropdown-button" class="hide" />').appendTo('body'),
		tools=[
			{mode:'w',name:'itemEdit',label:'Edit Item&hellip;'},
			{mode:'i',name:'itemInsert',label:'Insert Into&hellip;'},
			{mode:'m',name:'itemMove',label:'Move or Copy&hellip;'},
			{mode:'m',name:'itemRename',label:'Rename&hellip;'},
			{mode:'d',name:'itemDelete',label:'Delete&hellip;'},
			{mode:'o',name:'itemSetOwner',label:'Set Owner&hellip;'},
			{mode:'p',name:'itemSetPermission',label:'Set Permission&hellip;'}
		];
	//build the button	
	toolButton.html('<div class="btn-group"><a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-pencil" /><span class="caret"></span></a><ul class="dropdown-menu pull-right"></ul></div>');
	for(var i=0;i<tools.length;++i){
		toolButton.find('ul').append(
			'<li data-mode="'+tools[i].mode+'">'+
			'<a data-tool="'+tools[i].name+'" href="javascript:">'+tools[i].label+'</a></li>');
		toolButton.find('a[data-tool="'+tools[i].name+'"]').click(function(){
			nodeTools[$(this).attr('data-tool')].call(this,toolButton.attr('data-item-address'));
		});
	}
	

	nodeTools.refreshItem=function(address,callback){
		$.get(document.URL,function(data){
			var replacement=$(data).find("li.item[data-item-address='"+address+"']"),
				current=$("li.item[data-item-address='"+address+"']");
			if(replacement.length===1 && current.length===1){
				toolButton.detach().appendTo('body');
				current.replaceWith(replacement);
				nodeTools.applyToolButton(replacement.parent());
				if(callback!==undefined) callback.call(replacement);
			}
		});
	};

	nodeTools.applyToolButton=function(rootElement){
		//attach the button on hover to elements that have the attribute!
		rootElement.find('[data-item-address]').mouseover(function(){
			var cItem=$(this),
				cParent=cItem.closest('ul.items-children'),
				cOff=cItem.offset(),
				cPos=cItem.css('position'),
				cRoles=cItem.attr('data-item-roles');
			//cancel out if the menu is open
			if(toolButton.find('.open').length) return false;
			//get out now if there's a deeper item hovering
			if(cItem.find('[data-item-address]:hover').length) return false;
			//set visibility of available buttons
			toolButton.find('li[data-mode]').each(function(){
				var cMenuItem=$(this),
					cMenuItemMode=cMenuItem.attr('data-mode');
				cMenuItem.toggleClass('hide', cRoles.indexOf(cMenuItemMode)===-1);
			});
			//make it sortable too!
			if(cRoles.indexOf('s')!==-1){
				cParent.sortable({
					handle: '#tool-dropdown-button, #tool-dropdown-button *',
					delay: 100,
					start: function(event, ui) {
								//ignoreTrigger=true;
							},
					update: function(event, ui) {
								$.post(nodeToolsDir+'tools','ajax=true&action=record_tree2/sort&fields[address]='+cParent.closest('li').attr('data-item-address')+'&'+cParent.sortable('serialize',{'key':'fields[data][]','attribute':'data-item-address','expression':/(.+)/}),function(data,textStatus){
									console.log(data);
								});
							}
				});
			};
			if(toolButton.find('li:not(.hide)').length>0){
				//get button ready to be placed
				cItem.attr('data-old-position',cPos).addClass('tool-hovered');
				if(cPos!=='absolute') cItem.css({'position':'relative'});
				//insert the button and show it and hide the menu
				toolButton.attr('data-item-address',cItem.attr('data-item-address'));
				toolButton.detach().appendTo(cItem).removeClass('hide');
			}
		}).mouseout(function(){
			var cItem=$(this),
				oldPos=cItem.attr('data-old-position');
			//cancel out if the menu is open
			if(toolButton.find('.open').length) return false;
			//get out now if there's a deeper item hovering
			if(cItem.find('[data-item-address]:hover').length) return false;
			//get off this item
			cItem.attr('data-old-position','').css({'position':oldPos}).removeClass('tool-hovered');
			//hide the button if it's not hovered over
			toolButton.not(':hover').addClass('hide');
		});
	};
	nodeTools.applyToolButton($('body'));
});
