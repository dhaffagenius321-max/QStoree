const container = document.getElementById("productList");
const cartCount = document.getElementById("cartCount");

function renderProducts(list) {
    container.innerHTML = "";
    list.forEach(p => {
        container.innerHTML += `
        <div class="card">
            <img src="${p.img}">
            <div class="card-body">
                <div class="card-title">${p.name}</div>
                <div class="card-desc">${p.desc}</div>

                <div class="price-row">
                    <div class="price">$${p.price}</div>
                    <button class="add-btn" onclick="addToCart(${p.id})">Add</button>
                </div>
            </div>
        </div>
        `;
    });
}

if (typeof products !== 'undefined') {
    renderProducts(products);
}

function getCart() {
    return JSON.parse(localStorage.getItem("cart")) || [];
}

function saveCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
}

function updateCartCount() {
    const cart = getCart();
    if(cartCount) cartCount.textContent = cart.length;
}

updateCartCount();

function addToCart(id) {
    const cart = getCart();
    const index = cart.findIndex(i => i.id === id);

    if (index !== -1) {
        cart[index].qty += 1;
    } else {
        const product = products.find(p => p.id === id);
        if(product) {
            cart.push({ ...product, qty: 1 });
        }
    }

    saveCart(cart);
    updateCartCount();
}

const openCartBtn = document.getElementById("openCart");
if(openCartBtn) {
    openCartBtn.addEventListener("click", () => {
        window.location.href = "cart.php";
    });
}

const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const menuToggle = document.getElementById("menuToggle");

if(menuToggle) {
    menuToggle.addEventListener("click", () => {
        sidebar.classList.add("open");
        overlay.classList.add("show");
    });
}

if(overlay) {
    overlay.addEventListener("click", () => {
        sidebar.classList.remove("open");
        overlay.classList.remove("show");
    });
}