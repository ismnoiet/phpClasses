<?php 
class Upload{
	public $uploadState;
	public $info;
	const DS = DIRECTORY_SEPARATOR;


	function __construct($FILES='',$name=''){

	
		$this->FILES = $FILES;
		$this->name = $name;
		$this->check($FILES,$name);

		$this->info = array();

		$this->info["name"]      = $this->FILES[$this->name]['name'];
		$this->info["tmp"]       = $this->FILES[$this->name]['tmp_name'];
		$this->info["error"]     = $this->FILES[$this->name]['error'];
		$this->info["size"]      = $this->FILES[$this->name]['size'];
		$this->info["extension"] = $this->extension();
	}	

	function verify($option=''){
		if($option == 'image'){

			$check = getimagesize($FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        // echo "File is an image - " . $check["mime"] . ".";
		        // $uploadOk = 1;
		        return array("response"=>true,"mime"=>$check["mime"]);
		    } else {
		        // echo "File is not an image.";
		        // $uploadOk = 0;
		        return array("response"=>false,"mime"=>"");
		    }	
		}
	}

	private function check($FILES,$name){
		if((is_array($FILES) && count($FILES) == 0)  ||
		    
		    is_array($FILES[$name]) && strlen($FILES[$name]['name']) == 0

		  ){
			die('no file uploaded');
		 	$this->uploadState = false;
		}else{
			$this->uploadState = true;
		}
	}

	public function isImage(){

		$check = getimagesize($this->FILES[$this->name]["tmp_name"]);
	    if($check !== false) {
	        // echo "File is an image - " . $check["mime"] . ".";
	        // $uploadOk = 1;
	        return array("response"=>1,"mime"=>$check["mime"]);
	    } else {
	        // echo "File is not an image.";
	        // $uploadOk = 0;
	        return array("response"=>"0","mime"=>"");
	    }
	}



	private function extension(){
		$extension = explode('.',$this->FILES[$this->name]['name']);
		// $extension = $extension[count($extension) -1];
		$extension = end($extension);
		return $extension;		
	}


	public function moveTo($dest){

		// Example of accessing data for a newly uploaded file
		$fileName   = $this->info["name"]; 
		$fileTmpLoc = $this->info["tmp"];
		// Path and file name
		$pathAndName = "uploads".$this::DS.$fileName;
		// Run the move_uploaded_file() function here
		$moveResult = move_uploaded_file($fileTmpLoc, $pathAndName);
		// Evaluate the value returned from the function if needed
		if ($moveResult == true) {
		    echo "File has been moved from " . $fileTmpLoc . " to" . $pathAndName;
		} else {
		     echo "ERROR: File not moved correctly";
		}
			
	}

}




// require_once('modules/upload.php');
// $upload = new Upload($_FILES,'file1');
// $upload->moveTo('dkfj');
// echo '<pre>'.print_r($upload->info,true).'</pre>';


 ?>
