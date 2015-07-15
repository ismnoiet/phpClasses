<?php 
	// condition : files must have obviously the same prefix and also the same extension 
	// todo : remove the same extension issue		
class Dir{
		private $directory;
		public $ds;
		function __construct($directory){
			$this->setDir($directory);
			$this->ds = DIRECTORY_SEPARATOR;
		}

		public function setDir($dir){
			$this->dir = $dir;	
		}
		public function getDir(){
			return $this->dir;
		}
		/**
		 * list all the files contained within a folder without the default . and .. folders
		 * @return  array $files contains all the files  
		 */
		function files(){
			$files = array();
			if(is_dir($this->getDir())){
				$tmp_files = scandir($this->getDir());
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
			// we are ready to sort tmp_files array
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

		// this method must be revised !
		// 
		function changeExtension($newExtension){
			$files = $this->files();	
			// print_r($files);
			foreach ($files as $file) {
				preg_replace_callback('/(.+)\.(.+?)$/',function($matches){					
				//	echo $matches[0];
					rename($this->dir.$this->ds.$matches[0],$this->dir.$this->ds.$matches[1]);					
				}, 
				$file);				
			}
			foreach ($files as $file){
				rename($this->dir.$this->ds.$file, $this->dir.$this->ds.$file.$newExtension);
			}

		}
	}


/*	
	examples : 
	==========
*/
	// $dir = new Dir('uploads');	
	// $dir->changeExtension('.php');
	// print_r($dir->files());		
	// print_r($dir->sort('logo','png'));
	//echo $dir->last('logo','png');

?>

