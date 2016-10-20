<?
include('menu.php');

/* Main page. Shows list of quizzes available */
?>

<h3>Available Quizzes</h3>
<ul>
<?
$quizRS = $db->query("SELECT quizid, quizName FROM quiz WHERE status='ready' AND active=1 AND availableDate <= NOW() AND endAvailableDate >= NOW() ORDER BY quizName" );
foreach($quizRS as $quiz){ ?>
	<li><a href="/takequiz/?quizid=<?=$quiz["quizid"]?>"><?=$quiz["quizName"]?></a>

<? } ?>
</ul>


