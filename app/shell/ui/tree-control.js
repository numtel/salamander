jQuery(function($){
	$('.tree-control:not(.js-applied)').addClass('js-applied').each(function(){
		var ctrl=$(this), curItem=false,curMode=false,
			details=$('#details'),permissions=$('#permissions'),
			address=ctrl.attr('data-address'),
			addressSetActive=false,
			setAddress=function(newAddress,forceNewBrowser){
								newAddress=$.trim(newAddress);
								if(newAddress==='') newAddress='/';
								if(newAddress.length>1 && newAddress.substr(-1)==='/') 
									newAddress=newAddress.substr(0,newAddress.length-1);
								address=newAddress.length>1 ? newAddress+'/' : newAddress;
								ctrl.attr({'data-address':address, 'data-item-address':newAddress});
								ctrl.find('.address-bar .tree-address')[0].value=newAddress;
								ctrl.find('.address-bar button i')
											.addClass('icon-repeat')
											.removeClass('icon-chevron-right');
								window.location.hash='!'+newAddress;
								//flag to warn the hashchange event not to worry
								addressSetActive=true;
								setTimeout(function(){addressSetActive=false;},100);
								
								document.title=newAddress;
								if(!dataDiv.children().length || forceNewBrowser){
									dataDiv.addClass('loading');
									setTimeout(loadBrowser,100);
								}
								
								reload();
							},
			loadBrowser=function(){
							dataDiv.empty().append(admin.initTreeItemSel(
								ctrl.find('.address-bar .tree-address'),
								'well tree-sel',
								function(address){
									setAddress(address);
							},true)).removeClass('loading');
						},
			addressBar=$('<div class="form-horizontal address-bar"><div class="input-append"><input type="text" class="tree-address" placeholder="Address" value="'+address+'" /><button class="btn" type="button"><i class="icon-repeat" /></button></div></div>')
							.appendTo(ctrl)
							.find('input').keydown(function(e){
								switch(e.which){
									case 13:
										setAddress($(this).val(),true);
										return false;
									case 27:
										this.value=ctrl.attr('data-item-address');
										$(this).next().children('i')
											.addClass('icon-repeat')
											.removeClass('icon-chevron-right');
										return false;
									default:
										$(this).next().children('i')
											.removeClass('icon-repeat')
											.addClass('icon-chevron-right');
								};
							}).next().click(function(){
								setAddress($(this).parent().children('input.tree-address').val(),true);
							}).parent().parent(),
			tools=$('<div class="tree-tools btn-group" />').appendTo(ctrl),
			dataDiv=$('<div class="margin-vertical hide" id="tree-browser" />').appendTo(ctrl),
			reload=function(){
					ctrl.addClass('loading');
					var reloadChildren=function(){
								//NOTE: NO LONGER USED!, see tree-item-sel.js instead!
								//load children
								$.post(appPath+'terminal/command',
									{'action':'record_tree2/get',
									'template':appDir+'/blocks/list',
									'fields[address]':address,
									'fields[depth]':0},
									function(data){
										ctrl.removeClass('loading');
										dataDiv.html(data).find('li.tree-item>a').click(function(){
											setAddress($(this).parent().attr('data-address'));
										});
										if(curMode.roles.s){
											//enable sorting
											dataDiv.find('ul').sortable({
												cancel: '.nav-header',
												delay: 100,
												update: function(event, ui) {
													ctrl.addClass('loading');
													var itemOrderString='';
													$(this).children().each(function(){
														itemOrderString+='&fields[data][]='+$(this).attr('data-address');
													});
													$.post(appPath+'terminal/command','action=record_tree2/sort&fields[address]='+ctrl.attr('data-item-address')+itemOrderString,function(data){
															ctrl.removeClass('loading');
															if(data.toLowerCase().indexOf('success')<0) 
																admin.addMessage("Item sort failure!",true);
														});
													}
											});
										};
									});
							},
						reloadDetails=function(){
								//load item
								var itemAddress=address.substr(-1)==='/' && address.length>1 ? 
										address.substr(0,address.length-1) : address,
									itemName=address.substr(address.lastIndexOf('/')),
									curTab=$('#details>.nav-tabs>.active').index();
								$.post(appPath+'terminal/command',
									{'action':'record_tree2/get',
									'template':appDir+'/blocks/details',
									'fields[address]':itemAddress,
									'fields[depth]':itemAddress==='/' ? -1 : false},
									function(data){
										details.html(data);
										admin.initKeyValue(details);
										admin.initAjaxForm($('#add-permission'),false,function(){
											if($('.select-users').val()===null) return false;
											return true;
										});
										admin.initAjaxForm($('.delete-permission,#set-owner'));
										//keep same tab
										$('#details>.nav-tabs>li:eq('+curTab+')>a').click();
										$('#details select.select-users').chosen();
										admin.initModeChoose($('#details .select-mode'));
										//continue the chain
										//TODO:NOT!reloadChildren();
										ctrl.removeClass('loading');
									});
							},
						available=[
									{
										'title':'Up One Level (BACKSPACE)',
										'icon':'chevron-left',
										'key':'backspace',
										'available': function(roles,address){return roles['r'] && address!=='/'; },
										'click': function(){ setAddress(itemAddress.substr(0,itemAddress.lastIndexOf('/')),true); }
									},
									{
										'title':'Display Browser (ESC)',
										'icon':'folder-open',
										'key':'esc',
										'id':'toggle-display-browser',
										'available': function(roles,address){return true; },
										'click': function(){ 
											//can't use $(this) below because click can also come as document.keypress
											$('#toggle-display-browser').toggleClass('active'); 
											$('#tree-browser').toggleClass('hide');
											dataDiv.children().trigger('update');
										},
										'insert': function() {
											$(this).toggleClass('active', !$('#tree-browser').hasClass('hide'));
										}
									},
									{
										'title':'Home',
										'icon':'home',
										'available': function(roles,address){return true; },
										'click': function(){ setAddress('~',true); }
									},
									{
										'title':'Insert Into (CTRL+I)',
										'icon':'plus',
										'key':'ctrl+i',
										'available': function(roles,address){return roles['i']; },
										'click': function(){ 
											admin.modal('item-insert',itemAddress,'admin-insert-item','Insert',function(){
												admin.initKeyValue($('#insert-item-attributes'),function(){
														//form submit callback
														var form=$(this),name=form.find('input.item-name'),
															attribs=form.find('.key-value li');
														if(name.val()=='' || attribs.length<2) return false;
														return true;
													});
											}); 
										
										}
									},
									{
										'title':'Delete (CTRL+DEL)',
										'icon':'remove',
										'key':'ctrl+del',
										'available': function(roles,address){return roles['d'] && address!=='/'; },
										'click': function(){ 
											admin.modal('item-delete',itemAddress,'admin-delete','Delete',function(){
												admin.initAjaxForm($('#admin-delete'),function(data){
													if(data.toLowerCase().indexOf('success')<0) return false;
													//modal done callback, go up one level
													setAddress(itemAddress.substr(0,itemAddress.lastIndexOf('/')),true);
												});
											});
										}
									},
									{
										'title':'Rename (F2)',
										'icon':'edit',
										'key':'f2',
										'available': function(roles,address){return roles['w'] && address!=='/'; },
										'click': function(){ 
											admin.modal('item-rename',itemAddress,'admin-rename','Rename',function(){
												admin.initAjaxForm($('#admin-rename'),function(data){
													if(data.toLowerCase().indexOf('success')<0) return false;
													//modal done callback, go to new address
													setAddress(itemAddress.substr(0,itemAddress.lastIndexOf('/'))+'/'+$('#admin-rename input.new-name').val(),true);
												},function(){
													//form submit callback
													var form=$(this),name=form.find('input.new-name');
													if(name.val()=='') return false;
													return true;
												});
											});
										}
									},
									{
										'title':'Move or Copy (CTRL+M)',
										'icon':'move',
										'key':'ctrl+m',
										'available': function(roles,address){return roles['m'] && address!=='/'; },
										'click': function(){ 
											admin.modal('item-move',itemAddress,'admin-move','Move or Copy',function(){
												admin.initAjaxForm($('#admin-move'),function(data){
													if(data.toLowerCase().indexOf('success')<0) return false;
													//modal done callback, go to new address
													setAddress($('#admin-move input.new-address').val()+itemAddress.substr(itemAddress.lastIndexOf('/')+1),true);
												},function(){
													//form submit callback
													var form=$(this),name=form.find('input.new-address');
													if(name.val()=='') return false;
													return true;
												});
												admin.initTreeItemSel($('#admin-move .new-address'),'well span5 tree-sel');
												$('#make-copy-not-move').change(function(){
													$(this).closest('form').find('input[name="action"]').val('record_tree2/'+($(this).is(':checked') ? 'copy' : 'move'));
												}).change();
											
											});
										}
									}
								];

					//load this item permissions
					var itemAddress=address.substr(-1)==='/' && address.length>1 ? 
										address.substr(0,address.length-1) : address,
						itemName=address.substr(address.lastIndexOf('/'));
					$.post(appPath+'terminal/command',
								{'action':'record_tree2/get_mode',
								'fields[address]':itemAddress},
								function(data){
									var cTool;
									data=curMode=$.parseJSON(data);
									tools.find('a').tooltip('hide');
									tools.html('');
									if(itemAddress!==data['address']){
										ctrl.find('.address-bar .tree-address')[0].value=itemAddress=data['address'];
										window.location.hash='!'+itemAddress;
										document.title=itemAddress;
										address=itemAddress!=='/' ? itemAddress+'/' : '/';
										loadBrowser();
									}
									//remove shortcut keys from document
									$(document).unbind('keyup.tree-control-toolbar');
									//insert tools that this user is allowed on this item
									for(var i=0;i<available.length;++i){
										if(available[i]['available'].call(this,data['roles'],itemAddress)){
											cTool=$('<a href="javascript:" rel="tooltip" class="btn" title="'+available[i]['title']+'"><i class="icon-'+available[i]['icon']+'" /></a>');
											if(available[i]['id']!==undefined){
												cTool.attr('id',available[i]['id']);
											}
											cTool.tooltip({delay: { show: 500, hide: 100,  }, placement: 'bottom'});
											cTool.click(available[i]['click']);
											if(available[i]['key']!==undefined){
												$(document).bind('keyup.tree-control-toolbar', available[i]['key'], available[i]['click']);
											}
											tools.append(cTool);
											if(available[i]['insert']!==undefined){
												available[i]['insert'].call(cTool);
											}
										}
									}
									//continue chain of things to load
									reloadDetails();
																
								});
				};
		//construction code
		$(document).bind('keyup', 'f4', function(){
			addressBar.find('input').select().focus();
		});
		ctrl.bind('reload',reload);
		ctrl.bind('loadbrowser',loadBrowser);
		if(window.location.hash.length>1 && window.location.hash.substr(0,2)==='#!'){
			setAddress(window.location.hash.substr(2),true);
		}else{
			setAddress(ctrl.attr('data-address'),true);
		}
		$(window).hashchange(function(){
			if(!addressSetActive){
				setAddress(window.location.hash.substr(2),true);
			}
		});
		
	});
});
