new function($) {
  $.fn.setCursorPosition = function(pos) {
    if ($(this).get(0).setSelectionRange) {
      $(this).get(0).setSelectionRange(pos, pos);
    } else if ($(this).get(0).createTextRange) {
      var range = $(this).get(0).createTextRange();
      range.collapse(true);
      range.moveEnd('character', pos);
      range.moveStart('character', pos);
      range.select();
    }
  }
}(jQuery);

jQuery(function($){
	var term=$("#terminal"),
		promptVal='> ',
		commands=[],
		cCommand=false,
		promptPos=0,
		trunk='',
		pauseInput=false,
		displayStats=false;
	if(term.length){
		var prompt=function(){
						promptPos=term.val().length+promptVal.length;
						write(promptVal,false);
						pauseInput=false;
					},
			write=function(str,wrap){
						if(wrap===undefined) wrap='\n';
						else if(wrap===false) wrap='';
						term.val(term.val()+wrap+str+wrap);
						term.outerHeight($(window).height()-120 < term[0].scrollHeight ? 
											$(window).height()-120 : term[0].scrollHeight);
						term[0].scrollTop=term[0].scrollHeight;
						$('body')[0].scrollTop=$('body')[0].scrollHeight;
					};
		term.keyup(function(e){
			if(pauseInput===true) return false;
			var val=term.val(), nl='\n'.length;
			//console.log(e.which);
			if(e.which===13){
				var lastLine=val.substr(promptPos);
				commands.push(lastLine);
				cCommand=false;
				if(lastLine==='clear'){
					term.val('');
					prompt();
				}else if(lastLine==='toggleStats'){
					displayStats=!displayStats;
					write('Stats: '+(displayStats ? 'On' : 'Off'));
					prompt();
				}else{
					//write(nl);
					pauseInput=true;
					var cmd=$.post(appPath+'terminal/command',{'action':'admin_terminal/command',
									'fields[command]':lastLine},function(data){
										write(data);
										if(displayStats){
											var headers=cmd.getAllResponseHeaders().split('\n');
											for(var i=0;i<headers.length;++i){
												var headerName=headers[i].substr(0,headers[i].indexOf(':')),
													headerValue=headers[i].substr(headers[i].indexOf(':')+2);
												if(headerName==='DB-Count') write('^ QUERY:'+headerValue+'  ',false);
												if(headerName==='Memory-Usage') write('MEM:'+bytesToSize(headerValue)+' ',false);
											}
										}
										prompt();
									});
				}
				
			};
		}).keydown(function(e){
			if(pauseInput===true) return false;
			var val=term.val(), nl='\n'.length;
			trunk=val.substr(0,promptPos);
			if(e.which===8){
				//backspace
				if(val.length===promptPos){
					return false;
				};
			} else if(e.which===13){
				//return
				return false;
			}else if(e.which===35){
				//end key
				term.setCursorPosition(val.length);
				return false;
			}else if(e.which===36){
				//home key
				term.setCursorPosition(promptPos);
				return false;
			} else if(e.which===38){
				//up arrow
				if(cCommand===false) cCommand=commands.length;
				if(commands.length && cCommand>0){
					--cCommand;
					term.val(trunk+commands[cCommand]);
				};
				return false;
			} else if(e.which===40){
				//down arrow
				if(commands.length && cCommand!==false){
					++cCommand;
					if(cCommand>commands.length-1){
						cCommand=false;
						term.val(trunk);
					}else{
						term.val(trunk+commands[cCommand]);
					}
				};
				return false;
			
			};
		}).select(function(e){
			console.log(e);
		});
		//get previous history, if any
		$.post(appPath+'terminal/command',{'action':'admin_terminal/getHistory','fields[na]':'musthaveone'},function(data){
							if(Object.prototype.toString.call( data ) === '[object Array]') commands=data;
						},'json');
		//load terminal
		term.focus();
		write("Salamander PHP Terminal");
		write("Input 'echo $this->help;' for more information.");
		prompt();
	};
});
