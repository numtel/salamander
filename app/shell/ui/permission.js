jQuery(function($){
	var perms=[{value:1,name:'Read',key:'r'},
				{value:2,name:'Write',key:'w'},
				{value:4,name:'Insert',key:'i'},
				{value:8,name:'Delete',key:'d'},
				{value:16,name:'Sort',key:'s'},
				{value:32,name:'Move',key:'m'},
				{value:64,name:'Owner',key:'o'},
				{value:128,name:'Permissions',key:'p'}];

	admin.initModeChoose=function(element){
		element.each(function(){
			var input=$(this).css({'display':'none'}),
				selector=$('<div class="btn-group" data-toggle="buttons-checkbox" />'),
				roles=$('#permissions').attr('data-roles');
			for(var i=0;i<perms.length;++i){
				if(roles.indexOf(perms[i].key)>-1)
					selector.append('<a class="btn" href="javascript:" data-value="'+perms[i].value+'">'+perms[i].name+'</a>');
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
});
