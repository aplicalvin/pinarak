<?php

namespace App\Model;

class Transaction
{
    private $id;
    private $userId;
    private $invoice;
    private $amount;
    private $date;
    private $status;
    private $items = [];

    public function __construct($id, $userId, $invoice, $amount, $date, $status)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->invoice = $invoice;
        $this->amount = $amount;
        $this->date = $date;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getInvoice()
    {
        return $this->invoice;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setItems(array $items): void 
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}