<?php

namespace App\Controller;

use App\Database\Database;
use App\Model\Cart;
use App\Model\Product;

class HomeController extends Controller
{
    public function index(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $db = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $carts = [];
        $cartProducts = [];

        if (isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) {
            $sessionId = $_SESSION['session_id'];
            $result = $db->query(
                "SELECT c.*, p.name, p.image, p.price 
                 FROM carts c
                 JOIN products p ON c.product_id = p.id 
                 WHERE c.user_id = :user_id 
                 AND c.cart_status = 'active' 
                 AND c.session_id = :session_id",
                [
                    'user_id' => $_SESSION['user_id'],
                    'session_id' => $sessionId
                ]
            );

            foreach ($result as $row) {
                $carts[] = new Cart(
                    $row['id'],
                    $row['session_id'],
                    $row['user_id'],
                    $row['product_id'],
                    $row['quantity'],
                    $row['sub_total'],
                    $row['cart_status']
                );

                $cartProducts[$row['product_id']] = [
                    'name' => $row['name'],
                    'image' => $row['image'],
                    'price' => $row['price']
                ];
            }
        }

        $result = $db->query("SELECT * FROM products");
        $products = [];
        foreach ($result as $row) {
            $products[] = new Product(
                $row['id'],
                $row['name'],
                $row['type'],
                $row['description'],
                $row['price'],
                $row['image'],
                $row['rating']
            );
        }

        $this->render('home', [
            'products' => $products,
            'carts' => $carts,
            'cartProducts' => $cartProducts
        ]);
    }

    public function addToCart(): void
    {
        if (!isset($_POST['product_id']) || !isset($_POST['quantity']) || !isset($_POST['price'])) {
            header('Location: /');
            exit();
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        if (!isset($_SESSION['session_id'])) {
            $_SESSION['session_id'] = uniqid("cart_");
        }
        $sessionId = $_SESSION['session_id'];
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $userId = $_SESSION['user_id'];
        $subtotal = $quantity * $price;

        $cart = new Cart(0, $sessionId, $userId, $productId, $quantity, $subtotal, 'active');
        $db = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $query = "INSERT INTO carts (session_id, user_id, product_id, quantity, sub_total, cart_status) 
                 VALUES (:session_id, :user_id, :product_id, :quantity, :sub_total, :cart_status) 
                 ON DUPLICATE KEY UPDATE 
                    quantity = CASE 
                        WHEN cart_status != 'active' THEN VALUES(quantity)
                        ELSE quantity + VALUES(quantity)
                    END,
                    sub_total = CASE 
                        WHEN cart_status != 'active' THEN VALUES(sub_total)
                        ELSE sub_total + VALUES(sub_total)
                    END,
                    cart_status = 'active'";
        
        $db->query($query, [
            'session_id' => $cart->getSessionId(),
            'user_id' => $cart->getUserId(),
            'product_id' => $cart->getProductId(),
            'quantity' => $cart->getQuantity(),
            'sub_total' => $cart->getSubtotal(),
            'cart_status' => $cart->getStatus()
        ]);
        header('Location: /#menu');
        exit();
    }

    public function removeFromCart(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (
            !isset($_SESSION['user_id']) || !isset($_POST['cart_id']) ||
            !isset($_SESSION['session_id']) || !isset($_POST['product_price'])
        ) {
            header('Location: /login');
            exit();
        }

        $db = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $result = $db->query("SELECT id, quantity, sub_total FROM carts 
            WHERE id = :id 
            AND session_id = :session_id 
            AND user_id = :user_id", [
            'id' => $_POST['cart_id'],
            'session_id' => $_SESSION['session_id'],
            'user_id' => $_SESSION['user_id']
        ]);

        $cartItem = !empty($result) ? $result[0] : null;

        if ($cartItem) {
            if ($cartItem['quantity'] > 1) {
                $productPrice = filter_var($_POST['product_price'], FILTER_VALIDATE_FLOAT);
                if ($productPrice === false) {
                    header('Location: /#menu');
                    exit();
                }

                $db->query("
                    UPDATE carts 
                    SET quantity = quantity - 1,
                        sub_total = sub_total - :product_price 
                    WHERE id = :id 
                    AND session_id = :session_id 
                    AND user_id = :user_id
                ", [
                    'id' => $_POST['cart_id'],
                    'session_id' => $_SESSION['session_id'],
                    'user_id' => $_SESSION['user_id'],
                    'product_price' => $productPrice
                ]);
            } else {
                $db->query("DELETE FROM carts 
                    WHERE id = :id 
                    AND session_id = :session_id 
                    AND user_id = :user_id", [
                    'id' => $_POST['cart_id'],
                    'session_id' => $_SESSION['session_id'],
                    'user_id' => $_SESSION['user_id']
                ]);
            }
        }

        header('Location: /#menu');
        exit();
    }
}
