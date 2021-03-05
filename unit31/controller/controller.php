<?php
include_once("model/model.php");
include_once("view/view.php");

class Controller {
	public $model=null;
	public $view = null;
	
	function __construct() {  
		$this->model = new Model("localhost", "banking", "root", ""); #put your DB details in this line !
        $this->model->connect();
        $this->view = new View($this->model);
    } 
	
	function invoke() {
			//display the menu page
			$this->view->display();

   }

}

?>
