<?
include('../menu.php');
?>
<?
if (!empty($_REQUEST["quizresultid"])) {
	$quizresultid = $_REQUEST["quizresultid"];
} else {
	$quizresultid=0;
}
if (!empty($_POST)) {
	/* update the score */
	$dbArr = $_POST;
	if ($quizresultid > 0) {
		//update
		$qUpdate = $db->update("quizResult",$dbArr,array("quizresultid"=>$quizresultid));
	}
} 
$quizStatusItems = array("new","completed","scored","error","delete");
if ($quizresultid > 0) {
        $quizresultRS = $db->select("quizResult","*",array("quizresultid"=>$quizresultid));
        $result = $quizresultRS[0];
}
?>
<form class="addedit" name="addeditquiz" id="addeditquiz" action="<?=htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
<input type="hidden" name="quizresultid" id="quizresultid" value="<?=$result['quizresultid']?>">
<ul>
<li><h2>View/Score Result</h2></li>

<li>
        <label for="enteredName">Name</label>
        <? displayInput("enteredName","text",$result["enteredName"]);?>
</li>
<li>
        <label for="email">Email</label>
        <? displayInput("email","text",$result["email"]);?>
</li>
<li>
	<label for="status">Status</label>
	<? displayDropDown($quizStatusItems,'status',$result['status']); ?>
</li>
<li>
	<label for="active">Active</label>
	<input type="checkbox" name="active" id="active" value="1"<? if ($result['active']==1) { echo " checked"; }?>>
</li>
<li><h2>Answers</h2></li>

<?
$resultDetail = $db->query("SELECT question,answer from quizResultDetail as qrd INNER JOIN quizQuestion as qq on qq.quizquestionid=qrd.quizquestionid where qrd.quizresultid=".$result['quizresultid']);
$ansCount = 0;
foreach ($resultDetail as $ans) { 
	$ansCount++; ?>
	<li><?=$ans['question']?><br />
	<?=$ans['answer']?>
	</li>
<? } 
?>
<li><button class="submit" type="submit">Save</button></li>
<li>Created Date: <? if ($quizresultid > 0) { echo date("m/d/Y H:i", strtotime($result["createdDate"])); }?></li>
</ul>
</form>


