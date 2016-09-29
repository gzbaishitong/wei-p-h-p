

(function(){
	var zombie;
	var box = $("#box"),
		b = {
			way:["wayOne","wayTwo","wayThree"],
			alive:[],
			index:$("#index"),
			score:$(".scoreNum"),
			gameover:$("#gameover"),
			lvTip:$("#lvTip"),
			btnLvTip:$("#btn-lvTip-close"),
			finalScore:$("#final-score"),
			bgmp3:$("#bgmp3"),
			kidmp3:$("#kidmp3"),
			zombiemp3:$("#zombiemp3"),
			losemp3:$("#losemp3")
		},
		c = {
			init:function(el,parent){
				b.lvTip.show();
				b.btnLvTip.on('click',function(){
					b.lvTip.hide();
					c.start();
				})
			},

			/*gameover:function(a){
				for(var i = 0;i<a;i++){
					console.log(zombie.num);
					}
				SCORE = b.score.html();
				toGameLoop = false;
				console.log(toGameLoop)
				b.index.hide();
				b.gameover.show();
				b.finalScore.html(SCORE);
			},*/

			start:function(){
				//设置start里的变量
				var cas,can1,lastTime,deltaTime,c_w,c_h,zombieObj,mx,my,zombie,gun;
				lastTime = Date.now();
				deltaTime = 0;

				//创建zombie对象
				zombieObj = function(){
					this.num;
					this.x = [];
					this.y = [];
					this.alive=[];
					this.speed=[];
					this.l = 0;
					this.speed = 0;
					this.type = [];
					this.boy = new Image();
					this.zombieCh = new Image();
					this.zombieEn = new Image();
					this.gameBg = new Image();
					this.pic = [];
					this.way = [];
					this.distance =[];
					this.speed = [];
				}

				//僵死对象初始化
				zombieObj.prototype.init = function(){
					this.num = 1000;//初始的僵尸数量
					this.gameBg.src = "http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/gamebg.png";
					this.type = [this.boy,this.zombieCh,this.zombieEn];
					this.boy.src = "http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/boy.png"
					this.zombieCh.src = "http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/zombieCh.png"
					this.zombieEn.src = "http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/zombieEn.png"
					for(var i = 0;i<this.num;i++){
						this.pic[i] = this.type[Math.floor(Math.random()*this.type.length)];
						this.way[i] = Math.floor(Math.random()*3);
						this.distance[i] = 150*i + Math.random()*50;
						this.speed[i] = 0.0001*i*deltaTime;
					}
				}

				zombieObj.prototype.bg= function(argument){
					/* body... */
					var pic = this.gameBg;
					ctx.drawImage(pic,0,0,c_w,c_h)
				}

				zombieObj.prototype.draw = function(){
					for(var i = 0;i < this.num;i++){
						if(!this.alive[i]){
							this.l += 0.0001*deltaTime;
							this.distance[i] -= 0.001*i*deltaTime
							ctx.drawImage(this.pic[i],-this.distance[i]+this.l+this.speed[i],(100*this.way[i])+120,100+this.way[i]*15,100+this.way[i]*15)
						}
					}
				}

				zombieObj.prototype.crush = function(argument){
					/* body... */
					for(var i=0;i<this.num;i++){
						if(!this.alive[i]){
							if(this.pic[i] != this.boy){
									if(-this.distance[i]+this.l>c_w){
										this.gameover();
										bgmp3.pause();
										losemp3.play();
									}
								}
						}
					}
				};

				zombieObj.prototype.click = function(){
					ctx.drawImage(gun,mx-50,my-25,100,50);
					for(var i=0;i<this.num;i++){
						if(!this.alive[i]){
								if(-this.distance[i]+this.l<mx && mx<-this.distance[i]+this.l+100+this.way[i]*15){
									if((100*this.way[i])+120<my && my<(100*this.way[i])+120+100+this.way[i]*15){
										this.alive[i] = true;
										if(this.pic[i] == this.boy){
											//this.boy.src = "img/boy_click.png";
											this.gameover();
											bgmp3.pause();
											kidmp3.play();
										}else if(this.pic[i] == this.zombieCh){
											//this.zombieCh.src = "img/zombieCh_click.png";
											b.score.html(parseInt(b.score.html())+1);
											SCORE = b.score.html();
											zombiemp3.play();
										}else if(this.pic[i] == this.zombieEn){
											//this.zombieEn.src = "img/zombieEn_click.png";
											b.score.html(parseInt(b.score.html())+5);
											SCORE = b.score.html();
											zombiemp3.play();
										}
										mx = NaN;my = NaN;
									}
								}
							}
					}
				}
				
				zombieObj.prototype.gameover = function(){
					for(var i=0;i<this.num;i++){
						this.alive[i] = true;
					}
					SCORE = b.score.html();
					toGameLoop = false;
					console.log(toGameLoop);
					console.log(SCORE);
					b.index.hide();
					b.gameover.show();
					b.finalScore.html(SCORE);
				}

				//初始化canvas
				function init(){
					cas = document.getElementById('cas');
					ctx = cas.getContext('2d');

					c_w = document.body.clientWidth;
					c_h = document.body.clientHeight;

					cas.width = c_w;cas.height = c_h;

					mx = NaN;my = NaN;gun = new Image();gun.src = "http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/gun.png";
					cas.addEventListener("click",function(event){
						mx = event.offsetX;
						my = event.offsetY;
					},false)

					zombie = new zombieObj();
					zombie.init();
				}

				//gameloop
				function gameLoop(){
					if(toGameLoop){
						requestAnimationFrame(gameLoop);

						var now = Date.now();
						deltaTime = now - lastTime;
						lastTime = now;
						if(deltaTime > 50) deltaTime = 50;

						//zombie.success();
						
						ctx.clearRect(0,0,c_w,c_h)
						zombie.bg();
						zombie.draw();
						zombie.click();
						zombie.crush();
					}else{return}
					
				}
				init();
				//if(toGameLoop == true){
					gameLoop();
				//}
			}

		};
		window.Game = c;
		
})()