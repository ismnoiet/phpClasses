<?php 
class Zip{

	public function extract($file,$destination){
		$zip = new ZipArchive;
		if ($zip->open($file) === TRUE) {
		    $zip->extractTo($destination);
		    $zip->close();
		    echo 'ok';
		} else {
		    echo 'failed';
		}
	}
}

// example
// $zip = new Zip();
// $zip->extract('test.zip','extract');
 ?>
