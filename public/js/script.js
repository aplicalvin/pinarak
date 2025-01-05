// Toggle class active untuk hamburger menu
const navbarNav = document.querySelector('.navbar-nav');
// ketika hamburger menu di klik
document.querySelector('#hamburger-menu').onclick = () => {
  navbarNav.classList.toggle('active');
};

// Toggle class active untuk search form
const searchForm = document.querySelector('.search-form');
const searchBox = document.querySelector('#search-box');

document.querySelector('#search-button').onclick = (e) => {
  searchForm.classList.toggle('active');
  searchBox.focus();
  e.preventDefault();
};

// Toggle class active untuk shopping cart
const shoppingCart = document.querySelector('.shopping-cart');
document.querySelector('#shopping-cart-button').onclick = (e) => {
  shoppingCart.classList.toggle('active');
  e.preventDefault();
};

// Klik di luar elemen
const hm = document.querySelector('#hamburger-menu');
const sb = document.querySelector('#search-button');
const sc = document.querySelector('#shopping-cart-button');

document.addEventListener('click', function (e) {
  if (!hm.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove('active');
  }

  if (!sb.contains(e.target) && !searchForm.contains(e.target)) {
    searchForm.classList.remove('active');
  }

  if (!sc.contains(e.target) && !shoppingCart.contains(e.target)) {
    shoppingCart.classList.remove('active');
  }
});

// Modal Box
const itemDetailModal = document.querySelector('#item-detail-modal');
const itemDetailButtons = document.querySelectorAll('.item-detail-button');
const modalContents = itemDetailModal.querySelectorAll('.modal-content');

itemDetailButtons.forEach((btn) => {
  btn.onclick = (e) => {
    // e.preventDefault();
    const productId = this.getAttribute('data-product-id');

    // modalContents.forEach(content => {
    //   content.style.display = 'none';
    // });

    const targetContent = modal.querySelector(`.modal-content[data-product-id="${productId}"]`);
    if (targetContent) {
      targetContent.style.display = 'flex';
    }
  };
});

// klik tombol close modal
document.querySelector('.modal .close-icon').onclick = (e) => {
  itemDetailModal.style.display = 'none';
  e.preventDefault();
};

// klik di luar modal
window.onclick = (e) => {
  if (e.target === itemDetailModal) {
    itemDetailModal.style.display = 'none';
  }
};

// klik tombol checkout
const checkoutBtn = document.querySelector('#checkout-button');
const paymentModal = document.querySelector('#payment-modal');
const closePaymentModal = paymentModal.querySelector('.close-icon');

window.onload = () => {
  paymentModal.style.display = 'none';
}

checkoutBtn.onclick = (e) => {
  paymentModal.style.display = 'flex';
  shoppingCart.classList.toggle('active');
  e.preventDefault();
}

closePaymentModal.onclick = (e) => {
  e.preventDefault();
  paymentModal.style.display = 'none';
}

window.onclick = (e) => {
  if (e.target === paymentModal) {
    paymentModal.style.display = 'none';
  }
}