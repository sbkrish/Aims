<?php

$con = mysqli_connect('localhost','geopos','Passw0rd*123','aims');
if($con) {
	// echo "DB connection success";
} else {
	echo "DB connection failed";
}

?>