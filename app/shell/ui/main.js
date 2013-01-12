var admin={};
admin.updateFunctions=[];
jQuery(function($){

	//add body class
	$('body').removeClass('nojs').addClass('js');
	
	admin.reloadItem=function(){
		$('#main-tree').trigger('reload').trigger('loadbrowser');
	};
	
	admin.addMessage=function(msg,error){
		$.pnotify({
			title: msg,
			type: error ? 'error' : 'success'
		});
	};
	
	admin.modal=function(template,address,id,title,callback){
		$.post(appPath+'terminal/command',
				{'action':address==='/' ? 'record_tree2/mode' : 'record_tree2/get',
				'template':appDir+'/blocks/'+template,
				'modal':'true',
				'modalId':id,
				'modalTitle':title,
				'fields[address]':address},
				function(data){
					var existing=$('#'+id);
					if(existing.length) existing.remove();
					$('body').append(data);
					$('#'+id).on('show',function(){
						if(callback!==undefined) callback.call(this);
					}).on('shown',function(){
						$(this).find('input:not([type="hidden"]),button').eq(0).focus();
					}).modal();
					
				});
	};
	
	admin.initAjaxForm=function(element,callbackDone,callbackSubmit){
		element.submit(function(e){
			if(callbackSubmit!==undefined && callbackSubmit.call(this)===false){
				e.preventDefault();
				return false;
			};
			$.post(appPath+'terminal/command',$(this).serialize(),
					function(data){
						var error=data.toLowerCase().indexOf('success')===-1;
						admin.addMessage(data,error);
						admin.reloadItem();
						if(element.hasClass('modal')) element.modal('hide');
						if(callbackDone!==undefined && callbackDone!==false) callbackDone.call(this,data);
					});
			e.preventDefault();
			return false;

		});
	};
	
	//call all the modules that need to be updated when fields change
	admin.updateFields=function(){
			for(var i=0;i<admin.updateFunctions.length;++i){
				admin.updateFunctions[i].call(this);
			};
		};
	admin.updateFields();
	
});

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
};


function bytesToSize(bytes, precision){	
	if(precision===undefined) precision=2;
	var kilobyte = 1024;
	var megabyte = kilobyte * 1024;
	var gigabyte = megabyte * 1024;
	var terabyte = gigabyte * 1024;
	
	if ((bytes >= 0) && (bytes < kilobyte)) {
		return bytes + ' B';

	} else if ((bytes >= kilobyte) && (bytes < megabyte)) {
		return (bytes / kilobyte).toFixed(precision) + ' KB';

	} else if ((bytes >= megabyte) && (bytes < gigabyte)) {
		return (bytes / megabyte).toFixed(precision) + ' MB';

	} else if ((bytes >= gigabyte) && (bytes < terabyte)) {
		return (bytes / gigabyte).toFixed(precision) + ' GB';

	} else if (bytes >= terabyte) {
		return (bytes / terabyte).toFixed(precision) + ' TB';

	} else {
		return bytes + ' B';
	}
}

