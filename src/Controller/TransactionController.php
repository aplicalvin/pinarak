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

        $transaction = new Transaction(null, $_SESSION['user_id'], $invoiceNumber, $total,  date('Y-m-d H:i:s'), 'completed');

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
        header('Location: /#menu');
        exit();
    }
}
