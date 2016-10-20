<?
/* Common contains functions used throughout the site */

function editQuiz() {


}


function editQuestion() {


}

function displayDropDown($items, $name, $thisone='') {
  if (count($items)) {
    echo '<select name="' . $name . '" id="'.$name.'">';
//    echo '<option value="">----------</option>';
    foreach($items as $item) {
      $selected = ($item == $thisone) ? ' selected' : '';
      echo '<option value="' . $item . '"' . $selected . '>' . ucfirst($item) . '</option>';
    }
    echo '</select>';
  }
}

function displayInput($name,$type,$value,$placeholder='',$required='') {
	if ($placeholder != "") {
		echo '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'" '.$required.'>';
	} else {
		echo '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" value="'.$value.'" '.$required.'>';
	}
}

function displayRadio($name,$value) {
        echo '<input type="radio" name="'.$name.'" id="'.$value.'" value="'.$value.'">';
}

function displayCheckbox($item,$name,$selected=0) {
	echo '<input type="checkbox" name="'.$name.'" id="'.$name.'" value=1 '.$selected.'>';
}

function quizStatusItems() {
	return array("new","ready","completed","error","delete");
}
?>
