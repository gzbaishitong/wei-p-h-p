// 资源加载完毕的回调函数
	var callback = function(){
		document.getElementById('loading').style.display = 'none';
	}
	//图片加载函数
	var imgdefereds=['http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/begin.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/page1.jpg',
	'http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/page2.jpg','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/1.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/2.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/3.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/4.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/5.png',
	'http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/defaultwords.png'];
	$('img').each(function(){
		 var dfd=$.Deferred();
		 $(this).bind('load',function(){
		  dfd.resolve();
		 }).bind('error',function(){
		 //图片加载错误，加入错误处理
		 // dfd.resolve();
		 })
	 if(this.complete) setTimeout(function(){
		  dfd.resolve();
		 },1000);
		 imgdefereds.push(dfd);
		})
	$.when.apply(null,imgdefereds).done(function(){
		    callback();
		});