<?
/* edit the menu here, and include on each page where the menu is to appear */
/* instantiate the db here, so it's not required to be created on every page it's used in admin */

/* Color palette! http://www.colorcombos.com/color-schemes/4292/ColorCombo4292.html
 OR http://www.colourlovers.com/palettes/search
*/

require_once('include/medoo.min.php');
include('include/common.php');
$db = new medoo();
?>
<html>
<head>
	<title>Fred's Quiz Creator</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

<script type="text/javascript">
function toggleDiv(divId) {
   $("#"+divId).toggle();
}
</script>

	<style>
body {
        font: 12px/21px Georgia, Times, "Times New Roman", serif;
        margin-top: 50px;
        margin-left: 50px;
}
h1, h2, h3, label {font-family:Verdana, Geneva, sans-serif;}


input[type="text"] {
    height:20px;
    width:350px;
    padding:2px 2px;
}
input[type="email"] {
    height:20px;
    width:350px;
    padding:2px 2px;
}
button.submit  {margin-left:156px;}
ul {
    width:1550px;
    list-style-type:none;
    list-style-position:outside;
    border-bottom:1px solid #eee;
    margin-bottom:10px;
}
ul.qinpool label {
	width:500px;
}
li{
    padding:2px;
    position:relative;
}
li:last-child {
        margin-bottom:20px;
}
label {
    width:150px;
    margin-top: 1px;
    margin-left: 10px;
    margin-bottom: 0px;
    display:inline-block;
    padding:1px;
}
.studentData label {
    width:50px;
}
input.qSort {
	height:20px;
	width:50px;
	padding:2px 2px;
}
.statusList {
	width:200px;
	margin-top: 1px;
	margin-left: 10px;
	margin-bottom: 0px;
	display:inline-block;
	padding:1px;
}
.addedit textarea {padding:8px; width:305px;}

	</style>
</head>
<body>
<a href="/">Home</a> | <a href="/">Quizzes</a> | <a href="/questions.php">Questions</a> | <a href="/results/">Results</a> | <a href="/quiz/index.php?quizid=0">Add Quiz</a> | <a href="/questions/index.php?quizquestionid=0">Add Question</a> 
