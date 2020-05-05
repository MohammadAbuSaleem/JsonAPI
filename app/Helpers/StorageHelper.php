<?php 

// Store Image In storage Folder - Compressed and Original
if(!function_exists('storeImage')) {
    function storeImage($image,$folderName ) {

        $path   = $image;
        $path = Storage::putFile("public/$folderName", $image);
 
        return array (
            'org_path'          => $path
        );
    }
}

// Retrieve Paths For Images
if(!function_exists('retrieveImages')) {
    function retrieveImages($image_paths){
        $compressed_path = config('app.host_base_url').Storage::url($image_paths['compressed_path']);       
        $path = config('app.host_base_url').Storage::url($image_paths['org_path']);   
        if ($compressed_path == "/storage/")
                $compressed_path = null;     
        if ($path == "/storage/")
                $path = null;  
              

        if (empty($compressed_path )  || 
            $compressed_path == config('app.host_base_url')."/storage/")      
            $compressed_path = "/storage/";
        if ($compressed_path == "/storage/")
            $compressed_path = config('app.host_base_url').'/img/Doctor_avatar_default.jpg';
        

        return array (
            'compressed_path'   => $compressed_path,
            'org_path'          => $path
        );
    }
}

?>