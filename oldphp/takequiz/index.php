<?
require_once('../admin/include/medoo.min.php');
include('../admin/include/common.php');
$db = new medoo();
session_start();
$_SESSION['page1']=1;
$codefieldName = md5(uniqid('auth', true));
$_SESSION['codefieldName'] = $codefieldName;
$quizName = '';

/* Quiz take page! for the chirruns */
$quizid = $_REQUEST["quizid"];
if (isset($_REQUEST['quizid']) && ! preg_match('/^\d+$/', $quizid)) {
	$error  = 'Invalid Quiz';
}

/* Double check this quiz is even active, ready and within dates */
if ($quizid > 0) {
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
include('header.php');
?>
<h1>Quiz: <?=$quizName?></h1>
<form name="quizitup" id="quizitup" action="subQuiz.php" method="post" autocomplete="off">
<input type="hidden" name="quizid" id="quizid" value="<?=$quizid?>">
<input type="hidden" name="codefieldName" value = "<?=$codefieldName?>">
<? /* before the questions, request name and email as text fields, the only that require validation */ ?>
<ul class="studentData">
<li>
	<label for="<?=$codefieldName?>enteredName">Name</label>
	<? displayInput($codefieldName."enteredName","text","","Your Name Here","required"); ?>
</li>
<li>
	<label for="<?=$codefieldName?>email">Email</label>
	<? displayInput($codefieldName."email","email","","email@address.com","required"); ?>
</li>
</ul>
<?
$qCount=0;

$qlistSql="SELECT question,questionType,quizContent.quizquestionid FROM quizContent INNER JOIN quizQuestion ON quizContent.quizquestionid = quizQuestion.quizquestionid WHERE quizContent.quizid=".$quizid." ORDER BY quizContent.sortOrder";
$qQuestionList = $db->query($qlistSql)->fetchAll();
foreach($qQuestionList as $qqs){ 
	$qCount++;
?>
	<h3><?=$qCount?>. <?=$qqs["question"]?></h3>
	<ul>
	<? if ($qqs['questionType'] == "text") { ?>
		<li><? displayInput($codefieldName."question".$qqs['quizquestionid'],"text",""); ?></li>
	<? } else if ($qqs['questionType'] == "true/false") { ?>
		<li><? displayRadio($codefieldName."question".$qqs['quizquestionid'],"0|true")?><label for="0|true">True</label></li>
		<li><? displayRadio($codefieldName."question".$qqs['quizquestionid'],"0|false")?><label for="0|false">False</label></li>
	<? } else { ?>
		<? 
		$answerList = $db->query("SELECT quizanswerid, answer from quizAnswer where quizquestionid=".$qqs['quizquestionid']." ORDER BY RAND()");
		//$answerList = $db->select("quizAnswer",array("quizanswerid","answer"),array("quizquestionid"=>$qqs['quizquestionid'],"ORDER"=>"RAND()"));	
		$aCount=0;
		foreach($answerList as $ans) {
			$aCount++;
			?>
			<li><? displayRadio($codefieldName."question".$qqs['quizquestionid'],$ans['quizanswerid']."|".htmlentities($ans['answer']))?><label for="<?=$ans['quizanswerid']?>|<?=htmlentities($ans['answer'])?>"><?=$ans['answer']?></label>			
	     <? } //end answer foreach ?>
<? 	} //end if question type ?>
	</ul>		
<?} //end question foreach ?>

<button type="submit" value="Submit" class="submit">Submit Quiz</button>
</form>
