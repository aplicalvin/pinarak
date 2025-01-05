<?php

namespace App\Model;

use App\Controller\Controller;

class TransactionItem extends Controller
{
    private $id;
    private $transactionId;
    private $cartId;

    public function __construct($id, $transactionId, $cartId)
    {
        $this->id = $id;
        $this->transactionId = $transactionId;
        $this->cartId = $cartId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    public function getCartId()
    {
        return $this->cartId;
    }
}

