<?php
require "../blindtest.php";
$blindtest = blindtest::getInstance();

if (isset($_GET["action"])) {
	if (($_GET["action"] == "incrscore") and isset($_GET["teamkey"])) {
		$blindtest->incrScore($_GET["teamkey"]);
		echo sprintf('%03d', $blindtest->getScore($_GET["teamkey"]));
	}
	if (($_GET["action"] == "decrscore") and isset($_GET["teamkey"])) {
		$blindtest->decrScore($_GET["teamkey"]);
		echo sprintf('%03d', $blindtest->getScore($_GET["teamkey"]));
	}
	if ($_GET["action"] == "resetalltime") {
		$blindtest->resetTimeAll();
	}
	if ($_GET["action"] == "refresh") {
		$positions = $blindtest->getPositions();
		$listTeams = $blindtest->getTeams();
		$infos = array(
			"positions" => $positions,
			"listteams" => $listTeams
		);
		$json = json_encode($infos, JSON_FORCE_OBJECT);
		echo $json;
	}
	if (($_GET["action"] == "setnbteams") and isset($_GET["nbteams"])) {
		$blindtest->setNbTeams($_GET["nbteams"]);
	}
	if ($_GET["action"] == "flushall") {
		$blindtest->flushall();
	}
}


?>