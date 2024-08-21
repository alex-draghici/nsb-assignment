<?php

require_once 'autoload.php';
session_start();

$catalog = new ProductCatalog();
$cart = new Cart();

if (isset($_GET['empty_cart'])) {
    $cart->emptyCart();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_GET['add_to_cart']) && isset($_GET['quantity'])) {
    $productId = (int)$_GET['add_to_cart'];
    $quantity = (int)$_GET['quantity'];
    $product = array_filter($catalog->getProducts(), fn($p) => $p->getId() === $productId);

    if ($product) {
        $cart->add(reset($product), $quantity);
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shopping Cart</title>
        <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    </head>

    <body class="bg-gray-100 m-20 antialiased">
        <div class="grid grid-cols-2 gap-6 mx-auto max-w-screen-xl p-3">
            <div id="products">
                <h1 class="text-3xl font-bold mb-3">Shopping Cart</h1>
                <div class="flex flex-col gap-2">
                    <?php foreach ($catalog->getProducts() as $product): ?>
                        <div class="flex gap-3 items-center justify-between p-3 w-full bg-white rounded-xl">
                            <div class="data">
                                <h3 class="font-bold"><?= htmlspecialchars($product->getName()) ?></h3>
                                <p class="text-green-700 font-bold"><?= htmlspecialchars($product->getPrice()) ?>€</p>
                            </div>

                            <form class="flex gap-4 items-center" action="" method="GET">
                                <input type="hidden" name="add_to_cart" value="<?= htmlspecialchars($product->getId()) ?>">
                                <label for="quantity">Qty:</label>
                                <input class="w-20 border-gray-400 rounded-xl" type="number" id="quantity" name="quantity" value="1" min="1">
                                <button class="px-3 py-1.5 rounded-xl bg-green-700 text-white font-bold" type="submit">Add to Cart</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div id="cart">
                <div class="flex flex-col gap-3">
                    <h2 class="text-3xl font-bold">Cart</h2>
                    <?php if (!empty(SessionManager::get('cart'))): ?>
                        <div class="flex flex-col gap-2 p-3 bg-white rounded-xl">
                            <?php $cart->getCartHtml(); ?>
                        </div>

                        <form action="" method="GET">
                            <button class="px-3 py-1.5 rounded-xl bg-red-700 text-white font-bold" type="submit" name="empty_cart" value="1">Empty Cart</button>
                        </form>
                    <?php else: ?>
                        <div class="info p-3 bg-white rounded-xl text-gray-600">
                            <p>Cart is empty. Add to cart!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
