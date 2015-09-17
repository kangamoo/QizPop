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
	$sortedVar = $_POST['sorted'];
	unset($dbArr['sorted']);
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
			//update sort order to be sorted+1
			$insArr = array("quizid"=>$quizid,"quizquestionid"=>$qids,"sortOrder"=>$sortedVar);
			$qins = $db->insert("quizContent",$insArr);
			$sortedVar++;
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
<ul>
	<li><label for="quizName">Quiz name </label> <?= displayInput("quizName","text",$quiz["quizName"]);?></li>
	<li><label for="quizHeading">Quiz heading </label> <?= displayInput("quizHeading","text",$quiz["quizHeading"]);?></li>
	<li><label for="status">Status</label> <? displayDropDown($quizStatusItems,'status',$quiz['status']); ?></li>
	<li><label for="availableDate">Available Date</label> <?= displayInput("availableDate","date",$quiz["availableDate"]);?></li>
	<li><label for="endAvailableDate">End Date</label> <?= displayInput("endAvailableDate","date",$quiz["endAvailableDate"]);?></li>
	<li><label for="active">Active</label> <input type="checkbox" name="active" id="active" value="1"<? if ($quiz['active']==1) { echo " checked"; }?>></li>
</ul>

<? if ($quizid != 0) { ?>
<h2>Questions in this quiz</h2>
<ul class="qinq">
<?
$qlistSql="SELECT question,quizcontentid,sortOrder,quizContent.quizquestionid FROM quizContent INNER JOIN quizQuestion ON quizContent.quizquestionid = quizQuestion.quizquestionid WHERE quizContent.quizid=".$quizid." ORDER BY quizContent.sortOrder";
$qQuestionList = $db->query($qlistSql)->fetchAll();
$sorted=1;
foreach($qQuestionList as $qqs){ ?>
        <li><input type="text" value="<?=$sorted?>" name="quizContentSort[<?=$qqs["quizcontentid"]?>]" size='5' id="qSort" class="qSort"> <?=$qqs["question"]?> <input type="checkbox" value="<?=$qqs["quizcontentid"]?>" name="deleteQuestion[]"></li>

<? 	$sorted++;
} ?>
</ul>
<input type="hidden" name="sorted" value="<?=$sorted?>" id="sorted">

<h2>Questions Pool</h2>
<ul class="qinpool">
<?
$questionFieldList = array("quizquestionid","question","status");
$questionList = $db->select("quizQuestion",$questionFieldList,array("ORDER"=>"quizquestionid"));
foreach($questionList as $qs){ ?>
        <li><input type="checkbox" value="<?=$qs["quizquestionid"]?>" name="addQuestion[]" id="addQuestion"> 
	<label for="addQuestion"><a href="/questions/index.php?quizquestionid=<?=$qs["quizquestionid"]?>"><?=$qs["question"]?></a></label>
	<span class="statusList"><?=$qs["status"]?></span></li>

<? } ?>
</ul>
<?} //checking to see if the quiz has an ID before adding question ?>
<ul>
<li>Created Date: <?=$quiz["createdDate"]?></li>
<button type="submit" value="Submit" class="submit">Submit</button>
</ul>
</form>
