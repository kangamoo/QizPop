<?
require_once('include/medoo.min.php');
$db = new medoo();

/*
select($table, $join, $columns, $where)

$datas = $database->select("account", "*");
foreach($datas as $data)
{
	echo "user_name:" . $data["user_name"] . " - email:" . $data["email"] . "<br/>";
}
*/

$testRS = $db->select("quiz","*");
print_r($testRS);


/* plain query
$database->query("CREATE TABLE table (
	c1 INT STORAGE DISK,
	c2 INT STORAGE MEMORY
) ENGINE NDB;");
 
$data = $database->query("SELECT email FROM account")->fetchAll();
print_r($data);
*/

?>
