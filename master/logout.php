<?php	session_start();
		unset($_SESSION['GTAdminUserID']);
		unset($_SESSION['GTAdminUserName']);
		unset($_SESSION['GTAdminUserPackage']);
		unset($_SESSION['GTAdminUserEmail']);
		unset($_SESSION['usergroupid']);
		session_destroy();
		echo "<script>document.location.href='sign-in.php'</script>";
?>