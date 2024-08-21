<?php

class Product
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var float
     */
    private float $price;

    /**
     * @param int $id
     * @param string $name
     * @param int $price
     */
    public function __construct(int $id, string $name, int $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
