<?php 

	// condition : files must have the obviously the same prefix and also the same extension 
	// todo : remove the same extension issue
		

class Dir{
		public $directory;
		function __construct($directory){
			$this->directory = $directory;
		}

		/**
		 * list all the files contained within a folder without the default . and .. folders
		 * @return  array $files contains all the files  
		 */
		function files(){
			$files = array();
			if(is_dir($this->directory)){
				$tmp_files = scandir($this->directory);
				for($i=2;$i<count($tmp_files);$i++){
					$files[] = $tmp_files[$i];
				}

			}
			return $files;
		}
		/**
		 * sort a list of file using prefix and extension filters
		 * @param  string prefix    like 'logo_','image_' etc ..
		 * @param  string extension like '.png','.jpg' etc ..
		 * @return array tmp_files list of sorted files
		 */
		function sort($prefix,$extension){
			$tmp_files = $this->files();
			for ($i=0; $i < count($tmp_files) ; $i++) { 
				$tmp_files[$i] = str_replace('.'.$extension, '',$tmp_files[$i]);
			}
			$tmp_files = join(',',$tmp_files);
			$tmp_files = str_replace($prefix, '',$tmp_files);
			$tmp_files = split(',',$tmp_files);	

			//tmp_files now cantains all the file names without the extension and the prefix 
			sort($tmp_files);

			// return back files list with  the prefix and  the extension
			for ($i=0; $i < count($tmp_files) ; $i++) { 
				$tmp_files[$i] = $prefix.$tmp_files[$i].'.'.$extension;
			}
			return $tmp_files;			
		}


		/**
		 * returns the last file name  after sorting 
		 * @param  string prefix    like 'logo_','image_' etc .. 
		 * @param  string extension like '.png','.jpg' etc .. 
		 * @return string the name of last file after sorting 
		 */
		function last($prefix,$extension){
			$sorted_files =  $this->sort($prefix,$extension);
			$last_file = $sorted_files[count($sorted_files)-1];
			return $last_file;
		}
	}


/*	
	examples : 
	==========
*/
	// $dir = new Dir('uploads');
	// print_r($dir->files());		
	//print_r($dir->sort('logo','png'));
	//echo $dir->last('logo','png');
 ?>

