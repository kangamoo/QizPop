<?
include('../menu.php');

/* Quiz Create/Edit page. Shows list of quizzes in reverse chronological created order */
$quizid = $_REQUEST["quizid"];

// First check to see if this form has already been submitted
if (!empty($_POST)) {
	//remove questions from array to insert into linking table after quiz is updated or created
//print_r($_POST);
	$qArr = array();
	$delArr = array();
	$sortArr = array();
	$dbArr = $_POST;
	if (!empty($_POST['addQuestion'])) {
		$qArr = $_POST['addQuestion'];
		unset($dbArr['addQuestion']);
	}
	if (!empty($_POST['deleteQuestion'])) {
		$delArr = $_POST['deleteQuestion'];
		unset($dbArr['deleteQuestion']);
	}
	if (!empty($_POST['quizContentSort'])) {
		$sortArr = $_POST['quizContentSort'];
		unset($dbArr['quizContentSort']);
	}
//print_r($dbArr);
	if ($quizid > 0) {
		$quizUpdate = $db->update("quiz",$dbArr,array("quizid"=>$quizid));
	} else { 
		$dbArr['#createdDate']="NOW()";
		$quizInsert = $db->insert("quiz",$dbArr);
		$quizid = $db->max("quiz","quizid");
	}
	//Delete/Insert Questions for the Quiz
	if (count($sortArr) >0) {
		foreach ($sortArr as $k => $v) {
			$upSort = $db->update("quizContent",array("sortOrder"=>$v),array("quizcontentid"=>$k));
		}
	}
	if (count($delArr) > 0) {
		foreach ($delArr as $dqids) {
			$qdel = $db->query("DELETE from quizContent where quizcontentid=".$dqids);
		}
	}
	if (count($qArr) > 0) {
		foreach ($qArr as $qids) {
			$insArr = array("quizid"=>$quizid,"quizquestionid"=>$qids);
			$qins = $db->insert("quizContent",$insArr);
		}
	}
} 
$quizStatusItems = quizStatusItems();
$quiz = array('quizid'=>0,'quizName'=>'','status'=>'new','availableDate'=>'','endAvailableDate'=>'','active'=>'1');
?>
<h2>Add/Edit Quiz</h2>
<form name="addeditquiz" id="addeditquiz" action="<?=htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<?
if ($quizid > 0) {
	$quizRS = $db->select("quiz","*",array("quizid"=>$quizid));
	$quiz = $quizRS[0]; 
}
//echo "<pre>";
//print_r($quiz);
//echo "</pre>";
?>
<input type="hidden" name="quizid" id="quizid" value="<?=$quiz['quizid']?>">
<table>
	<tr><td><label for="quizName">Quiz name: </label></td><td><?= displayInput("quizName","text",$quiz["quizName"]);?></td></tr>
	<tr><td><label for="status">Status</label></td><td><? displayDropDown($quizStatusItems,'status',$quiz['status']); ?></td></tr>
	<tr><td>Created Date</td><td><?=$quiz["createdDate"]?></td></tr>
	<tr><td><label for="availableDate">Available Date</label></td><td><?= displayInput("availableDate","date",$quiz["availableDate"]);?></td></tr>
	<tr><td><label for="endAvailableDate">End Date</label></td><td><?= displayInput("endAvailableDate","date",$quiz["endAvailableDate"]);?></td></tr>
	<tr><td><label for="active">Active</label></td><td><input type="checkbox" name="active" id="active" value="1"<? if ($quiz['active']==1) { echo " checked"; }?>></td></tr>
</table>

<h2>Questions in this quiz</h2>
<table>
<tr><td>Sort Order</td><td>&nbsp;</td><td>Delete Question</td></tr>
<?
$qlistSql="SELECT question,quizcontentid,sortOrder,quizContent.quizquestionid FROM quizContent INNER JOIN quizQuestion ON quizContent.quizquestionid = quizQuestion.quizquestionid WHERE quizContent.quizid=".$quizid;
$qQuestionList = $db->query($qlistSql)->fetchAll();
foreach($qQuestionList as $qqs){ ?>
        <tr><td><input type="text" value="<?=$qqs["sortOrder"]?>" name="quizContentSort[<?=$qqs["quizcontentid"]?>]" size='5'></td><td><?=$qqs["question"]?></td><td><input type="checkbox" value="<?=$qqs["quizcontentid"]?>" name="deleteQuestion[]"></td></tr>

<? } ?>

</table>

<h2>Questions Pool</h2>
<table>
<?
$questionFieldList = array("quizquestionid","question","status");
$questionList = $db->select("quizQuestion",$questionFieldList,array("ORDER"=>"question"));
foreach($questionList as $qs){ ?>
        <tr><td><input type="checkbox" value="<?=$qs["quizquestionid"]?>" name="addQuestion[]"></td><td><a href="/questions/index.php?quizquestionid=<?=$qs["quizquestionid"]?>"><?=$qs["question"]?></a></td><td><?=$qs["status"]?></td></tr>

<? } ?>
</table>
<input type="submit" value="Submit">
</form>
