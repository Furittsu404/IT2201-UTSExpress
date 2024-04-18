<?
class cart {

    public function __construct() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }
    public function getCart($conn) {
        $userId = $_SESSION['user_ID'];
        $cart = mysqli_query($conn,"SELECT * FROM cartItems WHERE user_ID = $userId");
        $cart = mysqli_fetch_assoc($cart);
        $cart = json_decode($cart['product_ID'],true);
        return $cart;
    }
    public function addCart() {
        $productId = $_POST['id'];
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]++;
        } else {
            $_SESSION['cart'][$productId] = 1;
        }
        echo array_sum($_SESSION['cart']);
    }
    public function saveCart($conn) {
        $cart = $_SESSION['cart'];
        $cart = json_encode($cart);
        $userId = $_SESSION['user_ID'];
        mysqli_query($conn,"UPDATE cartItems SET product_ID = '$cart' WHERE user_ID = $userId");
    }
}
