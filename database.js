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
    success: function(response) {
      alert(response); 
    }
  });
}
  
function loadFromDatabase() {
  $.ajax({
    url: 'load.php',
    type: 'GET',
    success: function(data) {
      try {
        data = JSON.parse(data);
        score = data["score"]; 
        lives = data["lives"]; 
        blocks = data["blocks"]; 
        alert("Load Successful!");
      }
      catch {alert(data)}
    }
  });
}