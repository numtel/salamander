jQuery(function($){
	$('.cycler:not(.cycle-applied)').addClass('cycle-applied').each(function(){
		var ele=$(this),
			duration=ele.attr('data-duration') || 1000, //option
			loop=/true/i.test(ele.attr('data-loop')), //option
			slides=ele.children().addClass('cycle-slide'),
			height=0,
			updateHeight=function(e){
					setTimeout(function(){
						slides.each(function(){
							var slide=$(this),
								slideHeight=slide.outerHeight();
							if(slideHeight>height){
								height=slideHeight;
								ele.css({'height':height})
							}
						});
					},10);
				},
			setSlide=function(i,e){
					if(e!==undefined) i=e; //backwards but fuck it
					var lastActive=slides.filter('.active').removeClass('active')
									.css({'z-index':1}),
						lastIndex=lastActive.index() || 0;
					//allow values like '+1','-4', '>' (end) along with integers
					if(typeof i==="string"){
						var operator=i.substr(0,1),
							value=parseInt(i.substr(1));
						if(operator==='>') i=slides.length-1;
						else i=lastIndex+((operator==='-' ? -1 : (operator==='+' ? 1 : 0))*value);
						if(i>slides.length-1) i=loop ? 0-slides.length+i : slides.length-1;
						if(i<0) i=loop ? slides.length+i : 0;
					}
					if(operator===undefined && i<lastIndex) operator='-';
					lastActive.animate(
								{'left':(operator!=='-' ? '-' : '')+'110%'},
								{duration:duration,
								queue:true});
					var active=slides.eq(i).addClass('active').css(
									{'left':(operator!=='-' ? '' : '-')+'110%',
									'opacity':0,
									'z-index':10
								}
								).animate(
									{'left':0,'opacity':1},
									{duration:duration,
									queue:true});
					next.toggleClass('disabled',!loop && i===slides.length-1);
					prev.toggleClass('disabled',!loop && i===0);
					pager.children().removeClass('active')
						.filter('[data-index='+i+']').addClass('active');
				},
			next=$('<li class="next-wrapper">\
					<a href="javascript:" class="next-slide" title="Show Next Slide">\
					Next Slide</a></li>'),
			prev=$('<li class="prev-wrapper">\
					<a href="javascript:" class="prev-slide" title="Show Previous Slide">\
					Previous Slide</a></li>');
			pager=$('<li class="pager-wrapper"></li>');
		for(var i=0; i<slides.length; i++){
			pager.append($(
				'<a href="javascript:" class="pager-link" data-index="'+i+'"\
				 title="Show Slide '+(i+1)+'">Slide '+(i+1)+'</a>')
			.bind('click',function(){
				setSlide(parseInt($(this).attr('data-index')));
			}));
		}
		next.children().bind('click',function(){setSlide('+1');}),
		prev.children().bind('click',function(){setSlide('-1');});
		updateHeight();
		ele.find('img').bind('load',updateHeight);
		$(window).bind('resize.cycler',updateHeight);
		ele.append(next).append(prev).append(pager).bind('setSlide',setSlide);
		setSlide(0);
	});
});
