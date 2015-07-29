<?php 
class Zip{
	public $destination;
	public $file;
	public $files; 
	const DS  = DIRECTORY_SEPARATOR;

	function __construct(){

		$this->zipApi = new ZipArchive;		
		$this->files = array();

	}

	private function isZip($file){

		return $this->zipApi->open($file);	

	}

	public function content($file){

		if($this->isZip($file)){

			for( $i = 0; $i < $this->zipApi->numFiles; $i++ ){ 
			    $stat = $this->zipApi->statIndex( $i ); 
			    $this->files[] = $stat['name'];
			    // print_r($stat);
			    // print_r( basename( $stat['name'] ) . PHP_EOL ); 
			}
		}

	}

	public function extract($file,$destination){

		$zip = new ZipArchive;
		$this->file = $file;
		if ($zip->open($file) === TRUE) {
		    $zip->extractTo($destination);
		    $zip->close();

		    // unlink($file);
		    // echo 'ok';
		} else {
		    die('failed');		    
		}

	}

	public function add($file){
		
	}


	function show(){
		return $this->files;
	}

	function extractExtension(){

	}

	function removeFile($file,$path=null){
		
	}
	
	function addFile($file,$path=null){

	}


}

// example
$zip = new Zip();
$zip->content('test.zip');

print_r($zip->show());

// $zip->extract('test.zip','extract');

// \.([^.]+)$
 ?>
