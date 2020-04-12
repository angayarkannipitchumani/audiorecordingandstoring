<?php
define('DB_SERVER', 'localhost:3308');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'user');
 /* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME,DB_PASSWORD, DB_NAME);
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors


    if(isset($_FILES["photo"])){
//isset($_FILES["photo"])
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

else
{

        $allowed = array("wav" => "audio/wav");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];
 
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists("uploads/" . $filename)){
                echo $filename . " is already exists.";
            } else{
$audio_path="uploads/" . $filename;
echo $audio_path;
                move_uploaded_file($_FILES["photo"]["tmp_name"], "uploads/" . $filename);
                echo "Your file was uploaded successfully.";
$query = "INSERT INTO audiorecord(audio) VALUES('$audio_path')";
  echo $query;
$result=mysqli_query($link, $query);

if($result)
{
echo 'Successfully Inserted';
echo '<div content="Content-Type: audio/wav">
                    <audio controls="controls" preload="metadata">
                        <source src="' . $audio_path . '">;
                    </audio>
                </div>';
echo '<font color="green"><b>Completed All Activities Successfully </b></font>';
}

else
echo 'error';
            } 
        } else{
            echo "Error: There was a problem uploading your file. Please try again."; 
        }
    } 
}
else{
        echo "Error: " . $_FILES["photo"]["error"];
    }
}
?>