<?php 
		
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
			// $last_file = $sorted_files[count($sorted_files)-1];
			$last_file = end($sorted_files);
			return $last_file;
		}

		
		function changeExtension($newExtension){

			$this->newExtension = $newExtension;

			$files = $this->files();	
			// print_r($files);
			foreach ($files as $file) {
				preg_replace_callback('/(.+)\.(.+?)$/',function($matches){					
				//	echo $matches[0];
					rename($this->dir.$this->ds.$matches[0],$this->dir.$this->ds.$matches[1].'.'.$this->newExtension);					
					print_r($matches);
				}, 
				$file);				
			}
		}


		function addPrefix($prefix){

			$this->prefix = $prefix;

			$files = $this->files();

			foreach ($files as $file) {
				preg_replace_callback('/(.+)\.(.+?)$/',function($matches){					
				//	echo $matches[0];
					rename($this->dir.$this->ds.$matches[0],$this->dir.$this->ds.$this->prefix.$matches[0]);					
					
				}, 
				$file);				
			}


		}

		function changePrefix($old_prefix,$new_prefix){

			$this->new_prefix = $new_prefix;
			$this->counter = 0;

			$files = $this->files();	

			foreach ($files as $file) {
				preg_replace_callback("/^(".$old_prefix.")(.+?\.(.+?))$/",function($matches){					
				//	echo $matches[0];
					rename($this->dir.$this->ds.$matches[0],$this->dir.$this->ds.$this->new_prefix.$matches[2]);										
				
					$this->counter++;

					print_r($matches);	

				}, 
				$file);				
			}
			return $this->counter;
	
		}

		function removePrefix($prefix){

			return $this->changePrefix($prefix,'');

		}


		function addSuffix($suffix){

			$this->suffix = $suffix;

			$files = $this->files();

			foreach ($files as $file) {
				preg_replace_callback('/(.+)\.(.+?)$/',function($matches){					
				//	echo $matches[0];
					rename($this->dir.$this->ds.$matches[0],$this->dir.$this->ds.$matches[1].$this->suffix.'.'.$matches[2]);										
				}, 
				$file);				
			}

		}

		function changeSuffix($old_suffix,$new_suffix){

			$this->new_suffix = $new_suffix;

			$this->counter = 0;

			$files = $this->files();	

			foreach ($files as $file) {
				preg_replace_callback("/^(.+?)(".$old_suffix.")(\..+?)$/",function($matches){					
				//	echo $matches[0];
					rename($this->dir.$this->ds.$matches[0],$this->dir.$this->ds.$matches[1].$this->new_suffix.$matches[3]);										
				

					// $1_suffix.$3

					$this->counter++;

					print_r($matches);	

				}, 
				$file);				
			}
			return $this->counter;
	
		}

		function removeSuffix($suffix){

			return $this->changeSuffix($suffix,'');			
		}



}


/*	
	examples : 
	==========
*/
	// $dir = new Dir('uploads'); // uploads folder must be at the same level as  this file (Dir.php)

	// $dir->changeExtension('there');
	//echo $dir->last('logo','png');
	
	
	// print_r($dir->files());		
	 
	// print_r($dir->sort('logo','png'));

	/* prefix stuff 
	**************************************************************** 
	|	$dir->addPrefix('_ham');
	|	$dir->removePrefix('_ham');
	|	echo ":" . $dir->changePrefix('_prefix','_replacement');
	****************************************************************/
	
	/* suffix stuff 
	**************************************************************** 
	|	$dir->addSuffix('_ham');
	|	$dir->removeSuffix('_ham');
	|	echo ":" . $dir->changeSuffix('_suffix','_replacement');
	****************************************************************/
?>

