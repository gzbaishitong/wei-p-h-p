define(['jquery'],function($){
	return {
		promtNormal:function(img,name,text){
			if($("#promtNormal")){
				$("#promtNormal").remove();
			}
			$("body").append("<section id='promtNormal'><div class='main-container'></div><div class='submit-btn'>关闭</div></seciton>")
			$(".main-container").append("<div class='portrait'></div><div class='name'></div><div class='line'></div>")
			$(".main-container").append("<div class='text'></div>");
			$(".portrait").append("<img src="+img+" style='width:100%'>")
			$(".name").html(name)
			$("#promtNormal").fadeIn("fast");
			$(".text").html(text)
			$(".submit-btn").click(function(){
				$('#promtNormal').fadeOut("fast")
			})
		}
	}
})