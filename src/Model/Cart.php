<?php

namespace App\Model;

class Cart
{
    private int $id;
    private string $sessionId;
    private int $userId;
    private int $productId;
    private int $quantity;
    private int $subtotal;
    private string $status;

    public function __construct(int $id, string $sessionId, int $userId, int $productId, int $quantity, int $subtotal, string $status)
    {
        $this->id = $id;
        $this->sessionId = $sessionId;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->subtotal = $subtotal;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getSubtotal(): int
    {
        return $this->subtotal;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

}