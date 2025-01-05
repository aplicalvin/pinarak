<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pinarak Coffe</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
    rel="stylesheet" />

  <!-- Feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- My Style -->
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
  } ?>
  <!-- Navbar start -->
  <nav class="navbar">
    <a href="#home" class="navbar-logo">Pinarak<span>Coffe</span>.</a>

    <div class="navbar-nav">
      <a href="/">Home</a>
      <a href="/#about">Tentang Kami</a>
      <a href="/#menu">Menu</a>
      <a href="/#products">Produk</a>
      <a href="/#contact">Kontak</a>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/transaction">Transaksi</a>
        <a href="/logout">Logout</a>
      <?php else: ?>
        <a href="/login">Login</a>
        <a href="/register">Register</a>
      <?php endif; ?>
    </div>

    <div class="navbar-extra">
      <a href="#" id="search-button"><i data-feather="search"></i></a>
      <a href="#" id="shopping-cart-button"><i data-feather="shopping-cart"></i></a>
      <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
    </div>

    <!-- Search Form start -->
    <div class="search-form">
      <input type="search" id="search-box" placeholder="search here..." />
      <label for="search-box"><i data-feather="search"></i></label>
    </div>
    <!-- Search Form end -->

    <!-- Shopping Cart start -->
    <div class="shopping-cart">
      <?php if (empty($carts)): ?>
        <p>Keranjang kosong</p>
      <?php else: ?>
        <?php foreach ($carts as $cart): ?>
          <?php
          if (isset($_SESSION['session_id'])) {
            $sessionId = $_SESSION['session_id'];
          }
          $productId = $cart->getProductId();
          $productInfo = $cartProducts[$productId];
          ?>
          <div class="cart-item">
            <img src="<?= $productInfo['image'] ?>" alt="<?= $productInfo['name'] ?>" />
            <div class="item-detail">
              <h3><?= $productInfo['name'] ?></h3>
              <div class="item-price">IDR <?= number_format($productInfo['price'], 0, ',', '.') ?></div>
              <div class="item-quantity"><?= $cart->getQuantity() ?> item</div>
            </div>
            <form action="/remove-from-cart" method="post">
              <input type="hidden" name="cart_id" value="<?= $cart->getId() ?>">
              <input type="hidden" name="product_price" value="<?= $productInfo['price'] ?>">
              <button type="submit" class="remove-item"><i data-feather="trash-2"></i></button>
            </form>
          </div>
        <?php endforeach; ?>
        <div class="checkout-container">
          <?php
          $total = 0;
          foreach ($carts as $cart) {
            $total += $cartProducts[$cart->getProductId()]['price'] * $cart->getQuantity();
          }
          ?>
          <div class="cart-total">
            Total: IDR <?= number_format($total, 0, ',', '.') ?>
          </div>
          <button type="button" class="checkout-button" id="checkout-button">
            Checkout <i data-feather="shopping-bag"></i>
          </button>
        </div>
      <?php endif; ?>
    </div>
    <!-- Shopping Cart end -->
  </nav>
  <!-- Navbar end -->

  <!-- Transaction Section start -->
  <section class="transaction" id="transaction">
    <h2><span>Riwayat</span> Transaksi</h2>

    <div class="transaction-container">
      <?php if (empty($transactions)): ?>
        <p class="empty-transaction">Belum ada transaksi</p>
      <?php else: ?>
        <?php foreach ($transactions as $transaction): ?>
          <div class="transaction-card">
            <div class="transaction-header">
              <div class="transaction-id">
                Order #<?= $transaction->getInvoice() ?>
              </div>
              <div class="transaction-date">
                <?= date('d M Y H:i', strtotime($transaction->getDate())) ?>
              </div>
            </div>
            
            <div class="transaction-items">
              <?php foreach ($transaction->getItems() as $item): ?>
                <div class="transaction-item">
                  <div class="item-name"><?= $item['name'] ?></div>
                  <div class="item-quantity">x<?= $item['quantity'] ?></div>
                  <div class="item-price">IDR <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></div>
                </div>
              <?php endforeach; ?>
            </div>
            
            <div class="transaction-footer">
              <div class="transaction-total">
                Total: IDR <?= number_format($transaction->getAmount(), 0, ',', '.') ?>
              </div>
              <div class="transaction-status <?= strtolower($transaction->getStatus()) ?>">
                <?= $transaction->getStatus() ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>
  <!-- Transaction Section end -->

  <!-- Feather Icons -->
  <script>
    feather.replace();
  </script>

  <!-- My Javascript -->
  <script src="js/script.js"></script>
</body>

</html>