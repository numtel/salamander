jQuery(function($){
	//ex:%p.scroll-pos.scroll-pos-bottom{:data-min-scroll=>"-1%",:data-max-scroll=>"100%",:data-formula-y=>"-0.1*t",:data-relative=>"#footer"}
	$(document).scroll(function(e){
		var sP=$(document).scrollTop();
		$('.scroll-pos').each(function(){
			var ele=$(this),
				rel=$(ele.attr('data-relative'));
				relOffset=rel.offset(),
				elePercentToDocPx=function(val){return relOffset.top+(rel.outerHeight()*(parseInt(val)/100));},
				minEvent=elePercentToDocPx(ele.attr('data-min-scroll')),
				maxEvent=elePercentToDocPx(ele.attr('data-max-scroll')),
				winHeight=window.innerHeight || $(window).innerHeight();
			if(minEvent<sP+winHeight && maxEvent>sP){
				var xFormula=ele.attr('data-formula-x'),
					yFormula=ele.attr('data-formula-y'),
					css={},
					t=sP-relOffset.top;
				if(xFormula && ele.hasClass('scroll-pos-right')) css['right']=eval(xFormula);
				else if(xFormula) css['left']=eval(xFormula);
				if(yFormula && ele.hasClass('scroll-pos-bottom')) css['bottom']=eval(yFormula);
				else if(yFormula) css['top']=eval(yFormula);
				ele.css(css);
			}
			rel.css('z-index',relOffset.top<sP+winHeight && relOffset.top+rel.outerHeight()>sP ? '' : 1);
		});
	}).scroll();

});
