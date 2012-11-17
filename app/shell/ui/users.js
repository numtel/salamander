jQuery(function($){
	admin.reloadUserPanel=function(element){
		$.get(appPath+'users/ajax-reload',function(data){
			var elementId=element.attr('id'), curUser=element.find('select.user-select').val();
			element.find('a[rel="tooltip"]').tooltip('hide');
			element.replaceWith(data);
			element=$('#'+elementId);
			admin.initUserPanel(element);
			var userSel=element.find('select.user-select');
			//change user back if still there
			if(userSel.find('option[value="'+curUser+'"]').length)
				userSel.val(curUser).trigger('liszt:updated').change();
		});
	};

	admin.initUserPanel=function(param){
		param.each(function(){
			var element=$(this);
			element.find(".signup-user-btn").click(function(){
				admin.modal('user-signup','error','signup-user','Sign Up User',function(){
					admin.initAjaxForm($('#signup-user'),function(data){
						if(data.toLowerCase().indexOf('success')<0) return false;
						admin.reloadUserPanel(element);
					},function(){
						//form submit callback
						var form=$(this),
							name=form.find('input.username'),
							pass=form.find('input.password');
						if(name.val()=='' || pass.val()=='') return false;
						return true;
					});
				});
			});
			element.find(".change-pw-btn").click(function(){
				admin.modal('user-change-pw','error','change-pw','Change Password',function(){
					$('#change-pw input.userId').val(element.find('select.user-select').val());
					admin.initAjaxForm($('#change-pw'),function(data){
						if(data.toLowerCase().indexOf('success')<0) return false;
						admin.reloadUserPanel(element);
					},function(){
						//form submit callback
						var form=$(this),
							pass=form.find('input.password');
						if(pass.val()=='') return false;
						return true;
					});
				});
			});
			element.find(".rename-user-btn").click(function(){
				admin.modal('user-rename','error','rename-user','Rename User',function(){
					$('#rename-user input.userId').val(element.find('select.user-select').val());
					admin.initAjaxForm($('#rename-user'),function(data){
						if(data.toLowerCase().indexOf('success')<0) return false;
						admin.reloadUserPanel(element);
					},function(){
						//form submit callback
						var form=$(this),
							name=form.find('input.username');
						if(name.val()=='') return false;
						return true;
					});
				});
			});
			element.find(".delete-user-btn").click(function(){
				admin.modal('user-delete','error','delete-user','Delete User',function(){
					$('#delete-user input.userId').val(element.find('select.user-select').val());
					admin.initAjaxForm($('#delete-user'),function(data){
						if(data.toLowerCase().indexOf('success')<0) return false;
						admin.reloadUserPanel(element);
					});
				});
			});
			element.find(".create-group-btn").click(function(){
				admin.modal('user-group-add','error','create-group','Create User Group',function(){
					admin.initAjaxForm($('#create-group'),function(data){
						if(data.toLowerCase().indexOf('success')<0) return false;
						admin.reloadUserPanel(element);
					},function(){
						//form submit callback
						var form=$(this),
							name=form.find('input.name');
						if(name.val()=='') return false;
						return true;
					});
				});
			});
			element.find(".delete-group-btn").click(function(){
				if($(this).hasClass('disabled')) return false;
				admin.modal('user-group-delete','error','delete-group','Delete User Group',function(){
					$('#delete-group input.groupId').val(element.find('#group-list li.active').attr('data-group-id'));
					admin.initAjaxForm($('#delete-group'),function(data){
						if(data.toLowerCase().indexOf('success')<0) return false;
						admin.reloadUserPanel(element);
					});
				});
			});
			element.find(".rename-group-btn").click(function(){
				if($(this).hasClass('disabled')) return false;
				admin.modal('user-group-rename','error','rename-group','Rename User Group',function(){
					$('#rename-group input.groupId').val(element.find('#group-list li.active').attr('data-group-id'));
					admin.initAjaxForm($('#rename-group'),function(data){
						if(data.toLowerCase().indexOf('success')<0) return false;
						admin.reloadUserPanel(element);
					},function(){
						//form submit callback
						var form=$(this),
							name=form.find('input.name');
						if(name.val()=='') return false;
						return true;
					});
				});
			});
			element.find(".associate-btn").click(function(){
				if($(this).hasClass('disabled')) return false;
				$.post(appPath+'terminal/command',
								{'action':'record_group/associate',
								'fields[table]':'users',
								'fields[group][]':element.find('#group-list li.active').attr('data-group-id'),
								'fields[id][]':element.find('select.user-select').val()},function(data){
						var error=false;
						if(data.toLowerCase().indexOf('success')<0) error=true
						admin.addMessage(data,error);
						admin.reloadUserPanel(element);
					});
			});
			element.find(".disassociate-btn").click(function(){
				if($(this).hasClass('disabled')) return false;
				$.post(appPath+'terminal/command',
								{'action':'record_group/disassociate',
								'fields[table]':'users',
								'fields[group][]':element.find('#user-details li.active a').attr('data-group-id'),
								'fields[id][]':element.find('select.user-select').val()},function(data){
						var error=false;
						if(data.toLowerCase().indexOf('success')<0) error=true
						admin.addMessage(data,error);
						admin.reloadUserPanel(element);
					});
			});
			
			element.find('li a.select-group').click(function(){
				var selGroup=$(this).parent().addClass('active');
				selGroup.siblings().removeClass('active');
				element.find('#group-controls .delete-group-btn').removeClass('disabled');
				element.find('#group-controls .rename-group-btn').removeClass('disabled');
				//only allow adding user to group if not already in group
				element.find('#group-controls .associate-btn').toggleClass('disabled',
					element.find('#user-details .user-group[data-group-id="'+selGroup.attr('data-group-id')+'"]').length!==0);
			});
		
			element.find('select.user-select').chosen().change(function(){
				var item=$(this),
					groups=item.find('option[value="'+item.val()+'"]').attr('data-groups').split(','),
					groupHtml='',
					userDetails=element.find('#user-details');
				if(groups[0]!==''){
					for(var i=0;i<groups.length;++i){
						groupHtml+='<li><a href="javascript:" class="user-group" data-group-id="'+groups[i]+'"><i class="icon-cog" />'+
										element.find('#group-list li[data-group-id="'+groups[i]+'"]').attr('data-name')
									+'</a></li>';
					};
					userDetails.html('<div class="well span5 no-margin-left"><ul class="nav nav-list"></ul></div>');
					userDetails.find('ul').html(groupHtml);
					userDetails.find('li a.user-group').click(function(){
						var userGroup=$(this).parent().addClass('active');
						userGroup.siblings().removeClass('active');
						element.find('#user-controls .disassociate-btn').removeClass('disabled');
					});
				}else{
					userDetails.html('<div class="alert alert-info">No groups for this user.</div>');
				};
				element.find('#user-controls .disassociate-btn').addClass('disabled');
			}).change();
			//element.find('a[rel="tooltip"]').tooltip({delay: { show: 500, hide: 100 }, placement:'bottom'});
		});
	};

	admin.initUserPanel($("#users"));
});
