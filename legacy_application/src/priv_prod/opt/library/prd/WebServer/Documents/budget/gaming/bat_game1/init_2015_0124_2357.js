var context
var queue;
var WIDTH = 1024;
var HEIGHT = 768;
var mouseXPosition;
var mouseYPosition;
//hello world
var batImage;
var stage;
var animation;
var deathAnimation;
var spriteSheet;
var enemyXPos=100;
var enemyYPos=100;
var enemyXSpeed = 1.5;
var enemyYSpeed = 1.75;
var score = 0;
var scoreText;
var gameTimer;
var gameTime = 0;
var timerText;

window.onload = function()
{
    /*
     *      Set up the Canvas with Size and height
     *
     */
	 
	 // var canvas is established (initial variable designates id=myCanvas as "drawing area")

	 var canvas = document.getElementById('myCanvas');
	 //canvas.getContext(contextType,contextAttributes);
	// VARIABLE context = VARIABLE canvas +  "2 dimensional Object"
	// A 2 dimensional Object provides "methods & properties" for drawing on the canvas
    var context = canvas.getContext('2d');
	//The canvas DOM element has .height and .width properties
    //VARIABLE context = 2 dimensional Object with a Width of 1024 and Height of 768 & will be "drawn" in ID=myCanvas	
    context.canvas.width = WIDTH;
    context.canvas.height = HEIGHT;
	
	//"createjs Library" src="http://code.createjs.com/createjs-2013.12.12.min.js" provides a "Stage" Class
	//"Stage" Class provides "Methods", "Properties", and "Events"
	
	//VARIABLE "stage" is created using the "Stage" Class + "HTML" Object = Stage("myCanvas")
	
	 stage = new createjs.Stage("myCanvas");

    /*
     *      Set up the Asset Queue and load sounds
     *
     */
	 
	 //The LoadQueue class is the main API for preloading content
	 //LoadQueue is a load manager, which can preload either a single file, or queue of files
	 
	 //VARIABLE "queue" is created using the "LoadQueue" Class
	 //LoadQueue argument is set to false because Load Assets are local and not downloaded via AJAX
	 //this is considered "tag based" loading
    queue = new createjs.LoadQueue(false);
	
    queue.installPlugin(createjs.Sound);
	//queue "complete" event.  The whole queue is Loaded & we are going to run a FUNCTION called "queueLoaded"
    queue.on("complete", queueLoaded, this);
	//On the Sound OBJECT we are setting an alternative extension ogg.  Not all browsers play mp3 files
    createjs.Sound.alternateExtensions = ["ogg"];

    /*
     *      Create a load manifest for all assets
     *
     */
	 
	 //Set the "Manifest of Items" that are going to be Loaded
	 //Each one is given an ID and paired with a SOURCE
    queue.loadManifest([
        {id: 'backgroundImage', src: 'assets/background.png'},
        {id: 'crossHair', src: 'assets/crosshair.png'},
        {id: 'shot', src: 'assets/shot.mp3'},
        {id: 'background', src: 'assets/countryside.mp3'},
        {id: 'gameOverSound', src: 'assets/gameOver.wav'},
        {id: 'tick', src: 'assets/tick.mp3'},
        {id: 'deathSound', src: 'assets/die.mp3'},
        {id: 'batSpritesheet', src: 'assets/batSpritesheet.png'},
        {id: 'batDeath', src: 'assets/batDeath.png'},
    ]);
	//loads all items in manifest so they are "immediately available"
    queue.load();

    /*
     *      Create a timer that updates once per second
     *
     */
	 
	 //gameTimer OBJECT Updates every 1000 milliseconds 
	 //
    gameTimer = setInterval(updateTime, 1000);

}
//Taking all the objects in the queue and setting them up on the screen
function queueLoaded(event)
{
    // Add background image
	// Creates Bitmap Object and references it with background image
    var backgroundImage = new createjs.Bitmap(queue.getResult("backgroundImage"))
	// physically displays the background Image to the "stage"
    stage.addChild(backgroundImage);

    //Add Score
	
	//Create a "scoreText" Object (createjs.Text is for Bitmap text)
	
    scoreText = new createjs.Text("Score: " + score.toString(), "36px Arial", "#FFF");
    scoreText.x = 10;
    scoreText.y = 10;
    stage.addChild(scoreText);

    //Ad Timer
    timerText = new createjs.Text("Time: " + gameTime.toString(), "36px Arial", "#FFF");
    timerText.x = 800;
    timerText.y = 10;
    stage.addChild(timerText);

    // Play background sound
    //createjs.Sound.play("background", {loop: -1});

    // Create bat spritesheet
    spriteSheet = new createjs.SpriteSheet({
        "images": [queue.getResult('batSpritesheet')],
        "frames": {"width": 198, "height": 117},
        "animations": { "flap": [0,4] }
    });

    // Create bat death spritesheet
    batDeathSpriteSheet = new createjs.SpriteSheet({
    	"images": [queue.getResult('batDeath')],
    	"frames": {"width": 198, "height" : 148},
    	"animations": {"die": [0,7, false,1 ] }
    });

    // Create bat sprite
    createEnemy();

    // Create crosshair
    crossHair = new createjs.Bitmap(queue.getResult("crossHair"));
    stage.addChild(crossHair);

    // Add ticker
	
    createjs.Ticker.setFPS(15);
    createjs.Ticker.addEventListener('tick', stage);
    createjs.Ticker.addEventListener('tick', tickEvent);

    // Set up events AFTER the game is loaded
    window.onmousemove = handleMouseMove;
    window.onmousedown = handleMouseDown;
}

function createEnemy()
{
	animation = new createjs.Sprite(spriteSheet, "flap");
    animation.regX = 99;
    animation.regY = 58;
    animation.x = enemyXPos;
    animation.y = enemyYPos;
    animation.gotoAndPlay("flap");
    stage.addChildAt(animation,1);
}

function batDeath()
{
	deathAnimation = new createjs.Sprite(batDeathSpriteSheet, "die");
  deathAnimation.regX = 99;
  deathAnimation.regY = 58;
  deathAnimation.x = enemyXPos;
  deathAnimation.y = enemyYPos;
  deathAnimation.gotoAndPlay("die");
  stage.addChild(deathAnimation);
}

function tickEvent()
{
	//Make sure enemy bat is within game boundaries and move enemy Bat
	if(enemyXPos < WIDTH && enemyXPos > 0)
	{
		enemyXPos += enemyXSpeed;
	} else 
	{
		enemyXSpeed = enemyXSpeed * (-1);
		enemyXPos += enemyXSpeed;
	}
	if(enemyYPos < HEIGHT && enemyYPos > 0)
	{
		enemyYPos += enemyYSpeed;
	} else
	{
		enemyYSpeed = enemyYSpeed * (-1);
		enemyYPos += enemyYSpeed;
	}

	animation.x = enemyXPos;
	animation.y = enemyYPos;

	
}


function handleMouseMove(event)
{
    //Offset the position by 45 pixels so mouse is in center of crosshair
    crossHair.x = event.clientX-45;
    crossHair.y = event.clientY-45;
}

function handleMouseDown(event)
{
    
   //Play Gunshot sound
    createjs.Sound.play("shot");

    //Increase speed of enemy slightly
    enemyXSpeed *= 1.05;
    enemyYSpeed *= 1.06;

    //Obtain Shot position
    var shotX = Math.round(event.clientX);
    var shotY = Math.round(event.clientY);
    var spriteX = Math.round(animation.x);
    var spriteY = Math.round(animation.y);

    // Compute the X and Y distance using absolte value
    var distX = Math.abs(shotX - spriteX);
    var distY = Math.abs(shotY - spriteY);

    // Anywhere in the body or head is a hit - but not the wings
    if(distX < 30 && distY < 59 )
    {
    	//Hit
    	stage.removeChild(animation);
    	batDeath();
    	score += 100;
    	scoreText.text = "1UP: " + score.toString();
    	createjs.Sound.play("deathSound");
    	
        //Make it harder next time
    	enemyYSpeed *= 1.25;
    	enemyXSpeed *= 1.3;

    	//Create new enemy
    	var timeToCreate = Math.floor((Math.random()*3500)+1);
	    setTimeout(createEnemy,timeToCreate);

    } else
    {
    	//Miss
    	score -= 10;
    	scoreText.text = "1UP: " + score.toString();

    }
}

function updateTime()
{
	gameTime += 1;
	if(gameTime > 60)
	{
		//End Game and Clean up
		timerText.text = "GAME OVER";
		stage.removeChild(animation);
		stage.removeChild(crossHair);
		var si =createjs.Sound.play("gameOverSound");
		clearInterval(gameTimer);
	}
	else
	{
		timerText.text = "Time: " + gameTime
    //createjs.Sound.play("tick");
	}
}
