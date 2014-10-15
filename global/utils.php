<?php 

if(!function_exists('user_connected')) {
	function user_connected() {
		return isset($_SESSION['user']);
	}
}