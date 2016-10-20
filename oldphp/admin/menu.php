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
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fred's Quiz Creator</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<script src="http://code.angularjs.org/angular-1.0.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

<script type="text/javascript">
function toggleDiv(divId) {
   $("#"+divId).toggle();
}
</script>

</head>
<body ng-app="QizPop">
<nav class="navbar navbar-inverse">
	<div class="container">
		<div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">QizPop</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="/">Quizzes</a></li>
              <li><a href="/questions.php">Questions</a></li>
              <li><a href="/results/">Results</a></li>
              <li><a href="/quiz/index.php?quizid=0">Add Quiz</a></li>
              <li><a href="/questions/index.php?quizquestionid=0">Add Question</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
</nav>

