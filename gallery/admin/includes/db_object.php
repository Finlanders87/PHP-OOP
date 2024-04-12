<?php


class Db_object {
    
    
                // itse tehty error.
    public $errors = array();
    
    public $upload_errors_array = array (
    
    // KEY                        // VALUE
    UPLOAD_ERR_OK           => "There is no error.",
    UPLOAD_ERR_INI_SIZE     => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
    UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was special in the HTML ",
    UPLOAD_ERR_NO_FILE      => "No file was uploaded.",
    UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
    UPLOAD_ERR_CANT_WRITE   => "Failed to wrire file to disk.",
    UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file uplaod."
    
    );
    
        
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
            
            $this->user_image = basename($file['name']); 
            $this->tmp_path = $file['tmp_name'];
            $this->type     = $file['type'];
            $this->size     = $file['size'];  
        }

    } // END OF set_file.
    
    
    
    
    
    // Etsitään kaikki käyttäjät
    public static function find_all(){
                // Käytetään "find_this_query"-functioita.
        return static::find_by_query("SELECT * FROM " . static::$db_table . " ");
    }
    
    
    
    // Etsitään 1 käyttäjä
    public static function find_by_id($id){
    
    global $database;     
    $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id=$id LIMIT 1");    
    return !empty($the_result_array) ? array_shift($the_result_array) : false;   

    }
    
    
    
    
    public static function find_by_query($sql) {
        
    global $database;
    $result_set = $database->query($sql);
    $the_object_array = array();
        
        while($row = mysqli_fetch_array($result_set)) {
                    // Haetaan objekti ja sen ominaisuudet.
            $the_object_array[] = static::instantation($row);
        }
    return $the_object_array;    
    }
            
    
    
    
    
    public static function instantation($the_record){
        
        $calling_class = get_called_class();
        
        $the_object = new $calling_class;

        foreach ($the_record as $the_attribute => $value) {
            
            if($the_object->has_the_attribute($the_attribute)) { 
                $the_object->$the_attribute = $value;
            }
        }   
        return $the_object;
    }
    
    
    
    
    private function has_the_attribute($the_attribute) {
                    // "get_object_vars" ottaa kaikki ominaisuudet (id,username jne)
        $objekt_properties = get_object_vars($this);      
        return array_key_exists($the_attribute, $objekt_properties);   
    }
    
    
    
    
    protected function properties() {
        
        $properties = array();
        
        foreach (static::$db_table_fields as $db_field) {
            
            if(property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }
        
    
    
    
    protected function clean_proterties() {
        
        global $database;
        
        $clean_proterties = array();
        
        foreach($this->properties() as $key => $value) {
            
            $clean_proterties[$key] = $database->escape_string($value); 
        }
        return $clean_proterties;
        
    }
    
    
    
     public function save() {
        
        return isset($this->id) ? $this->update() : $this->create();   
    }
    
    
    
    
    public function create() {
        
        global $database;
        
        $properties = $this->clean_proterties();
        
        $sql = "INSERT INTO " .static::$db_table . "(" .  implode (",", array_keys($properties)) . ")";
        $sql .= "VALUES ('". implode ("','", array_values($properties)) ."')";
        
        if ($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } 
        else {
        return false;
        }
        
    }   // END OF CREATE METHOD
    
    
    
    
    public function update() {
        
        global $database;
        
        $properties = $this->clean_proterties();
        
        $properties_pairs = array();
        
        foreach($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }
        
        $sql = "UPDATE " .static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .=" WHERE id= " . $database->escape_string($this->id);
                                    
        $database->query($sql);
                                                        
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
        
    } // END OF UPDATE METHOT
    
    
    
    
    public function delete() {
        
        global $database;
        
        $sgl = "DELETE FROM  " .static::$db_table . " ";
        $sgl .= "WHERE id=" . $database->escape_string($this->id);
        $sgl .= " LIMIT 1";
        
        $database->query($sgl);
        
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
        
    } // END OF DELETE METHOT
    
    
    
    public static function count_all() {
        
        global $database;
        
        $sql = "SELECT COUNT(*) FROM " . static::$db_table; // COUNT = Laskee
        $result_set = $database->query($sql); 
        $row = mysqli_fetch_array($result_set);
        
        return array_shift($row);
        
    } // END OF count_all METHOT
    

    
    
}


?>