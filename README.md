# phpClasses
A repo containing a list of useful php classes

Dir.php file contains Dir Class.<br>
Dir class contains methods to deal with directories and files

*files() :* returns an array containing all the files listed in a given directory(without . and .. folders)
*sort($prefix,$extension)  :* numeric based sorting with prefix
    example if we have the files file1.txt,file2.txt,file3.txt,file11.txt in a directory D
    then if we list the files in that D directory we get them in this order 
   
      file1.txt               file1.txt
      file11.txt    and not   file2.txt
      file2.txt               file3.txt
      file3.txt               file11.txt
      
      this can be useful if we have files with prefixes and numerotation
    
