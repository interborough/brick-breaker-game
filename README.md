# Brick Breaker Game
A website that allows the user to play a brick breaker clone. Created using HTML, CSS, Javascript, jQuery, PHP, and MySQL. Currently this website is not deployed anywhere. 

## How to Play
The goal of the game is to destroy all of the bricks that are on screen. Using the left and right arrow keys (or the "W" and "D" keys), you are able to move the paddle left and right across the screen. Hit the ball with the paddle and try to get the ball to hit the bricks. After all the bricks are destroyed, a message will be displayed stating that you've won. 

## Saving and Loading
This website contains two methods to save and load a game in progress - by using a file, or by using a database. The file method does not require an account, while the database method does. Additionally, you can only have one game saved to the database at a time, while you can have an infinite number of file saves. 

- To save to a file, click the "Save Game to File" button, and a JSON file will be generated.  
- To load from a file file, click on the "Select Save File" button, and select the generated JSON save file. Then, click on the "Load Game From File" button to load the save. 
- To save to the database, you must first login to your account. Next, click on the "Save Game to Database" button. 
- To load from the database, you must first be logged in. Next, click on the "Load Game in Database" button. 

## Registration and Login
- To register for an account, go to the "Account" drop down tab on the navigation bar. Then, click on the "Register" menu item. Enter in a suitable username and password, and click on the register button. 
- To login to your account, go to the "Account" drop down tab on the navigation bar. Then, click on the "Login" menu item. Enter in the same username and password that you registered with, and then click on the "Login" button. 
