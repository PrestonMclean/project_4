<?php

include ('inc/Phrase.php');
include ('inc/Game.php');

session_start();

//if the game has been reset or just started
if (isset($_POST['reset']) || (isset($_POST['start']))) {
	//reset the session variables
	$_SESSION['phrase'] = null;
	$_SESSION['selected'] = [];
	$_SESSION['game'] = null;

	//if a phrase has been submitted
  if (!empty($_POST['phrase'])) {
		//make a new instance of the Phrase class with the
		//submitted phrase, and put it into the session phrase
    $_SESSION['phrase'] = new Phrase($_POST['phrase']);
  } else {
		//make a new instance of the Phrase class,
		//and put it into the session phrase
    $_SESSION['phrase'] = new Phrase();
  }
	//make a new instance of the Game class
	//with the session phrase, and put it into the session game
  $_SESSION['game'] = new Game($_SESSION['phrase']);
}

//if a key has been submited and it is not in the session selected array
if (!empty($_POST['key']) && !(in_array($_POST['key'], $_SESSION['selected']))) {
	//put that key into the selected array
	array_push($_SESSION['selected'], $_POST['key']);
	//update the selected array in phrase though the session game
	$_SESSION['game']->getPhrase()->updateSelected($_SESSION['selected']);
	//set how many lives are left
	$_SESSION['game']->setLives();
} else {
	$_POST['key'] = '';
}

require_once('inc/header.php');

?>
    <div class="main-container">
        <div id="banner" class="section row">
          <div id="phraseInput" class="col">
            <?php echo ($_SESSION['game']->displayScore());?>
          </div>
            <h2 id="title" class="header col">Phrase Hunter</h2>
        </div>
        <?php
					//if the game is not over
          if (!($_SESSION['game']->gameOver())) {
            echo '<div id="phrase">';
    		    echo ($_SESSION['game']->getPhrase()->addPhraseToDisplay());
            echo '</div>';
    		    echo ($_SESSION['game']->displayKeyboard());
          } else {
            echo ($_SESSION['game']->gameOver());
            echo '<form class="" action="play.php" method="post">';
							echo '<input id="phraseInput" type="text" name="phrase" value="">';
							echo '<input id="btn__reset" class="btn__reset" type="submit" name="reset" value="reset">';
						echo '</form>';
          }
    		?>

    </div>

    <script>
			//add a event listener to the document for keypress
	    document.addEventListener('keypress', function(event) {
				//if an element exsists with id of the key
	      if (document.getElementById(event.key)) {
				//set the value of the element with id of name to the key
	      document.getElementById("name").value = event.key;
				//submit the form with id of myform
	      document.getElementById("letterInput").submit();
	    }
		  });

		</script>

	</body>
</html>
