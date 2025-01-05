<?php

namespace App\Controller;

use App\Database\Database;
use App\Model\User;

class AuthController extends Controller
{
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit();
        }
        $this->render('auth/login');
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            $error = "Semua field harus diisi";
            $this->render('auth/login', ['error' => $error]);
            return;
        }

        try {
            $user = new User(null, null, $_POST['email'], $_POST['password']);
        } catch (\Error $e) {
            $error = "Error creating user object";
            $this->render('auth/login', ['error' => $error]);
            return;
        }

        $db = new Database('localhost', 'pinarak_coffe', 'root', '');
        $query = "SELECT * FROM users WHERE email = :email AND password = :password";
        $result = $db->query($query, [
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);

        if (!empty($result)) {
            $_SESSION['user_id'] = $result[0]['id'];
            $_SESSION['user_email'] = $result[0]['email'];
            $_SESSION['user_name'] = $result[0]['name'];
            
            header('Location: /');
            exit();
        } else {
            $error = "Email atau Password Salah";
            $this->render('auth/login', ['error' => $error]);
        }
    }

    public function logout(): void 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        
        header('Location: /');
    }
}
