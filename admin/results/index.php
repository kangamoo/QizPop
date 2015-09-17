<?
include('../menu.php');

/* Main Results page. Shows list of quizzses that have results */
?>
<ul>
	<li><h3>Results</h3></li>
	<li><div id="starter">
		<ul>
<?
$newQuiz = '';
$quizRS = $db->query("SELECT qr.quizid, enteredName, email, quizresultid, quizName, quizHeading,score FROM quizResult as qr inner join quiz on qr.quizid=quiz.quizid ORDER BY qr.createdDate DESC" );
foreach($quizRS as $quiz){ 
	if ($newQuiz != $quiz['quizid']) {
		$newQuiz = $quiz['quizid']; ?>
		</ul></div></li>
		<li><a href="javascript:toggleDiv('qr<?=$newQuiz?>');"><?=$quiz['quizName']?></a></li>
		<li><div id="qr<?=$newQuiz?>">
			<ul>
<?	} ?>	
			<li><?=$quiz['score']?> <a href="resultDetail.php?quizresultid=<?=$quiz['quizresultid']?>"><?=$quiz['enteredName']?> - <?=$quiz['email']?></a></li>
	
<? } ?>
</ul>
</div>
</li>
