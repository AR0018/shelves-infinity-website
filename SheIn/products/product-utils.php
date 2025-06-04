<?php
/**
 * This file defines some utility functions for product handling.
*/

/**
 * Uploads an image into the server's file system.
 * @param file $img_file The file that must be uploaded
 * @param string $upload_dir the path of the upload directory
 * @return array An associative array containing two elements:
 *  - "success" -> boolean value that tells whether the operation was successful or not
 *  - "message" -> A string with the image name if the operation is successful, an error message otherwise
 */
function upload_image($img_file, $upload_dir) {
    $imageName = basename($img_file["name"]);
    $fullPath = $upload_dir.$imageName;
    
    $maxKB = 500;
    $acceptedExtensions = array("jpg", "jpeg", "png", "gif");
    $result = 0;
    $msg = null;

    $imageSize = getimagesize($img_file["tmp_name"]);
    if($imageSize === false) {
        $msg .= "Il file caricato non è un'immagine! ";
    }

    if ($img_file["size"] > $maxKB * 1024) {
        $msg .= "Il file caricato pesa troppo! La dimensione massima è $maxKB KB. ";
    }

    // Checks file extensions
    $imageFileType = strtolower(pathinfo($fullPath,PATHINFO_EXTENSION));
    if(!in_array($imageFileType, $acceptedExtensions)){
        $msg .= "Sono accettate solo le seguenti estensioni: ".implode(",", $acceptedExtensions);
    }

    // Checks if a file with the same name already exists. In that case, renames the new file.
    if (file_exists($fullPath)) {
        $i = 1;
        do{
            $i++;
            $imageName = pathinfo(basename($img_file["name"]), PATHINFO_FILENAME)."_$i.".$imageFileType;
        }
        while(file_exists($upload_dir.$imageName));
        $fullPath = $upload_dir.$imageName;
    }

    // If there are no errors, copies the image file in the specified upload directory
    if(strlen($msg)==0){
        if(!move_uploaded_file($img_file["tmp_name"], $fullPath)){
            $msg.= "Errore nel caricamento dell'immagine.";
        }
        else{
            $result = 1;
            $msg = $imageName;
        }
    }
    return array("success"=>$result, "message"=>$msg);
}

/**
 * Deletes the given image from the file system.
 * @param string $image_path the name of the image to be removed
 * @param string $upload_dir the path of the upload directory
 */
function delete_image($image_name, $upload_dir) {
    $img_path = $upload_dir.$image_name;
    if(file_exists($img_path)) {
        unlink($img_path);
    }
}
?>