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
    public function validateFile ($file) {
        $imageFileType = strtolower(pathinfo($file["shop_Image"]["name"],PATHINFO_EXTENSION));
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            exit();
        }
    }
    public function moveFile($key, $file)
    {
        $loc = "../../img/" . $key;
        mkdir($loc, 0755);
        $tempname = $file["shop_Image"]["tmp_name"];
        $folder = "../../img/" . $key . "/" . "shop_Image.jpg";
        if (move_uploaded_file($tempname, $folder)) {
        } else {
            echo "<script>alert('ERROR! Something went wrong');</script>";
        }
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
}