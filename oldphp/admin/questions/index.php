<?
include('../menu.php');
?>
<script type="text/javascript" src="/js/ajaxupload.js"></script>
<?
/* Question Create/Edit page. Shows list of questions in reverse chronological created order */
if (!empty($_REQUEST["quizquestionid"])) {
	$quizquestionid = $_REQUEST["quizquestionid"];
} else {
	$quizquestionid=0;
}
// First check to see if this form has already been submitted
if (!empty($_POST)) {
	/* check for answers and remove from list before processing question update */
	$ansArr = array();
	$newAnsArr = array();
	$corArr = array();
	$dbArr = $_POST;
	if (!empty($_POST['answer'])) {
		$ansArr = $_POST['answer'];
		unset($dbArr['answer']);
	}
	if (!empty($_POST['newanswer'])) {
		$newAnsArr = $_POST['newanswer'];
		unset($dbArr['newanswer']);
	}
	if (!empty($_POST['correct'])) {
		$corArr = $_POST['correct'];
		unset($dbArr['correct']);
	}

	if ($quizquestionid > 0) {
		//update
		$qUpdate = $db->update("quizQuestion",$dbArr,array("quizquestionid"=>$quizquestionid));
	} else { 
		//insert also sets created date
		$dbArr['#createdDate']="NOW()";
		$qInsert = $db->insert("quizQuestion",$dbArr);
		$quizquestionid = $db->max("quizQuestion","quizquestionid");
	}
	// Handle the answers and what's correct
	if (count($ansArr) > 0 ) {
		foreach ($ansArr as $k => $v) {
			$updateAnswers = $db->update("quizAnswer",array("answer"=>$v),array("quizanswerid"=>$k));
		}
	}
	if (count($newAnsArr) > 0) {
		foreach ($newAnsArr as $nans) {
			if ($nans != '') {
			  $insArr = array("quizquestionid"=>$quizquestionid,"answer"=>$nans,"#createdDate"=>"NOW()");
			  $aIns = $db->insert("quizAnswer",$insArr);
			}
		}
	}
} 
$quizStatusItems = quizStatusItems();
$questionTypeItems = array("multiple","text","true/false");
$question = array('quizquestionid'=>0,'question'=>'','status'=>'new','questionType'=>'','active'=>'1','createdDate'=>'','questionImage'=>'');
if ($quizquestionid > 0) {
        $quizquestionRS = $db->select("quizQuestion","*",array("quizquestionid"=>$quizquestionid));
        $question = $quizquestionRS[0];
}
?>
<form class="addedit" name="addeditquiz" id="addeditquiz" action="<?=htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
<input type="hidden" name="quizquestionid" id="quizquestionid" value="<?=$question['quizquestionid']?>">
<ul>
<li><h2>Add/Edit Question</h2></li>

<li>
        <label for="question">Question Name</label>
        <? displayInput("questionName","text",$question["questionName"]);?>
</li>
	
<li>
	<label for="question">Question</label>
	<textarea name="question" cols="45" rows="4"><?=$question["question"]?></textarea>
</li>
<li>
	<label for="questionImage">Image</label>
	<input type="text" name="questionImage" id="questionImage" value="<?=$question['questionImage']?>">
		<? if ($question['questionImage'] != '') { ?>
			<img src="http://quiz.seejenicode.com/uplImages/<?=$question['questionImage']?>" width=80>
		<?}?>
		<button id="imageupload" name="imageupload" class="upload">Upload Image</button>
		<div class="status"></div>
		<script type="text/javascript">
		// file upload
			$(function(){
				var file_type = '';
				var btnUpload=$('#imageupload');
				var status=$('.status');
				new AjaxUpload(btnUpload, {action: "upload.php",
					//Name of the file input box
					name: 'questionImage',
					onSubmit: function(file, ext){
						file_type = ext;
						status.html('uploading....');
					},
					onComplete: function(file, response){

						//On completion clear the status
						status.html('');
						//Add uploaded file to list
						if(response==="upload_error"){
							alert("Error in upload");
						} else {
						//	var imgHtml = response;
						//	$("#images").append(imgHtml);
							document.addeditquiz.questionImage.value = response;
						}
					}
				});

			});
		</script>
</li>
<li>
	<label for="questionType">Type</label>
	<? displayDropDown($questionTypeItems,'questionType',$question['questionType']); ?>
</li>
<li>
	<label for="status">Status</label>
	<? displayDropDown($quizStatusItems,'status',$question['status']); ?>
</li>
<li>
	<label for="active">Active</label>
	<input type="checkbox" name="active" id="active" value="1"<? if ($question['active']==1) { echo " checked"; }?>>
</li>
<li><h2>Answers</h2></li>

<?
$answersFieldList = array("quizanswerid","answer","correct");
$answersList = $db->select("quizAnswer",$answersFieldList,array("quizquestionid"=>$quizquestionid));
$ansCount = 0;
foreach ($answersList as $ans) { 
	$ansCount++; ?>
	<li><label for="answer[<?=$ans['quizanswerid']?>]"><?=$ansCount?></label>
	<input type="text" name="answer[<?=$ans['quizanswerid']?>]" id="answer[<?=$ans['quizanswerid']?>]" value="<?=$ans['answer']?>">
	<input type="checkbox" name="correct[<?=$ans['quizanswerid']?>]" id="correct[<?=$ans['quizanswerid']?>]" value="1">
	</li>
<? } 
while ($ansCount < 5) {
	$ansCount++; ?>
	<li><label for="newanswer<?=$ansCount?>"><?=$ansCount?></label>
	<input type="text" name="newanswer[]" id="newanswer<?=$ansCount?>" value="" autocomplete="off"></li>
<?}?>

<li><button class="submit" type="submit">Submit Question</button></li>
<li>Created Date: <? if ($quizquestionid > 0) { echo date("m/d/Y H:i", strtotime($question["createdDate"])); }?></li>
</ul>
</form>


<h2>Questions Pool</h2>
<table>
<?
$questionFieldList = array("quizquestionid","question","status");
$questionList = $db->select("quizQuestion",$questionFieldList,array("ORDER"=>"question"));
foreach($questionList as $qs){ ?>
        <tr><td><a href="index.php?quizquestionid=<?=$qs["quizquestionid"]?>"><?=$qs["question"]?></a></td><td><?=$qs["status"]?></td></tr>

<? } ?>
</table>

