<?php

class Cart
{
    /**
     * @var array
     */
    private array $items;

    /**
     * @var float
     */
    private float $total = 0.0;

    public function __construct()
    {
        $this->items = [];

        SessionManager::initializeCart();
        $cartData = SessionManager::get('cart');

        if (!empty($cartData)) {
            foreach ($cartData as $itemData) {
                if (isset($itemData['product'], $itemData['quantity']) && is_int($itemData['quantity'])) {
                    $productData = $itemData['product'];

                    $product = new Product($productData->getId(), $productData->getName(), $productData->getPrice());
                    $item = new CartItem($product, $itemData['quantity']);
                    $this->items[] = $item;
                }
            }

            $this->calculateTotal();
        }
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return void
     */
    public function add(Product $product, int $quantity): void
    {
        $item = $this->findCartItem($product);

        if ($item) {
            $this->updateCartItem($item, $quantity);
        } else {
            $this->addToCartItem($product, $quantity);
        }

        $this->calculateTotal();
        $this->save();
    }

    /**
     * @param Product $product
     * @return CartItem|null
     */
    private function findCartItem(Product $product): ?CartItem
    {
        foreach ($this->items as $item) {
            /** @var CartItem $item */
            if ($item->getProduct()->getId() === $product->getId()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @param CartItem $item
     * @param int $quantity
     * @return void
     */
    private function updateCartItem(CartItem $item, int $quantity): void
    {
        $item->setQuantity($item->getQuantity() + $quantity);
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return void
     */
    private function addToCartItem(Product $product, int $quantity): void
    {
        $this->items[] = new CartItem($product, $quantity);
    }

    /**
     * @return void
     */
    private function calculateTotal(): void
    {
        $this->total = 0;
        foreach ($this->items as $item) {
            /** @var CartItem $item */
            $this->total += $item->getTotalPrice();
        }
    }

    /**
     * @return void
     */
    private function save(): void
    {
        $cartData = [];

        foreach ($this->items as $item) {
            $cartData[] = [
                'product' => $item->getProduct(),
                'quantity' => $item->getQuantity()
            ];
        }

        SessionManager::set('cart', $cartData);
    }

    /**
     * @return void
     */
    public function getCartHtml(): void
    {
        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                /** @var CartItem $item */
                echo sprintf(
                    "<p><strong>%s:</strong> %s € x %s</p>",
                    $item->getProduct()->getName(),
                    $item->getProduct()->getPrice(),
                    $item->getQuantity()
                );
            }

            echo "<p class='text-xl font-bold underline border-t mt-2 pt-2'>Total: {$this->total} €</p>";
        }
    }

    /**
     * @return void
     */
    public function emptyCart(): void
    {
        $this->items = [];
        $this->total = 0.0;
        SessionManager::set('cart', []);
    }
}
