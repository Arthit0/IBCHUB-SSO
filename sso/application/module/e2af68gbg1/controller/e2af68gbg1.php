<?php 
class e2af68gbg1 extends Controller {

	function __construct() {
		parent::__construct();
		$_SESSION['is_true_path'] = true;
		header("location: ".BASE_URL."office"); 
		exit();
	}
}

 ?>