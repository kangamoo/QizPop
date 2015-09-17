<?
include('menu.php');

/* Main Question page. Shows list of questions */
?>

<h3>Questions</h3>
<a href="editQuestion.php?quizid=0">Add Question</a><br /><br />

<table id="quizlist">
<tr class="toprow"><td>Question</td><td>Status</td><td>Created</td><td>&nbsp;</td></tr>

<?

$quizRS = $db->query("SELECT * FROM quizQuestion ORDER BY createdDate DESC" );
foreach($quizRS as $quiz){ ?>
	<tr><td><a href="editQuestion.php?quizquestionid=<?=$quiz["quizquestionid"]?>"><?=$quiz["question"]?></a></td>
	<td><?=$quiz["status"]?></td><td><?=$quiz["createdDate"]?></td>
	<td><a href="#" class="delete" onclick="return confirm('Are you sure?');">Delete</a></td></tr>

<? } ?>
</table>

