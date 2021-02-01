function saveToServer() {
  gamestate = {
    "currScore": score, 
    "currLives": lives, 
    "paddlePos": paddleOffset, 
    "ballXPos": xPos, 
    "ballYPos": yPos, 
    "ballxDist": xDist, 
    "ballYDist": yDist, 
    "blockArray": blocks,
  };  
            
  $.ajax({
    url: 'save.php',
    type: 'POST',
    data: {"gamestate" : gamestate},
  });
}
  
function loadFromDatabase() {
  $.get("load.php", function(data) {
      try {
        data = JSON.parse(data);
        score = data["score"]; 
        lives = data["lives"]; 
        blocks = data["blocks"]; 
      }
      catch {}
  }); 
}