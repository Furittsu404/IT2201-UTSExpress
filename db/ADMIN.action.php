<?php
include 'action.php';
class adminAction extends Database
{
    public function create($email, $form)
    {
        $data = $this->showRecords('userlogin', "WHERE user_Email = '$email'");
        if (count($data) > 0) {
            echo "<script>alert('Email already exists!');</script>";
        } else {
            $user = [];
            $userdata = [];
            foreach ($form as $key => $value) {
                if ($key == 'user_Email' || $key == 'user_Password')
                    $user[$key] = $value;
                else if ($key != 'create') {
                    $input = preg_replace("#[[:punct:]]#", "", $form[$key]);
                    $userdata[$key] = $input;
                }
            }

            $action1 = $this->addRecord($user, 'userlogin');

            $data = $this->showRecords('userlogin', "WHERE user_Email = '$email'");
            $userdata['user_ID'] = $data[0][0];
            $action2 = $this->addRecord($userdata, 'userdata');
            if ($action1 && $action2) {
                echo "<script>alert('Registered Successfully!');</script>";
            } else {
                echo "<script>alert('ERROR! Something went wrong');</script>";
            }
        }
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
        $loc = $directory . '/'.  $key;
        if ($sub != null) 
            $loc .= "/" . $sub;
        if (!file_exists($loc)) {
            @mkdir($loc, 0777, true);
        }
        $tempname = $file[key($file)]["tmp_name"];
        $folder = $loc . "/" . $name . ".png";
        if (move_uploaded_file($tempname, $folder)) {
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
    public function createShop($email, $form)
    {
        $data = $this->showRecords('shoplogin', "WHERE shop_Email = '$email'");
        if (count($data) > 0) {
            echo "<script>alert('Email already exists!');</script>";
        } else {
            $shop = [];
            $shopdata = [];
            foreach ($form as $key => $value) {
                if ($key == 'shop_Email' || $key == 'shop_Password')
                    $shop[$key] = $value;
                else if ($key != 'create') {
                    $shopdata[$key] = $value;
                }
            }

            $action1 = $this->addRecord($shop, 'shoplogin');
            $data = $this->showRecords('shoplogin', "WHERE shop_Email = '$email'");
            $shopdata['shop_ID'] = $data[0][0];
            $action2 = $this->addRecord($shopdata, 'shopdata');
            if ($action1 && $action2) {
                echo "<script>alert('Registered Successfully!');</script>";
                return $shopdata['shop_ID'];
            } else {
                echo "<script>alert('ERROR! Something went wrong');</script>";
            }
        }
    }
    public function createDriver($email, $form)
    {
        $data = $this->showRecords('driverlogin', "WHERE driver_Email = '$email'");
        if (count($data) > 0) {
            echo "<script>alert('Email already exists!');</script>";
        } else {
            $driver = [];
            $driverdata = [];
            foreach ($form as $key => $value) {
                if ($key == 'driver_Email' || $key == 'driver_Password')
                    $driver[$key] = $value;
                else if ($key != 'create') {
                    $driverdata[$key] = $value;
                }
            }

            $action1 = $this->addRecord($driver, 'driverlogin');

            $data = $this->showRecords('driverlogin', "WHERE driver_Email = '$email'");
            $driverdata['driver_ID'] = $data[0][0];
            $action2 = $this->addRecord($driverdata, 'driverdata');
            if ($action1 && $action2) {
                echo "<script>alert('Registered Successfully!');</script>";
            } else {
                echo "<script>alert('ERROR! Something went wrong');</script>";
            }
        }
    }
    public function edit() {
        
    }
}