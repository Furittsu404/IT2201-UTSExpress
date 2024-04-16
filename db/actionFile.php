<?php
include 'action.php';
class File extends Database
{
    public function addProduct($form)
    {
        $product = [];
        foreach ($form as $key => $value) {
            if ($key != 'create') 
                $product[$key] = $value;
        }
        $action1 = $this->addRecord($product, 'shopproducts');
        if (!$action1) 
            echo "<script>alert('Product not added! Something went wrong.');</script>";
    }
    public function validateFile($file, $key)
    {
        $check = getimagesize($file[$key]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File is not an image.');</script>";
            echo "<script>window.location.href='';</script>";
            exit();
        }
        $imageFileType = strtolower(pathinfo($file[$key]["name"], PATHINFO_EXTENSION));
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        ) {
            echo "<script>alert('Sorry, only JPG, JPEG & PNG Files are allowed.');</script>";
            echo "<script>window.location.href='';</script>";
            exit();
        }
    }
    public function moveFile($key, $name, $file, $directory, $sub = null)
    {
        $loc = $directory . '/' . $key;
        if ($sub != null)
            $loc .= "/" . $sub;
        if (!file_exists($loc)) {
            @mkdir($loc, 0777, true);
        }
        $tempname = $file[key($file)]["tmp_name"];
        $folder = $loc . "/" . $name . ".png";
        if (move_uploaded_file($tempname, $folder)) {
            $data['product_Image'] = $name . ".png";
            $this->updateRecord($data,'shopproducts',['product_ID' => $name]);
        } else {
            echo "<script>alert('ERROR! Something went wrong');</script>";
        }
    }
    function deleteDir(string $dirPath): void
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}