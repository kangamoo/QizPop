<?
require_once('../admin/include/medoo.min.php');
include('../admin/include/common.php');
$db = new medoo();
session_start();
if (!isset($_SESSION['page2'])) {
	header('Location: quizList.php');
	exit();
}
session_destroy();

/* Quiz confirm page!  */
/*
$result = $_REQUEST['result'];

if ($result > 0) {

	$checkQuiz = $db->query("SELECT quizid, quizName FROM quiz WHERE status='ready' AND active=1 AND availableDate <= NOW() AND endAvailableDate >= NOW() AND quizid=".$quizid );
	foreach($checkQuiz as $quiz) {
		$quizid=$quiz['quizid'];
		$quizName = $quiz['quizName'];
	}
	if ($quizName == '') {
		header('Location:/index.php');
		exit();
	} 
}
*/
include('header.php');
?>
<h1>Congratulations! You have finished the quiz.</h1>
