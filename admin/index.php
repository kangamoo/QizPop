<?
include('menu.php');
/* Main page. Shows list of quizzes in reverse chronological created order */
?>


<h3>Quizzes</h3>


<a href="/quiz/index.php?quizid=0">Add Quiz</a><br /><br />

<table id="quizlist">
<tr class="toprow"><td>Quiz</td><td>Status</td><td>Created</td></tr>

<?
//$quizRS = $db->select("quiz","*", "ORDER" => "createdDate DESC");

$quizRS = $db->query("SELECT * FROM quiz ORDER BY createdDate DESC" );
foreach($quizRS as $quiz){ ?>
	<tr><td><a href="/quiz/index.php?quizid=<?=$quiz["quizid"]?>"><?=$quiz["quizName"]?></a></td><td><?=$quiz["status"]?></td><td><?=$quiz["createdDate"]?></td></tr>

<? } ?>
</table>




<?
/* plain query
$database->query("CREATE TABLE table (
	c1 INT STORAGE DISK,
	c2 INT STORAGE MEMORY
) ENGINE NDB;");
 
$data = $database->query("SELECT email FROM account")->fetchAll();
print_r($data);

order by in select
$database->select("account", "user_id", [
 
	"ORDER" => ['user_name DESC', 'user_id ASC']
 
]);
*/

?>
