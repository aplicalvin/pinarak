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
      <a href="#home">Home</a>
      <a href="#about">Tentang Kami</a>
      <a href="#menu">Menu</a>
      <a href="#products">Produk</a>
      <a href="#contact">Kontak</a>
      <?php if (isset($_SESSION['user_id'])): ?>
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

  <!-- Hero Section start -->
  <section class="hero" id="home">
    <div class="mask-container">
      <main class="content">
        <h1>Mari Nikmati Secangkir <span>Kopi</span></h1>
        <p>Bingung mau ngopi dimana? Disini aja</p>
      </main>
    </div>
  </section>
  <!-- Hero Section end -->

  <!-- About Section start -->
  <section id="about" class="about">
    <h2><span>Tentang</span> Kami</h2>

    <div class="row">
      <div class="about-img">
        <img src="img/tentang-kami.jpg" alt="Tentang Kami" />
      </div>
      <div class="content">
        <h3>Kenapa memilih kopi kami?</h3>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur
          ducimus voluptatum dolor. Et, voluptatum accusantium!
        </p>
        <p>
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic
          deserunt iure amet facilis eos a quo cum voluptates molestias nihil.
        </p>
      </div>
    </div>
  </section>
  <!-- About Section end -->

  <!-- Menu Section start -->
  <section id="menu" class="menu">
    <h2><span>Menu</span> Kami</h2>
    <p>
      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Expedita,
      repellendus numquam quam tempora voluptatum.
    </p>

    <div class="row">
      <?php foreach ($products as $product): ?>
        <?php if ($product->getType() === 'menu'): ?>
          <div class="menu-card">
            <img src="<?= $product->getImage() ?>" alt="<?= $product->getName() ?>" class="menu-card-img" />
            <h3 class="menu-card-title">- <?= $product->getName() ?> -</h3>
            <p class="menu-card-price">IDR <?= number_format($product->getPrice(), 0, ',', '.') ?></p>
            <?php if (isset($_SESSION['user_id'])): ?>
              <form action="/add-to-cart" method="post">
                <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="price" value="<?= $product->getPrice() ?>">
                <button type="submit" class="menu-card-button"><i data-feather="shopping-cart"></i></button>
              </form>
            <?php else: ?>
              <button type="button" class="menu-card-button"
                onclick="alert('Silahkan login terlebih dahulu untuk menambahkan ke keranjang')"><i
                  data-feather="shopping-cart"></i></button>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </section>
  <!-- Menu Section end -->

  <!-- Products Section start -->
  <section class="products" id="products">
    <h2><span>Produk Unggulan</span> Kami</h2>
    <p>
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo unde eum,
      ab fuga possimus iste.
    </p>

    <div class="row">
      <?php foreach ($products as $product): ?>
        <?php if ($product->getType() === 'product'): ?>
          <div class="product-card">
            <div class="product-icons">
              <?php if (isset($_SESSION['user_id'])): ?>
                <form action="/add-to-cart" method="post">
                  <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                  <input type="hidden" name="quantity" value="1">
                  <input type="hidden" name="price" value="<?= $product->getPrice() ?>">
                  <button type="submit" class="product-button-cart"><i data-feather="shopping-cart"></i></button>
                </form>
              <?php else: ?>
                <button type="button" class="product-button-cart"
                  onclick="alert('Silahkan login terlebih dahulu untuk menambahkan ke keranjang')"><i
                    data-feather="shopping-cart"></i></button>
              <?php endif; ?>
              <a href="#" class="item-detail-button" data-product-id="<?= $product->getId() ?>"><i
                  data-feather="eye"></i></a>
            </div>
            <div class="product-image">
              <img src="<?= $product->getImage() ?>" alt="<?= $product->getName() ?>" />
            </div>
            <div class="product-content">
              <h3><?= $product->getName() ?></h3>
              <div class="product-stars">
                <?php for ($i = 0; $i < $product->getRating(); $i++): ?>
                  <i data-feather="star" class="star-full"></i>
                <?php endfor; ?>
                <?php for ($i = 0; $i < 5 - $product->getRating(); $i++): ?>
                  <i data-feather="star"></i>
                <?php endfor; ?>
              </div>
              <div class="product-price">IDR <?= number_format($product->getPrice(), 0, ',', '.') ?></div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </section>
  <!-- Products Section end -->

  <!-- Contact Section start -->
  <section id="contact" class="contact">
    <h2><span>Kontak</span> Kami</h2>
    <p>
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis,
      provident.
    </p>

    <div class="row">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.1685207677497!2d110.4283857747577!3d-6.989422093011611!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708dd8f2d67263%3A0xe59b21a6a42ca1ee!2sKedai%20Kopi%20Pinarak!5e0!3m2!1sid!2sid!4v1735538584916!5m2!1sid!2sid"
        width="600" height="450" style="border: 0" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>

      <form action="">
        <div class="input-group">
          <i data-feather="user"></i>
          <input type="text" placeholder="nama" />
        </div>
        <div class="input-group">
          <i data-feather="mail"></i>
          <input type="text" placeholder="email" />
        </div>
        <div class="input-group">
          <i data-feather="phone"></i>
          <input type="text" placeholder="no hp" />
        </div>
        <button type="submit" class="btn">kirim pesan</button>
      </form>
    </div>
  </section>
  <!-- Contact Section end -->

  <!-- Footer start -->
  <footer>
    <div class="socials">
      <a href="#"><i data-feather="instagram"></i></a>
      <a href="#"><i data-feather="twitter"></i></a>
      <a href="#"><i data-feather="facebook"></i></a>
    </div>

    <div class="links">
      <a href="#home">Home</a>
      <a href="#about">Tentang Kami</a>
      <a href="#menu">Menu</a>
      <a href="#contact">Kontak</a>
    </div>

    <div class="credit">
      <p>Created by <a href="">PinarakCoffe</a>. | &copy; 2024.</p>
    </div>
  </footer>
  <!-- Footer end -->

  <!-- Modal Box Item Detail start -->
  <div class="modal" id="item-detail-modal">
    <div class="modal-container">
      <a href="#" class="close-icon"><i data-feather="x"></i></a>
      <?php foreach ($products as $product): ?>
        <?php if ($product->getType() === 'product'): ?>
          <div class="modal-content" data-product-id="<?= $product->getId() ?>">
            <img src="<?= $product->getImage() ?>" alt="<?= $product->getName() ?>" />
            <div class="product-content">
              <h3><?= $product->getName() ?></h3>
              <p>
                <?= $product->getDescription() ?>
              </p>
              <div class="product-stars">
                <?php for ($i = 0; $i < $product->getRating(); $i++): ?>
                  <i data-feather="star" class="star-full"></i>
                <?php endfor; ?>
                <?php for ($i = 0; $i < 5 - $product->getRating(); $i++): ?>
                  <i data-feather="star"></i>
                <?php endfor; ?>
              </div>
              <div class="product-price">IDR <?= $product->getPrice() ?> <span>IDR <?= $product->getPrice() ?></span></div>
              <a href="#"><i data-feather="shopping-cart"></i> <span>add to cart</span></a>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
  <!-- Modal Box Item Detail end -->

  <!-- Payment Method Modal start -->
  <div class="modal-payment" id="payment-modal">
    <div class="modal-payment-container">
      <a href="#" class="close-icon"><i data-feather="x"></i></a>
      <div class="modal-content">
        <?php
        $cartId = [];
        $total = 0;
        foreach ($carts as $cart) {
          $total += $cartProducts[$cart->getProductId()]['price'] * $cart->getQuantity();
          $cartId[] = $cart->getId();
        }
        ?>
        <div class="payment-header">
          <h3>Pilih Metode Pembayaran</h3>
          <p class="payment-total">Total: IDR <span id="modal-total"><?= number_format($total, 0, ',', '.') ?></span></p>
        </div>

        <form action="/checkout" method="post">
          <div class="payment-methods">
            <!-- E-Wallet -->
            <div class="payment-method">
              <input type="radio" id="ewallet" name="payment_method" value="ewallet" required>
              <label for="ewallet" class="payment-label">
                <div class="payment-icon">
                  <i data-feather="smartphone"></i>
                </div>
                <div class="payment-info">
                  <span class="payment-title">E-Wallet</span>
                  <span class="payment-description">OVO, GoPay, DANA, LinkAja</span>
                </div>
                <div class="payment-check">
                  <i data-feather="check-circle"></i>
                </div>
              </label>
            </div>

            <!-- Bank Transfer -->
            <div class="payment-method">
              <input type="radio" id="bank" name="payment_method" value="bank" required>
              <label for="bank" class="payment-label">
                <div class="payment-icon">
                  <i data-feather="credit-card"></i>
                </div>
                <div class="payment-info">
                  <span class="payment-title">Transfer Bank</span>
                  <span class="payment-description">BCA, Mandiri, BNI, BRI</span>
                </div>
                <div class="payment-check">
                  <i data-feather="check-circle"></i>
                </div>
              </label>
            </div>

            <!-- COD -->
            <div class="payment-method">
              <input type="radio" id="cod" name="payment_method" value="cod" required>
              <label for="cod" class="payment-label">
                <div class="payment-icon">
                  <i data-feather="dollar-sign"></i>
                </div>
                <div class="payment-info">
                  <span class="payment-title">Cash on Delivery</span>
                  <span class="payment-description">Bayar saat pesanan tiba</span>
                </div>
                <div class="payment-check">
                  <i data-feather="check-circle"></i>
                </div>
              </label>
            </div>
          </div>

          <div class="payment-footer">
            <p class="payment-note">* Pilih salah satu metode pembayaran di atas</p>
            <input type="hidden" name="total" value="<?= $total ?>">
            <input type="hidden" name="cart_ids" value="<?= implode(',', $cartId) ?>">
            <button type="submit" class="btn payment-button">
              <i data-feather="lock"></i>
              Lanjutkan Pembayaran
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Payment Method Modal end -->

  <!-- Feather Icons -->
  <script>
    feather.replace();
  </script>

  <!-- My Javascript -->
  <script src="js/script.js"></script>
</body>

</html>