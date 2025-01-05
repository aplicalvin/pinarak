<?php

namespace App\Controller;

use App\Database\Database;
use App\Model\Transaction;
use App\Model\TransactionItem;

class TransactionController extends Controller
{
    public function checkout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /#menu');
            exit();
        }

        $total = $_POST['total'];
        $cartIds = $_POST['cart_ids'];

        $cartIds = explode(',', $cartIds);

        $db = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $invoiceNumber = 'INV-' . date('YmdHis') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        $transaction = new Transaction(null, $_SESSION['user_id'], $invoiceNumber, $total, date('Y-m-d H:i:s'), 'completed');

        $db->query("INSERT INTO transactions (user_id, invoice_number, amount, status, date) VALUES (:user_id, :invoice_number, :amount, :status, :date)", [
            'user_id' => $transaction->getUserId(),
            'invoice_number' => $transaction->getInvoice(),
            'amount' => $transaction->getAmount(),
            'status' => $transaction->getStatus(),
            'date' => $transaction->getDate()
        ]);

        $transactionId = $db->lastInsertId();

        foreach ($cartIds as $cartId) {
            $transactionItem = new TransactionItem(null, $transactionId, $cartId);
            $db->query("INSERT INTO transaction_items (transaction_id, cart_id) VALUES (:transaction_id, :cart_id)", [
                'transaction_id' => $transactionItem->getTransactionId(),
                'cart_id' => $transactionItem->getCartId()
            ]);

            $db->query("UPDATE carts SET cart_status = 'abandoned' WHERE id = :cart_id", [
                'cart_id' => $cartId
            ]);
        }
        header('Location: /transaction');
        exit();
    }

    public function getTransaction()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $db = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

        $result = $db->query("SELECT * FROM transactions WHERE user_id = :user_id ORDER BY created_at DESC", [
            'user_id' => $_SESSION['user_id']
        ]);

        $transactions = [];
        foreach ($result as $row) {
            $transactions[] = new Transaction(
                $row['id'],
                $row['user_id'],
                $row['invoice_number'],
                $row['amount'],
                $row['date'],
                $row['status']
            );
        }

        foreach ($transactions as $transaction) {
            $items = $db->query("SELECT ti.*, c.product_id, c.quantity, p.name, p.price, p.image 
                               FROM transaction_items ti 
                               JOIN carts c ON ti.cart_id = c.id 
                               JOIN products p ON c.product_id = p.id 
                               WHERE ti.transaction_id = :transaction_id", [
                'transaction_id' => $transaction->getId()
            ]);
            $transaction->setItems($items);
        }

        $this->render('transaction', [
            'transactions' => $transactions,
        ]);
    }
}
