function getCart() {
    return JSON.parse(localStorage.getItem("cart")) || [];
}

const list = document.getElementById("checkoutList");
const totalAmount = document.getElementById("totalAmount");

function renderCheckout() {
    const cart = getCart();
    list.innerHTML = "";

    cart.forEach(item => {
        list.innerHTML += `
            <div class="checkout-item">
                <span>${item.name} × ${item.qty}</span>
                <span>$${(item.price * item.qty).toFixed(2)}</span>
            </div>
        `;
    });

    const total = cart.reduce((sum, i) => sum + i.price * i.qty, 0);
    totalAmount.textContent = "$" + total.toFixed(2);
}

document.getElementById("confirmBtn").addEventListener("click", () => {
    const cart = getCart();
    if (cart.length === 0) return;

    const total = cart.reduce((sum, i) => sum + i.price * i.qty, 0);

    fetch('api_checkout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ cart: cart, total: total })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            localStorage.removeItem("cart");
            window.location.href = "success.php";
        } else {
            alert("Gagal memproses pesanan: " + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});

renderCheckout();
