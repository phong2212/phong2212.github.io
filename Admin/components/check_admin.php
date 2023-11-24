<?php
function check_administrator() {
	return (isset($_SESSION['admin'])); 
}
if (!check_administrator()) {
	echo '<h2>Truy cập bị từ chối!</h2>';

	$error_message = 'Bạn không có quyền truy xuất trang này';
	include 'show_error.php';

	include 'footer.php';
	exit();
}
