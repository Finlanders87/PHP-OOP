<?php

class User extends Db_object {
    
    
    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'user_image');
    
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image;
    public $upload_directory = 'images';
    public $image_placeholder = "http://placehold.it/400x400&text=image";
    

    
    
    
    
    public function upload_photo() {
        

        if(!empty($this->errors)) {
            return false;
        }
        // Tiedoston nimi-kohta tyhjä
        if(empty($this->user_image) || empty($this->tmp_path)) {
            $this->errors[] = "The file was not available.";
            return false;
        }
        // Tiedoston menee tähän osoitteeseen. 
        $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
        
        // Onko tiedosto jo olemassa.
        if(file_exists($target_path)) {
            $this->errors[] = "The file {$this->user_image} already exists";
            return false;
        }
        
        // Siirretään tiedosto lopulliseen paikkaan.
        if(move_uploaded_file($this->tmp_path, $target_path)) {
            
                unset($this->tmp_path);
                return true;
        }
        
        // Jos mikään ei toiminut.
        else {
            
            $this->errors[] = "The file directory probably does not have permission.";
            return false;
        }
 
    } // END OF save.
    
    
    
    public function image_path_and_plaseholder() {
        
        
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;
        
        
    }

                        // Tarkistetaan käyttäjä tietokannasta
    
    public static function verify_user($username, $password) {
        
        global $database;
        
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);
        
        $sgl = "SELECT * FROM " .self::$db_table . " WHERE ";
        $sgl .= "username ='{$username}' ";
        $sgl .= "AND password ='{$password}' ";
        $sgl .="LIMIT 1";
        
        $the_result_array = self::find_by_query($sgl);    
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }
    
    
    public function ajax_save_user_image($user_image, $user_id) {
        
        global $database;
        
        $user_image = $database->escape_string($user_image);
        $user_id    = $database->escape_string($user_id);
        
        $this->user_image   = $user_image;
        $this->id           = $user_id;
        
        $sql = "UPDATE " . self::$db_table . " SET user_image = '{$this->user_image}' ";
        $sql .= " WHERE id = {$this->id} ";
        $update_image = $database->query($sql);
        
        echo $this->image_path_and_plaseholder();
    }
        
    public function delete_photo() {
        
        if($this->delete()) {
            
            $target_path = SITE_ROOT.DS.'admin'.DS. $this->upload_directory .DS. $this->user_image;
            
            return unlink($target_path) ? true : false;   
        }
        else {
            
            return false;
        }
    
    } // END OF delete_photo.
    
    
    public function photos() {
        
        return Photo::find_by_query("SELECT * FROM photos WHERE user_id= " . $this->id);
    }

   
}                       // END OF USER CLASS




?>