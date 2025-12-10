function getCart() {
    return JSON.parse(localStorage.getItem("cart")) || [];
}

function saveCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
}

const list = document.getElementById("cartList");
const totalAmount = document.getElementById("totalAmount");

function renderCart() {
    const cart = getCart();
    list.innerHTML = "";

    if (cart.length === 0) {
        list.innerHTML = "<p>Cart kosong.</p>";
        totalAmount.textContent = "$0.00";
        return;
    }

    cart.forEach((item, i) => {
        list.innerHTML += `
            <div class="cart-item">
                <img src="${item.img}" class="cart-img">

                <div class="cart-info">
                    <div class="cart-title">${item.name}</div>
                    <div class="cart-price">$${item.price}</div>

                    <div class="qty-row">
                        <button class="qty-btn" onclick="changeQty(${item.id}, -1)">−</button>
                        <span class="qty-num">${item.qty}</span>
                        <button class="qty-btn" onclick="changeQty(${item.id}, 1)">+</button>
                    </div>
                </div>

                <button class="remove-btn" onclick="removeItem(${item.id})">✕</button>
            </div>
        `;
    });

    updateTotal();
}

function updateTotal() {
    const cart = getCart();
    const total = cart.reduce((sum, i) => sum + i.price * i.qty, 0);
    totalAmount.textContent = "$" + total.toFixed(2);
}

function changeQty(id, delta) {
    const cart = getCart();
    const idx = cart.findIndex(i => i.id === id);

    if (idx !== -1) {
        if (cart[idx].qty === 1 && delta === -1) {
            return; 
        }

        cart[idx].qty += delta;
    }

    saveCart(cart);
    renderCart();
}

function removeItem(id) {
    let cart = getCart();
    cart = cart.filter(i => i.id !== id);
    saveCart(cart);
    renderCart();
}

document.getElementById("checkoutBtn").addEventListener("click", () => {
    const cart = getCart();

    if (cart.length === 0) {
        alert("Keranjang masih kosong. Tambahkan produk terlebih dahulu.");
        return;
    }

    window.location.href = "checkout.php";
});


renderCart();
