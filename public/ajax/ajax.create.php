<?php
require_once("../includes/initialize.php");

if (isset($_GET['packages'])) {
	$result = $Packages->fetchAll();
	//print_r($result);

	if (is_array($result)) {
		echo json_encode($result);
	} else {
		echo 0;
	}
}


if (isset($_GET['gallery'])) {
	$result = $Gallery->fetchAll();

	if (is_array($result)) {
		echo json_encode($result);
	} else {
		echo 0;
	}
}

?>
