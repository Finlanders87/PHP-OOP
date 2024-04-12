<?php

class Photo extends Db_object {
    
    
    protected static $db_table = "photos";
    protected static $db_table_fields = array('id', 'title', 'caption', 'description', 'filename', 'alternate_text', 'type', 'size', 'user_id');
    
    public $id;
    public $title;
    public $caption;
    public $description;
    public $filename;
    public $alternate_text;
    public $type;
    public $size;
    
    public $tmp_path;
    public $upload_directory = "images";        
    public $errors = array();   // itse tehty error.
                
    public $upload_errors_array = array (   // Kertoo mikä on ongelma tiedostoo ladattaessa.
    
    // KEY                        // VALUE
    UPLOAD_ERR_OK           => "There is no error.",
    UPLOAD_ERR_INI_SIZE     => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
    UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was special in the HTML ",
    UPLOAD_ERR_NO_FILE      => "No file was uploaded.",
    UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
    UPLOAD_ERR_CANT_WRITE   => "Failed to wrire file to disk.",
    UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file uplaod."
    
    );
    
    
    
    
            // This is passing ( $file = $_FILES ['uploaded_file'] ) as an argument
    
    public function set_file($file) {
        

                    // Tarkistetaan että kaikki toimii.  || = tai
        if(empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "There is no file uploaded here.";
            return false;
        }
        
                    // Jos virhe on jokin "KEY".
        elseif ($file['error'] !=0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        }
        
                    // Kun kaikki on hyvin.
        else {
            
            $this->filename = basename($file['name']); 
        
            $this->tmp_path = $file['tmp_name'];
            $this->type     = $file['type'];
            $this->size     = $file['size'];  
        }

    } // END OF set_file.
    
    
    
    public function picture_path() {
        
        return $this->upload_directory.DS.$this->filename;
    }
    
    
                // Tiedoston tallennus.
    
    public function save() {
        
                // onko id:tä.
        if($this->id) {
            $this->update();
        }
        else {
            
            if(!empty($this->errors)) {
                return false;
            }
                // Tiedoston nimi-kohta tyhjä
            if(empty($this->filename) || empty($this->tmp_path)) {
                $this->errors[] = "The file was not available.";
                return false;
            }
                    // Tiedoston menee tähän osoitteeseen. 
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;
            
                    // Onko tiedosto jo olemassa.
            if(file_exists($target_path)) {
                $this->errors[] = "The file {$this->filename} already exists";
                return false;
            }
            
                    // Siirretään tiedosto lopulliseen paikkaan.
            if(move_uploaded_file($this->tmp_path, $target_path)) {
                
                if($this->create()) {
                    unset($this->tmp_path);
                    return true;
                }
            }
                    // Jos mikään ei toiminut.
            else {
                
                $this->errors[] = "The file directory probably does not have permission.";
                return false;
            }
            
        }
        
        
    } // END OF save.
    
    
    
    public function delete_photo() {
        
        if($this->delete()) {
            
            $target_path = SITE_ROOT.DS.'admin'.DS. $this->picture_path();
            
            return unlink($target_path) ? true : false;   
        }
        else {
            
            return false;
        }
    } // END OF delete_photo.
    
    
    public function comments() {
        
        return Comment::find_the_comments($this->id);
    }
    
    public static function display_sidebar_data($photo_id) {
        
        $photo = Photo::find_by_id($photo_id);
        
        $output = "<a class='thumbnail' href='#'><img width='100' src='{$photo->picture_path()}'></a> ";
        $output .= "<p>{$photo->filename}</p>";
        $output .= "<p>{$photo->type}</p>";
        $output .= "<p>{$photo->size}</p>";
        
        echo $output;
    }
    
    
    
} // END OF Db_object.






?>