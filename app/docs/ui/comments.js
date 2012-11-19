jQuery(function($){
	var func=$('ul.items>.function');
	
	nodeTools.insertCommentForm=function(){
		var form=$('<form method="post" />')
				.html(
					'<div class="title">Post a Comment/Question</div>'+
					'<textarea name="fields[data][comment-#RAND#][comment]"></textarea>'+
					'<input type="hidden" name="action" value="record_tree2/insert" />'+
					'<input type="hidden" name="fields[address]" value="'+func.attr('data-item-address')+'/" />'+
					'<input type="hidden" name="fields[data][comment-#RAND#][pattern:match]" value="'+func.attr('data-pattern-match')+'/comment" />'+
					'<button type="submit" class="btn">Submit</button>')
				.wrap('<li class="comment-form" />'),
			cFunc=$(this),
			comments=cFunc.find('li.item.comment');
			
		
		if(comments.length){
			comments.eq(0).before(form.parent());
		}else{
			var comments=cFunc.children('.items-children');
			if(comments.length===0){
				cFunc.append('<ul class="items-children" />');
				comments=cFunc.children('.items-children');
			}
			comments.append(form.parent());
		}
		
		nodeTools.initAjaxForm(form,function(data){
			nodeTools.ajaxMsg(data);
			nodeTools.refreshItem(cFunc.attr('data-item-address'),function(){
				nodeTools.insertCommentForm.call(this);
			});
		});
	};
		
	func.each(nodeTools.insertCommentForm);
});
