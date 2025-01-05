<?php

namespace App\Model;

class Product
{
    private int $id;
    private string $name;
    private string $type;
    private string $description;
    private int $price;
    private string $image;
    private int $rating;

    public function __construct(int $id, string $name, string $type, string $description, int $price, string $image, int $rating)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
        $this->rating = $rating;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }   

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }   

    public function getImage(): string
    {
        return $this->image;
    }   

    public function getRating(): int
    {
        return $this->rating;
    }       

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }
}
