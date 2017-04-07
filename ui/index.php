<?php
include("header.php");
require "../blindtest.php";
$blindtest = blindtest::getInstance();
$listTeams = $blindtest->getTeams();
$positions = $blindtest->getPositions();
?>
<div class="container row">
<?php
echo '<br>';
echo '<div class="question col-md-offset-2 colcol-md-6">';
?>
<form class="form-inline">
  <div class="form-group">
    <label for="exampleInputName2">Nombre d'équipes</label>
    <?php
    echo '<input type="text" class="form-control" id="inputNbTeams" value="'.count($listTeams).'">';
    ?>
  </div>
  <button class="btn btn-default" onclick="setNbTeams();">Appliquer</button>
</form>
<br>
<?php
//echo 'Nombre d\'équipes <input type="text" class="form-control col-md-2" id="inputtext1" placeholder="5">';
echo 'Question suivante  <button type="button" onclick="resetalltime();" class="btn btn-default btn-lg">';
echo '<span class="glyphicon glyphicon-forward" aria-hidden="true"></span>';
echo '</button>';
echo '</div>';


//print_r($positions);
foreach($listTeams as $team=>$infos) {
	echo '<div class="col-md-2">';
	echo '<div class="button-title">';
	echo '<h2>'.$infos["nom"].'</h2>';
	echo '</div>';
	echo '<div class="button-image">';
	if ($infos["time"] == -1) {
		echo '<img id="imagebutton-'.$team.'" src="img/button_red.png">';
	} else {
		echo '<img id="imagebutton-'.$team.'" src="img/button_green.png">';
	}
	echo '</div>';
	echo '<div id="score-'.$team.'" class="button-score">';
	echo sprintf('%03d', $infos["score"]);
	echo '</div>';
	echo '<div id="score-'.$team.'" class="button-score">';
	echo '</div>';
	echo '<div id="position-'.$team.'" class="button-position">';
	if (array_key_exists($team, $positions)) {
		echo $positions[$team];
		if ($positions[$team] == 1) {
			echo "er";
		} else {
			echo "ème";
		}
		
	} else {
		echo "------";
	}
	echo '</div>';
	echo '<div class="buttons">';
	echo '<button type="button" onclick="incrscore(\''.$team.'\');" class="btn btn-default btn-lg">';
	echo '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>';
	echo '</button>';
	echo '<button type="button" onclick="decrscore(\''.$team.'\');" class="btn btn-default btn-lg">';
	echo '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>';
	echo '</button>';
	echo '</div>';
	
	echo '</div>';
}

?>



</div>
<?php
  	include("footer.php");
?>