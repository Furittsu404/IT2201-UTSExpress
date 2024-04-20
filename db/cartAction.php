<?php
class cart
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getCart()
    {
        $userId = $_SESSION['user_ID'];
        $sql = "SELECT * FROM cartItems WHERE user_ID = $userId";
        $result = $this->conn->query($sql);
        $cart = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data_row = array();
                foreach ($row as $r) {
                    array_push($data_row, $r);
                }
                array_push($cart, $data_row);
            }
        } else {
            return [];
        }
        $cart = json_decode($cart[0][2], true);
        foreach ($cart as $id => $quantity) {
            $itemData = $this->conn->query("SELECT * FROM shopproducts WHERE product_ID = '$id'");
            if ($itemData->num_rows == 0) {
                unset($cart[$id]);
                continue;
            }
        }
        return $cart;
    }
    public function validateCart() {
        $cart = $_SESSION['cart'];
        $newCart = [];
        foreach ($cart as $id => $quantity) {
            $itemData = $this->conn->query("SELECT * FROM shopproducts WHERE product_ID = '$id'");
            if ($itemData->num_rows > 0) {
                $newCart[$id] = $quantity;
            }
        }
        $_SESSION['cart'] = $newCart;
        if (isset($_SESSION['user_ID'])) {
            $this->saveCart();
        }
    }
    public function addCart()
    {
        $productId = $_POST['id'];
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]++;
        } else {
            $_SESSION['cart'][$productId] = 1;
        }
        echo sizeof($_SESSION['cart']);
    }
    public function saveCart()
    {
        $cart = $_SESSION['cart'];
        $cart = json_encode($cart);
        $ID = $_SESSION['user_ID'];
        $this->conn->query("SELECT * FROM cartItems WHERE user_ID = $ID");
        if ($this->conn->affected_rows > 0) {
            $this->conn->query("UPDATE cartItems SET cart_Products = '$cart' WHERE user_ID = $ID");
        } else {
            $this->conn->query("INSERT INTO cartItems (user_ID, cart_Products) VALUES ($ID, '$cart')");
        }
    }
    public function deleteCart()
    {
        $productId = $_POST['id'];
        if (isset($_SESSION['cart'][$productId])) {
            if ($_SESSION['cart'][$productId] > 1) {
                $_SESSION['cart'][$productId]--;
            } else if ($_SESSION['cart'][$productId] == 1) {
                unset($_SESSION['cart'][$productId]);
            }
        }
        echo sizeof($_SESSION['cart']);
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $quantity) {
            $itemData = $this->conn->query("SELECT * FROM shopproducts WHERE product_ID = '$id'");
            $itemData = $itemData->fetch_all();
            $total += $itemData[0][2] * $quantity;
        }
        return $total;
    }
}
