<?
/* edit the menu here, and include on each page where the menu is to appear */
/* instantiate the db here, so it's not required to be created on every page it's used in admin */
require_once('admin/include/medoo.min.php');
include('admin/include/common.php');
$db = new medoo();
?>
<html>
<head>
	<title>Quiz List</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
</head>
<body>
<a href="/">Home</a> | <a href="/quizlist.php">Quizzes</a> 
