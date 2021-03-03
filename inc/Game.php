<?php

class Game
{
  private $phrase;
  private $lives;
  private $keybord;

  function __construct($phrase)
  {
    $this->phrase = $phrase;
    $this->lives = 5;
    $this->keybord =
      [
        ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p'],
        ['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l'],
        ['z', 'x', 'c', 'v', 'b', 'n', 'm']
      ];
  }

  public function getPhrase()
  {
    return $this->phrase;
  }

  public function setLives()
  {
    $numberIncorrect = 5;
    foreach ($this->keybord as $keyrow) {
      foreach ($keyrow as $key) {
        if (in_array($key, $this->phrase->getSelected())) {
          if (!$this->phrase->checkletter($key)){
            //subtract 1 from numberIncorrect for every incorrect guess
            $numberIncorrect -= 1;
          }
        }
      }
    }
    //if a new incorrect answer has been submitted
    if ($numberIncorrect < $this->lives) {
      //subtract one from lives
      --$this->lives;
    }
  }

  public function checkForWin()
  {
    // check to see if all the letters have been selected
    if (!preg_match( '/hide letter/i', $this->phrase->addPhraseToDisplay())) {
      return true;
    } else {
      return false;
    }
  }

  public function checkForLose()
  {
    //set lives to the latest value
    $this->setLives();
    if ($this->lives <= 0) {
      return true;
    } else {
      return false;
    }
  }

  public function gameOver()
  {
    if ($this->checkForWin()) {
      $output = '<h2 class="win">YOU WIN</h2>';
      $output .= $this->phrase->showFullPhrase();
      return $output;
    } elseif ($this->checkForLose()) {
      $output = '<h2 class="lose">YOU LOSE</h2>';
      $output .= $this->phrase->showFullPhrase();
      return $output;
    } else {
      return false;
    }
  }

  public function displayKeyboard()
  {
    $output = '<form id="letterInput" action="play.php" method="post">';
    $output .= '<input id="name" type="hidden" name="key" value="">';
      $output .= '<div id="qwerty" class="section">';
      //go through all the rows
      foreach ($this->keybord as $keyrow) {
        $output .= '<div class="keyrow">';
        //go thorugh all the keys on that row
        foreach ($keyrow as $key) {
          //if the key has been selected
          if (in_array($key, $this->phrase->getSelected())) {
            //if the key is correct
            if ($this->phrase->checkletter($key)){
              $output .= '<input class="key correct" type="submit" value="' . $key . '" disabled>';
            } else {
              $output .= '<input class="key incorrect" type="submit" value="' . $key . '" disabled>';
            }
          } else {
            //if the key has not been selected
            $output .= '<input class="key" type="submit" name="key" value="'. $key .'" id="' . $key . '">';
          }
        }
        $output .= '</div>';
      }
      $output .= '</div>';
    $output .= '</form>';
    return $output;
  }

  public function displayScore()
  {
    $output = '<div id="scoreboard" class="section">';
      $output .= '<ol>';
        //show 5 harts
        for ($i=1; $i <= 5; $i++) {
          //show all the lives remaining
          if ($i <= $this->lives) {
            $output .= '<li class="tries"><img src="../images/liveHeart.png" height="35px" widght="30px"></li>';
          } else {
            $output .= '<li class="tries"><img src="../images/lostHeart.png" height="35px" widgth="30px"></li>';
          }
        }
      $output .= '</ol>';
    $output .= '</div>';
    return $output;
  }

}
