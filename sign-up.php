<?php
	if (isset($_POST['submit']))
	{
		$userMoncton = htmlentities(trim($_POST['moncton']));
		$userShippagan =  htmlentities(trim($_POST['shippagan']));
		$userFname =  htmlentities(trim($_POST['Fname']));
		$userLname =  htmlentities(trim($_POST['Lname']));
		$userPhone =  htmlentities(trim($_POST['phone']));
		$userEmail =  htmlentities(trim($_POST['email']));
		$userProf =  htmlentities(trim($_POST['Profession']));
		$userAge =  htmlentities(trim($_POST['age']));

		if ($userMoncton && $userShippagan && $userFname &&
		$userLname && $userPhone && $userEmail && $userProf &&$userAge) {
			
		}else echo "Veuillez remplir tous les champs"
	}
?>