<?php
//phrase class
class Phrase
{
  private $currentPhrase;
  private $selected;
  private $phraseList;

  function __construct($phrase = '', $selected = array())
  {
    //make a list of phrases
    $this->phraseList = ['There\'s No I in Team','Wild Goose Chase','Right Out of the Gate','Cry Over Spilt Milk','Tough It Out'];
    if (empty($phrase)) {
      //set currentPhrase a random phrase
      //from phraseList if a phrase was not submited
      $this->currentPhrase = strtolower($this->phraseList[rand(0, (count($this->phraseList)-1))]);
    } else {
      //set currentPhrase to the submited phrase
      $this->currentPhrase = strtolower($phrase);
    }
    $this->selected = $selected;
  }

  public function getSelected ()
  {
    return $this->selected;
  }

  public function updateSelected($selected)
  {
    $this->selected = $selected;
  }

  public function addPhraseToDisplay() {
    $output = '<ul">';
    //make an array with every character of the phrase seperated
    $phraseArray = str_split($this->currentPhrase);
    if (empty($this->selected)) {
      //no letters have been selected
      foreach ($phraseArray as $phraseLetter) {
        if ($phraseLetter != ' ') {
          if ($phraseLetter == "'") {
            //show the '
            $output .= '<li class="show letter">'. $phraseLetter .'</li>';
          } else {
            //hide every letter
            $output .= '<li class="hide letter">'. $phraseLetter .'</li>';
          }
        } else {
          //hide spaces
          $output .= '<li class="hide space">'. $phraseLetter .'</li>';
        }
      }
    } else {
      //letters have been selected
      foreach ($phraseArray as $phraseLetter) {
        if ($phraseLetter != ' ') {
          //get the length of selected
          $selectedlength = count($this->selected);
          foreach ($this->selected as $selectedLetter) {
            //get the index of the selected letter in selected
            $key = array_search($selectedLetter, $this->selected);
            if ($this->checkLetter($selectedLetter) && $selectedLetter == strtolower($phraseLetter) || $phraseLetter == "'") {
              //show the character if the selected letter is in the phrase
              //and it is the same as the phrase letter
              //or the character is a '
              $output .= '<li class="show letter">'. $phraseLetter .'</li>';
              //stop looping
              break;
            } elseif ($key == ($selectedlength-1)) {
              //if at the end of the selected array
              //hide the letter
              $output .= '<li class="hide letter">'. $phraseLetter .'</li>';
              break;
            }
          }
        } else {
          //hide spaces
          $output .= '<li class="hide space">'. $phraseLetter .'</li>';
        }
      }
    }
    $output .= '</ul>';
    return $output;
  }

  public function showFullPhrase()
  {
    $output = '<ul>';
    //make an array with every character of the phrase seperated
    $phraseArray = str_split($this->currentPhrase);
    foreach ($phraseArray as $phraseLetter) {
      if ($phraseLetter != ' ') {
        //show all the characters
        $output .= '<li class="show letter">'. $phraseLetter .'</li>';
      } else {
        //hide spaces
        $output .= '<li class="hide space">'. $phraseLetter .'</li>';
      }
    }
    $output .= '</ul>';
    return $output;
  }

  public function checkLetter($letter) {
    //if letter is in currentPhrase
    if(is_int(strpos($this->currentPhrase, $letter))){
      return true;
    } else {
      return false;
    }
  }
}
