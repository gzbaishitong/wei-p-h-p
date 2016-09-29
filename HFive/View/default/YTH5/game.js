var stage,canvas;
		var c = createjs;
		var C_W,C_H;
		var loaderPercent = 0;
		var scoreNum = 0;
		var liveList = [];
		var touchX = 0;
		var touchY = 0;
		var times = 0;
		var IntervalTime = 1000;
		var itemInterval = 1000;
		var gameContainer = {};
		gameContainer.update = function(){}
		canvas = document.getElementById('cas');
		C_W = canvas.width = document.body.clientWidth*2;
		C_H = canvas.height = document.body.clientHeight*2;
		stage = new c.Stage('cas');
		createjs.Touch.enable(stage);
		runTick();

		function runTick(){
			createjs.Ticker.timingMode = createjs.Ticker.RAF;
			c.Ticker.addEventListener('tick', function(){
				stage.update()
			})
		}

		function drawLoading(){
			var manifest = [
				{src:"img/bg.jpg",id:"beginBg"},
				{src:"img/bg-button.png",id:"beginButton"},
				{src:"img/gamebg.jpg",id:"gameBg"},
				{src:"img/score.png",id:"score"},
				{src:"img/bar.png",id:"bar"},
				{src:"img/clock.png",id:"clock"},
				{src:"img/man5.png",id:"man5"},
				{src:"img/man2.png",id:"man2"},
				{src:"img/man1.png",id:"man1"},
				{src:"sea.mp3",id:"audio"},
				{src:"win.mp3",id:"win"},
				{src:"lose.mp3",id:"lose"},
			];

			loader = new c.LoadQueue(false,null,true);
			loader.installPlugin(createjs.Sound);
			loader.addEventListener('complete', handleComplete);
			loader.on("progress", handleFileProgress);
			loader.loadManifest(manifest);

			loadingContainer = new c.Container();
			loadingText = new c.Text(loaderPercent + "%",'30px Arial','red');
			loadingContainer.update = function(loaderPercent){
				this.removeChild(loadingText);
				loadingText = new c.Text(loadingPercent + "%",'30px Arial','red');
				this.addChild(loadingText);
			}
			loadingContainer.addChild(loadingText)
			stage.addChild(loadingContainer)
			loadingContainer.x = C_W/2-loadingContainer.getBounds().width/2
			loadingContainer.y = C_H/2-100
			setInterval(function(loadingPercent){
				loadingContainer.update(loadingPercent)
			},100)
		}
		

		function handleComplete(){
				startGame()
		}

		function handleFileProgress(){
			loadingPercent = loader.progress*100|0;
		}

		function startGame(){
			var instance = createjs.Sound.play("audio",createjs.Sound.INTERRUPT_ANY,0,0,-1,0.2);  // play using id.  Could also use full sourcepath or event.src.
				instance.volume = 0.4;
			c.Tween.get(loadingContainer).to({alpha:0},1000).call(function(){
				stage.removeChild(loadingContainer);
			})
			beginContainer = new c.Container();
			beginBg = new c.Bitmap(loader.getResult("beginBg"));
			scaleX = C_W/beginBg.image.width;
			scaleY = C_H/beginBg.image.height;
			beginBg.scaleX = scaleX;
			beginBg.scaleY = scaleY;
			beginButton = new c.Bitmap(loader.getResult('beginButton'));
			beginButton.regX = beginButton.getBounds().width/2;
			beginButton.scaleX = scaleX;
			beginButton.scaleY = scaleY;
			beginButton.x = C_W*0.5
			beginButton.y = C_H*0.86
			beginContainer.addChild(beginBg,beginButton);
			addevent = "addevent";
			beginButton.on('mousedown',function(event){
				event.preventDefault();
				beginGame();
			})
			stage.addChild(beginContainer)
		}

		function beginGame(){
			gameContainer = new c.Container();
			gameBg = new c.Bitmap(loader.getResult('gameBg'));
			//gameBg2 = gameBg.clone(true);
			//var blur = new createjs.BlurFilter(10,10,2);
			//var w = gameBg2.image.width;
			//var h = gameBg2.image.height;
			//gameBg2.filters = [blur];
			//gameBg2.cache(0,0,w,h);
			gameBg2 = new c.Shape();
			gameBg2.graphics.beginFill("#fff").drawRect(0,0,C_W,C_H);
			gameBg2.alpha = 0.5;
			gameBg.scaleX = scaleX;
			gameBg.scaleY = scaleY;
			gameContainer.addChild(gameBg,gameBg2)
			c.Tween.get(beginContainer).to({alpha:0},1000).call(function(){
				stage.removeChild();
				stage.addChild(gameContainer);
				setGameCount();
			})	
		}

		function setGameCount(){
			var gameCount = 3;
			gameCountNum = new c.Text(gameCount,"60px Arial","black");
			gameCountNum.regX = gameCountNum.getBounds().width/2;
			gameCountNum.regY = gameCountNum.getBounds().height/2;
			gameCountNum.x = C_W/2;
			gameCountNum.y = C_H/2
			gameContainer.addChild(gameCountNum);
			gameContainer.updateCount = function(){
				this.removeChild(gameCountNum);
				gameCount --;
				if(gameCount == 0){
					clearInterval(gameCountInterval);
					gameContainer.removeChild(gameBg2)
					playGameInit();
					//c.Tween.get(gameBg2).to({alpha:0},1000).call(function(){
						//gameContainer.removeChild(this);
						
					//})
				}else{
					gameCountNum = new c.Text(gameCount,"60px Arial","black");
					gameCountNum.regX = gameCountNum.getBounds().width/2;
					gameCountNum.regY = gameCountNum.getBounds().height/2;
					gameCountNum.x = C_W/2;
					gameCountNum.y = C_H/2
					gameContainer.addChild(gameCountNum);
				}
			}
			var gameCountInterval = setInterval(function(){
				gameContainer.updateCount();
			},1000)
		}

		function playGameInit(){
			score = new c.Bitmap(loader.getResult('score'));
			score.scaleX = scaleX;
			score.sclaeY = scaleY;
			score.x = C_W*0.68;
			score.y = C_H*0.05;
			scoreText = new c.Text(scoreNum,"30px Arial","red");
			var scoreTextX = scoreText.x = C_W*0.85;
			var scoreTextY = scoreText.y = C_H*0.058;
			gameContainer.updateScore = function(scoreNum){
				//console.log(scoreNum)
				gameContainer.removeChild(scoreText);
				scoreText = new c.Text(scoreNum,"30px Arial","red");
				scoreText.x = scoreTextX;
				scoreText.y = scoreTextY;
				gameContainer.addChild(scoreText)
			}
			bar = new c.Bitmap(loader.getResult('bar'));
			bar.scaleX = scaleX;bar.scaleY = scaleY;
			bar.x = C_W*0.58;bar.y = C_H*0.02;
			clock = new c.Bitmap(loader.getResult('clock'));
			clock.scaleX = scaleX;clock.scaleY = scaleY;clock.regX = clock.getBounds().width/2;clock.regY = clock.getBounds().height/2;
			clock.x = C_W*0.58;clock.y = C_H*0.03;
			gameContainer.addChild(score,bar,clock,scoreText);
			c.Tween.get(clock,{loop:true}).to({rotation:10},30).to({rotation:-20},60).to({rotation:0},30)
			var length = bar.getBounds().width;
			c.Tween.get(clock).to({x:clock.x+length+20},60000).call(function(){
				gameOver();
			})
			setInterval(function(){
				gameContainer.updateScore(scoreNum)
			},100)

			itemList = [{img:loader.getResult('man1'),info:2},{img:loader.getResult('man2'),info:1},{img:loader.getResult('man5'),info:1}]
			positionList = [{x:C_W*0.24,y:C_H*0.10},{x:C_W*0.55,y:C_H*0.23},{x:C_W*0.8,y:C_H*0.32},{x:C_W*0.24,y:C_H*0.35},{x:C_W*0.49,y:C_H*0.48},
			{x:C_W*0.8,y:C_H*0.58},{x:C_W*0.20,y:C_H*0.61},{x:C_W*0.48,y:C_H*0.72},{x:C_W*0.75,y:C_H*0.85}
			]
			setItemsInterval = setInterval(function(){
				times = Math.ceil(Math.random()*2);
				IntervalTime = 800 + Math.random()*800;
				for(var i = times;i--;i>=0){
					setItems()
				}
									},IntervalTime);
			test();
		}

		// create newItemsClass
		(function(){
			var newItemOrb = function(img,pos){
				this.initialize(img,pos);
			};
			var p = newItemOrb.prototype = new createjs.Bitmap();
			p.Bitmap_initialize = p.initialize;
			p.initialize = function(img,pos){
				itemInterval = 800+Math.random()*800
				this.Bitmap_initialize(img.img);
				this.regX = this.image.width/2
				this.regY = this.image.height/2
				this.x = pos.x;
				this.y = pos.y;
				var self = this
				setTimeout(function(){gameContainer.removeChild(self);},itemInterval)
				this.on('tick',function(){
					if(touchX*2 >= this.x- this.regX && touchX*2 <= this.x+this.regX){
						if(touchY*2 >= this.y-this.regY && touchY*2 <= this.y+this.regY){
							if(img.info == 1){
								scoreNum +=5;
								gameContainer.removeChild(this);
								createjs.Sound.play("win")
								this.winText(this.x,this.y);
								touchX = 0;touchY = 0;
							}
							if(img.info == 2){
								gameOver();
								gameContainer.removeChild(this);
								touchX = 0;touchY = 0;
							}
						}
					}
				})
			}
			p.winText = function(posX,posY){
				newText = new c.Text("goodJob","50px Arial","black");
				newText.regX = newText.getBounds().width/2;
				newText.regY = newText.getBounds().height/2
				newText.x = posX;
				newText.y = posY;
				gameContainer.addChild(newText)
				c.Tween.get(newText).to({y:posY-50,alpha:0},800).call(function(){
					gameContainer.removeChild(this)
				})
			}
			window.newItemOrb = newItemOrb;
		})()

		function setItems(){
			var randomItem = itemList[Math.floor(Math.random()*3)]
			var randomPos = positionList[Math.floor(Math.random()*9)]
			newItem = new newItemOrb(randomItem,randomPos);
			c.Tween.get(newItem).to({rotation:30},30).to({rotation:-30},30).to({rotation:0},30)
			gameContainer.addChild(newItem);
		}

		function gameOver(){
			touchX = 0;touchY = 0;
			createjs.Sound.stop("audio");
			createjs.Sound.play("lose")
			overContainer = new c.Container();
			overbg = new c.Shape();
			overbg.alpha = 0.5;
			overbg.graphics.beginFill("#fff").drawRect(0,0,C_W,C_H);
			overText = new c.Text("你的得分是"+scoreNum,"50px Arial","black")
			overText.regX = overText.getBounds().width/2;
			overText.x = C_W/2;overText.y = C_H*0.45;
			resetBtn = new c.Shape();
			resetBtn.graphics.beginFill('red').drawRect(0,0,C_W*0.4,C_H*0.05);
			resetBtn.regX = C_W*0.2;
			resetBtn.x = C_W/2;resetBtn.y = C_H*0.5
			resetText = new c.Text("重新开始","40px Arial","yellow");
			resetText.regX = resetText.getBounds().width/2;
			resetText.x = C_W/2;resetText.y = C_H*0.51;
			//c.Ticker.setPaused(true);
			clearInterval(setItemsInterval)
			overContainer.addChild(overbg,overText,resetBtn,resetText)
			stage.addChild(overContainer);
			resetBtn.on('mousedown',reset)
			wxshare(scoreNum);
		}
		
		function test(){
			window.addEventListener('touchmove', function(evt){
					evt.preventDefault()
					touchX = evt.targetTouches[0].pageX;
					touchY = evt.targetTouches[0].pageY;
				})
		}

		function reset(){
			scoreNum = 0;
			stage.removeChild(gameContainer);
			stage.removeChild(overContainer);
			startGame();
		}

		drawLoading();