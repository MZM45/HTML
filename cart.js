document.addEventListener('DOMContentLoaded', function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const cartItemsList = document.querySelector('.cart-items');
    const cartTotal = document.querySelector('.cart-total');

    let cart = [];

    // Function to update the cart display
    function updateCart() {
        cartItemsList.innerHTML = '';
        let total = 0;

        cart.forEach((item, index) => {
            const cartItem = document.createElement('li');
            cartItem.textContent = `${item.name} - $${item.price}`;

            // Add a "Remove" button for each item
            const removeButton = document.createElement('button');
            removeButton.textContent = 'Remove';
            removeButton.classList.add('remove-item');
            removeButton.dataset.index = index;
            removeButton.addEventListener('click', function() {
                cart.splice(index, 1);
                updateCart();
            });

            cartItem.appendChild(removeButton);

            cartItemsList.appendChild(cartItem);
            total += parseFloat(item.price);
        });

        cartTotal.textContent = `$${total.toFixed(2)}`;
    }

    // Event listener for "Add to Cart" buttons
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const name = button.getAttribute('data-name');
            const price = button.getAttribute('data-price');

            cart.push({ name, price });
            updateCart();
        });
    });

    // Event listener for "Remove" buttons (added dynamically)
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-item')) {
            const index = event.target.dataset.index;
            cart.splice(index, 1);
            updateCart();
        }
    });
});
