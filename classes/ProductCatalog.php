<?php

class ProductCatalog
{
    /**
     * @var Product[]
     */
    private array $products;

    public function __construct()
    {
        $this->products = [
            new Product(1, 'Product 1', 10),
            new Product(2, 'Product 2', 15),
            new Product(3, 'Product 3', 20)
        ];
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}
