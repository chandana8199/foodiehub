// Load cart from localStorage if it exists
let cart = JSON.parse(localStorage.getItem('cart')) || [];
console.log("Cart from localStorage:", cart); // Debug

// Update cart display
function updateCart() {
    const cartContainer = document.getElementById('cart');
    let total_price = 0;
    let html = '';

    if (cart.length > 0) {
        cart.forEach((item, index) => {
            const itemTotal = parseFloat(item.price) * item.quantity;
            total_price += itemTotal;

            html += `
                <div class="cart-item">
                    <h3>${item.name}</h3>
                    <p>Quantity: ${item.quantity}</p>
                    <p>Price: ₹${item.price} x ${item.quantity} = ₹${itemTotal.toFixed(2)}</p>
                    <button onclick="removeItem(${index})">Remove</button>
                </div>
            `;
        });

        const delivery_fee = total_price < 500 ? 40 : 0;
        const gst = Math.round(total_price * 0.15); // 15% GST
        const final_amount = total_price + gst + delivery_fee;

        html += `
            <div class="cart-summary">
                <p>Total Price: ₹${total_price.toFixed(2)}</p>
                <p>Delivery Fee: ₹${delivery_fee}</p>
                <p>GST (15%): ₹${gst}</p>
                <p><strong>Final Amount: ₹${final_amount.toFixed(2)}</strong></p>
            </div>
            <button class="place-order-btn" onclick="placeOrder()">Place Order</button>
        `;
    } else {
        html = `<p>Your cart is empty.</p>`;
    }

    cartContainer.innerHTML = html;
    localStorage.setItem('cart', JSON.stringify(cart)); // Always update localStorage
}

// Remove an item from the cart
function removeItem(index) {
    cart.splice(index, 1);
    updateCart();
}

// Place order
function placeOrder() {
    if (cart.length === 0) {
        alert("Cart is empty!");
        return;
    }

    let total_price = 0;
    cart.forEach(item => {
        total_price += parseFloat(item.price) * item.quantity;
    });

    const delivery_fee = total_price < 500 ? 40 : 0;
    const gst = Math.round(total_price * 0.15);
    const final_amount = total_price + gst + delivery_fee;
    const itemsList = cart.map(item => `${item.name} (x${item.quantity})`).join(", ");

    const orderData = {
        items: itemsList,
        total_price,
        delivery_fee,
        gst,
        final_amount
    };

    fetch('api/place_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(orderData)
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            // Save order details in localStorage for confirmation page
            localStorage.setItem('last_order_items', itemsList);
            localStorage.setItem('last_order_total', total_price);
            localStorage.setItem('last_order_delivery', delivery_fee);
            localStorage.setItem('last_order_gst', gst);
            localStorage.setItem('last_order_final', final_amount);
        
            // Clear cart and redirect
            cart = [];
            localStorage.removeItem('cart');
            updateCart();
            window.location.href = `order_confirmation.html?order_id=${response.order_id}`;
        }
        
        
         else {
            alert("Failed to place order: " + response.error);
        }
    })
    .catch(error => {
        console.error("Error placing order:", error);
        alert("Failed to place order.");
    });
}

// Initial call to populate cart on page load
updateCart();
