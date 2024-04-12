<?php 


if(isset($_POST['submit'])) {
    
    //echo "<pre>";

    //print_r($_FILES['file_upload']);

    //echo "<pre>";
    
    $upload_errors = array (
    
    // KEY                        // VALUE
    UPLOAD_ERR_OK           => "There is no error.",
    UPLOAD_ERR_INI_SIZE     => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
    UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was special in the HTML ",
    UPLOAD_ERR_NO_FILE      => "No file was uploaded.",
    UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
    UPLOAD_ERR_CANT_WRITE   => "Failed to wrire file to disk.",
    UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file uplaod."
    
    );
    
    $temp_name = $_FILES['file_upload']['tmp_name'];
    $the_file = $_FILES['file_upload']['name'];
    $directory = "uploads";
    
    
    // Siirretään tiedosto "True or False".
    if(move_uploaded_file($temp_name, $directory . "/" . $the_file)) {
        
        // Kun on onnistunut.
        $the_message = "File uploaded successfully";
    }
    else {
        // Jos on ongelma.
        $the_error = $_FILES['file_upload']['error'];
        $the_message = $upload_errors[$the_error];    
    }
    
    
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    
    <form action="upload.php" enctype="multipart/form-data" method="post">
      
        <h2>
            
            <?php 
            
            
            if(!empty($upload_errors)) {
    
                echo $the_message;
    
    
    
            } 
            ?>
            
        </h2>  
      
       
        <input type="file" name="file_upload"><br>
        
        <input type="submit" name="submit">
    </form>
    
    
    
</body>
</html>