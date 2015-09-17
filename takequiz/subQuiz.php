<?
require_once('../admin/include/medoo.min.php');
include('../admin/include/common.php');
$db = new medoo();
session_start();

if (isset($_POST['quizid']) && isset($_SESSION['page1'])) {
	//process form
	//add codefield for each
	$cf = $_SESSION['codefieldName'];
	$rawArr = $_POST;
	//grab out name/email
	$insertArr = array(
		"enteredName"	=>	$rawArr[$cf.'enteredName'], 
		"email"		=>	$rawArr[$cf.'email'],
		"status"	=>	'new',
		"#createdDate"	=>	"NOW()",
		"quizid"	=>	$rawArr['quizid'],
	);
	//unset those vars, so that we're left with the answers
	unset($rawArr[$cf.'enteredName']);
	unset($rawArr[$cf.'email']);
	unset($rawArr['quizid']);
	$rawData = json_encode($rawArr);
	$insertArr['rawData'] = $rawData;
	$shoveItIn = $db->insert("quizResult",$insertArr);
	$quizresult = $db->select("quizResult",array("quizresultid"),array("rawData"=>$rawData));
	//Now to break down the answers
	unset($rawArr['codefieldName']);
	foreach($rawArr as $k => $v) {
		//split keys on question. Split value on pipe
		$questionData = explode("question",$k);
		//here can add more security if needed to check to make sure it's same student. Not checking now though
		$answerData = explode("|",$v);
		//case where answer doesn't have id?!
		if (!empty($answerData[1])) {
			$answerid = $answerData[0];
			$answer = $answerData[1];
		} else {
			$answerid =0;
			$answer = $answerData[0];
		}
		//lets make the array and put it together
		$insertDetailArr = array(
			"quizresultid"	=>	$quizresult[0]['quizresultid'],
			"quizid"	=>	$insertArr['quizid'],
			"quizquestionid"=>	$questionData[1],
			"quizanswerid"	=>	$answerid,
			"answer"	=>	$answer,
			"#createdDate"	=>	"NOW()"
		);
		$shoveDetails = $db->insert("quizResultDetail",$insertDetailArr);	
	}	
/*
echo "<pre>";
	print_r($_POST);
	print_r($insertArr);
	echo($rawData);
	print_r($quizresult);
	print_r($insertDetailArr);
echo "</pre>";
*/
	$_SESSION['page2']="2";
	header('Location: confirm.php?result='.$quizresult[0]['quizresultid']);
} else {
	header('Location: index.php?quizid='.$_POST['quizid']);
}
?>
