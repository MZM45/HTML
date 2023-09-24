// checkout.js

document.addEventListener('DOMContentLoaded', function () {
    // Retrieve cart data from localStorage (or from wherever you store it)
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const cartTotal = parseFloat(localStorage.getItem('cartTotal')) || 0.0;

    // Display cart items and total on the checkout page
    const checkoutCartItems = document.getElementById('checkout-cart-items');
    const checkoutTotal = document.getElementById('checkout-total');

    if (cartItems.length > 0) {
        cartItems.forEach(item => {
            const cartItem = document.createElement('li');
            cartItem.textContent = `${item.name} - $${item.price}`;
            checkoutCartItems.appendChild(cartItem);
        });
    } else {
        const noItemsMessage = document.createElement('p');
        noItemsMessage.textContent = 'Your cart is empty.';
        checkoutCartItems.appendChild(noItemsMessage);
    }

    checkoutTotal.textContent = cartTotal.toFixed(2);
});
