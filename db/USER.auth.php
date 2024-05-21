<?php
include 'action.php';
include 'cartAction.php';

class Authentication extends Database
{

    public function login($email, $password)
    {
        $cart = new cart($this->conn);
        $data = $this->showRecords('userlogin', "WHERE user_Email = '$email'");
        $isadmin = $this->showRecords('adminlogin', "WHERE admin_Email = '$email'");
        $isshop = $this->showRecords('shoplogin', "WHERE shop_Email = '$email'");
        $isdriver = $this->showRecords('driverlogin', "WHERE driver_Email = '$email'");
        if (count($data) > 0) {
            if (password_verify($password, $data[0][2])) {
                $user_ID = $data[0][0];
                $_SESSION['user_ID'] = $user_ID;
                $data2 = $this->showRecords('userdata', "WHERE user_ID = '$user_ID'");
                $_SESSION['user_Nickname'] = $data2[0][2];
                $_SESSION['user'] = true;
                $_SESSION['cart'] = $cart->getCart() ?? [];
                echo "<script>window.location.href='../';</script>";
                exit();
            }
        }
        if (count($isadmin) > 0) {
            if (password_verify($password, $isadmin[0][3])) {
                $_SESSION['user_ID'] = $isadmin[0][0];
                $_SESSION['user_Nickname'] = $isadmin[0][1];
                $_SESSION['admin'] = true;
                $_SESSION['cart'] = [];
                echo "<script>window.location.href='../admin';</script>";
                exit();
            }

        }
        if (count($isshop) > 0) {
            if (password_verify($password, $isshop[0][2])) {
                $shop_ID = $isshop[0][0];
                $_SESSION['user_ID'] = $shop_ID;
                $data2 = $this->showRecords('shopdata', "WHERE shop_ID = '$shop_ID'");
                $_SESSION['user_Nickname'] = $data2[0][1];
                $_SESSION['shop'] = true;
                $_SESSION['cart'] = [];
                echo "<script>window.location.href='../';</script>";
                exit();
            }
        }
        echo "<script>alert('Wrong Password!');</script>";


    }

    public function register($email, $form)
    {
        $_SESSION['cart']=[];
        $data = $this->showRecords('userlogin', "WHERE user_Email = '$email'");
        if (count($data) > 0) {
            echo "<script>alert('Email already exists!');</script>";
            echo "<script>window.location.href='#reg';</script>";
        } else {
            $user = [];
            $userdata = [];
            foreach ($form as $key => $value) {
                if ($key == 'user_Email' || $key == 'user_Password')
                    $user[$key] = $value;
                else if ($key != 'register') {
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

    public function forgotPassword($email)
    {
        header("Location: #");
    }
}


?>
