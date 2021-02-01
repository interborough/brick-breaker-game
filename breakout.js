//General Variables
var canvas = document.getElementById("breakoutCanvas");
var ctx = canvas.getContext("2d");
var score = 0; 
var lives = 3; 
var paused = false; 

//Ball Variables
var xPos = canvas.width / 2; 
var yPos = canvas.height - 30;
var xDist = 1.3; 
var yDist = -1.3; 
var ballRadius = 10; 

//Paddle Variables
var paddleHeight = 10; 
var paddleLength = 75; 
var paddleOffset = (canvas.width-paddleLength) / 2; 
var paddleSpeed = 4; 
var isLeft = false; 
var isRight = false; 

//Block Variables
var blockRows = 3; 
var blockCols = 5; 
var blockWidth = 75; 
var blockHeight = 20; 
var blockPadding = 10; 
var blockTopOffset = 30; 
var blockLeftOffset = 30; 
var blocks = []; 

//Saving Variables
var currSave = null;
var saveButton = document.getElementById("save-button");  

//Initialize block array.
for(var cols = 0; cols < blockCols; cols++)
{
	blocks[cols] = []; 

	for(var rows = 0; rows < blockRows; rows++)
	{
		blocks[cols][rows] = {x: 0, y: 0, isDrawn: 1}; 
	}
}

document.addEventListener("keydown", keyPressDown, false); 
document.addEventListener("keyup", keyPressUp, false); 
document.addEventListener("keypress", pauseListener, false); 

saveButton.addEventListener('click', function () 
{
	var link = document.getElementById('downloadlink');
	link.href = saveGame(getGameState());
	link.click(); 
  }, false);

function keyPressDown(event)
{
	if(event.key == "Right" || event.key == "ArrowRight" || event.key == "d")
	{
		isRight = true; 
	}
	else if(event.key == "Left" || event.key == "ArrowLeft" || event.key == "a")
	{
		isLeft = true; 
	}
}

function keyPressUp(event)
{
	if(event.key == "Right" || event.key == "ArrowRight" || event.key == "d")
	{
		isRight = false; 
	}
	else if(event.key == "Left" || event.key == "ArrowLeft" || event.key == "a")
	{
		isLeft = false; 
	}
}

function pauseListener(event)
{
	if(event.key == "p")
	{
		if(paused == false)
		{
			paused = true; 
		}
		else if(paused == true)
		{
			paused = false; 
			requestAnimationFrame(drawGame);
		}
	}
}

function detectCollision()
{
	for(var cols = 0; cols < blockCols; cols++)
	{
		for(var rows = 0; rows < blockRows; rows++)
		{
			var block = blocks[cols][rows]; 

			if(block.isDrawn == 1)
			{
				if((xPos > block.x) && (xPos < block.x + blockWidth) && (yPos > block.y) && (yPos < block.y + blockHeight))
				{
					yDist = -yDist; 
					block.isDrawn = 0;
					score++;  
				}
			}
		}
	}
}

function drawGameState()
{
	ctx.font = "16px Arial"; 
	ctx.fillStyle = "#f9f9f9";
	ctx.fillText("Score: " + score, 8, 20);
	ctx.fillText("Lives: " + lives, canvas.width - 65, 20);
}

function drawBall()
{
	ctx.beginPath();
	ctx.arc(xPos, yPos, ballRadius, 0, Math.PI * 2);
	ctx.fillStyle = "#f9f9f9";
	ctx.fill();
	ctx.closePath();
}

function drawPaddle() 
{
    ctx.beginPath();
    ctx.rect(paddleOffset, canvas.height-paddleHeight, paddleLength, paddleHeight);
    ctx.fillStyle = "#f9f9f9";
    ctx.fill();
    ctx.closePath();
}

function drawBlocks()
{
	for(var cols = 0; cols < blockCols; cols++)
	{
		for(var rows = 0; rows < blockRows; rows++)
		{
			if(blocks[cols][rows].isDrawn == 1)
			{
				var blockXPos = (cols * (blockWidth + blockPadding)) + blockLeftOffset;
				var blockYPos = (rows * (blockHeight + blockPadding)) + blockTopOffset; 
				blocks[cols][rows].x = blockXPos; 
				blocks[cols][rows].y = blockYPos;
				ctx.beginPath(); 
				ctx.rect(blockXPos, blockYPos, blockWidth, blockHeight); 
				ctx.fillStyle = "#f9f9f9";
				ctx.fill(); 
				ctx.closePath(); 
			}
		}
	}
}

function drawGame()
{
	if(!paused) {
		//Clear screen, draw gameobjects. 
		ctx.clearRect(0, 0, canvas.width, canvas.height); 
		drawBlocks(); 
		drawBall(); 
		drawPaddle();
		drawGameState(); 
		detectCollision(); 

		//If ball is hits right or left of screen, reverse its direction. 
		if(xPos + xDist > canvas.width-ballRadius || xPos + xDist < ballRadius)
		{
			xDist = -xDist;
		}

		//If ball is hits top of screen, reverse its direction. If it hits the bottom, game over.
		if(yPos + yDist < ballRadius)
		{
			yDist = -yDist; 
		}
		else if(yPos + yDist > canvas.height-ballRadius)
		{
			if(xPos > paddleOffset && xPos < paddleOffset + paddleLength)
			{
				yDist = -yDist; 
			}
			else
			{
				lives--; 
				
				if(lives == 0)
				{
					alert("Game Over!"); 
					document.location.reload(); 
				}
				else
				{
					xPos = canvas.width / 2; 
					yPos = canvas.height - 30; 
					xDist = 1.3; 
					yDist = -1.3; 
					paddleOffset = (canvas.width-paddleLength) / 2; 
				}
			}	
		}

		//If the right or left key is pressed, move the paddle. 
		if(isRight)
		{
			paddleOffset += paddleSpeed; 
			
			//Check to see if the paddle will move off the canvas.
			if(paddleOffset + paddleLength > canvas.width)
			{
				paddleOffset = canvas.width - paddleLength; 
			}
		}
		else if(isLeft)
		{
			paddleOffset -= paddleSpeed; 

			if(paddleOffset < 0)
			{
				paddleOffset = 0; 
			}
		}

		//Check if all blocks are gone. 
		if(score == blockRows * blockCols)
		{
			ctx.clearRect(0, 0, canvas.width, canvas.height); 
			alert("You Win!"); 
			document.location.reload(); 
		}

		xPos += xDist;
		yPos += yDist;
		requestAnimationFrame(drawGame);
	}
}

function getGameState()
{
	var gameState = {
		currScore: score, 
		currLives: lives, 
		paddlePos: paddleOffset, 
		ballXPos: xPos, 
		ballYPos: yPos, 
		ballxDist: xDist, 
		ballYDist: yDist, 
		blockArray: blocks,
	}; 

	var json = JSON.stringify(gameState); 
	return json; 
}

function saveGame(data)
{
	var save = new Blob([data], {type: "octet/stream"})

	if(currSave !== null)
	{
		window.URL.revokeObjectURL(currSave); 
	}

	currSave = window.URL.createObjectURL(save); 
	return currSave; 
}

function loadGame()
{
	var saveGame = document.getElementById('saveFile').files[0];

	if(saveGame == undefined)
	{
		window.alert("Please select a valid save file using the select save file button before attempting to load a game."); 
		return; 
	}

	var reader = new FileReader(); 

	reader.onload = function (e) {
		var gameSaveState = reader.result; 
		var gameSaveStateJSON = JSON.parse(gameSaveState); 
		score = gameSaveStateJSON.currScore; 
		lives = gameSaveStateJSON.currLives;
		paddleOffset = gameSaveStateJSON.paddlePos; 
		xPos = gameSaveStateJSON.ballXPos; 
		yPos = gameSaveStateJSON.ballYPos; 
		xDist = gameSaveStateJSON.ballxDist; 
		yDist = gameSaveStateJSON.ballYDist; 
		blocks = gameSaveStateJSON.blockArray; 
	  }

	reader.readAsBinaryString(saveGame);
}

drawGame(); 