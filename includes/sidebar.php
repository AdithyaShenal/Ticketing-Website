<!-- Bootstrap & jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Your Cart</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="container-fluid p-0">
            <div class="list-group mb-4">
                <?php
                $subtotal = 0;

                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])):
                    foreach ($_SESSION['cart'] as $item):
                        $itemTotal = $item['price'] * $item['quantity'];
                        $subtotal += $itemTotal;
                ?>
                        <div class="list-group-item d-flex justify-content-between align-items-start" id="cart-item-<?= $item['id'] ?>" data-price="<?= $item['price'] ?>">
                            <div>
                                <div class="fw-semibold"><?= htmlspecialchars($item['title']) ?></div>
                                <small class="text-muted d-block">Date: <?= htmlspecialchars(date('M d, Y', strtotime($item['event_date']))) ?></small>
                                <small class="text-muted d-block">Location: <?= htmlspecialchars($item['location']) ?></small>
                                <button class="btn btn-sm text-danger p-0 mt-1" onclick="removeFromCart(<?= $item['id'] ?>)">
                                    <i class="bi bi-trash"></i> Remove
                                </button>
                            </div>
                            <div class="text-end">
                                <div class="input-group input-group-sm mb-2" style="width: 110px;">
                                    <button class="btn btn-outline-secondary" type="button" onclick="updateCartQuantity(<?= $item['id'] ?>, -1)">-</button>
                                    <input type="text" class="form-control text-center" value="<?= $item['quantity'] ?>" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="updateCartQuantity(<?= $item['id'] ?>, 1)">+</button>
                                </div>
                                <span class="fw-bold">$<?= number_format($itemTotal, 2) ?></span>
                            </div>
                        </div>
                    <?php
                    endforeach;
                else:
                    ?>
                    <div class="list-group-item text-center text-muted">Your cart is empty.</div>
                <?php endif; ?>
            </div>

            <?php if (!empty($_SESSION['cart'])):
                $serviceFee = 5;
                $total = $subtotal + $serviceFee;
            ?>
                <!-- Cart Summary -->
                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span id="subtotal" data-value="<?= $subtotal ?>">$<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Service Fee</span>
                        <span id="service-fee" data-value="<?= $serviceFee ?>">$<?= number_format($serviceFee, 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold border-top pt-2">
                        <span>Total</span>
                        <span id="total">$<?= number_format($total, 2) ?></span>
                    </div>


                    <!-- Checkout Buttons -->
                    <a href="./checkout.php" class="btn btn-primary w-100 mt-4">Proceed to Checkout</a>
                    <button class="btn btn-outline-secondary w-100 mt-2" data-bs-dismiss="offcanvas">Continue Browsing</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>




<script>
    function removeFromCart(id) {
        if (!confirm("Remove this item from your cart?")) return;

        fetch('./remove_from_cart.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const el = document.getElementById('cart-item-' + id);
                    if (el) el.remove();

                    recalculateTotal();

                    const remainingItems = document.querySelectorAll('.list-group-item[data-price]').length;
                    updateCartCount(remainingItems);

                    if (remainingItems === 0) {
                        const listGroup = document.querySelector('.list-group');
                        listGroup.innerHTML = '<div class="list-group-item text-center text-muted">Your cart is empty.</div>';
                        document.querySelector('.border-top')?.remove();
                    }
                } else {
                    alert('Failed to remove item from cart.');
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Error removing item.');
            });
    }

    function recalculateTotal() {
        let subtotal = 0;

        document.querySelectorAll('.list-group-item[data-price]').forEach(item => {
            const price = parseFloat(item.getAttribute('data-price'));
            const quantity = parseInt(item.querySelector('input.form-control').value);
            subtotal += price * quantity;
        });

        const serviceFee = parseFloat(document.getElementById('service-fee')?.dataset.value || 0);
        const total = subtotal + serviceFee;

        const subtotalEl = document.getElementById('subtotal');
        const totalEl = document.getElementById('total');

        if (subtotalEl) {
            subtotalEl.dataset.value = subtotal;
            subtotalEl.innerText = `$${subtotal.toFixed(2)}`;
        }

        if (totalEl) {
            totalEl.innerText = `$${total.toFixed(2)}`;
        }
    }

    function updateCartCount(count) {
        const badge = document.getElementById('cart-count-badge');
        if (badge) {
            badge.textContent = count;
        }
        console.log("Cart count updated to: " + count);
    }
</script>
<style>
    .offcanvas.offcanvas-end {
        background: rgba(255, 255, 255, 0.15);
        /* semi-transparent white */
        backdrop-filter: blur(10px);
        /* blur for frosted effect */
        -webkit-backdrop-filter: blur(10px);
        /* Safari support */
        border-left: 1px solid rgba(255, 255, 255, 0.3);
        /* subtle border */
        color: #fff;
        /* white text for contrast, can be adjusted */
    }

    .offcanvas-title,
    .offcanvas-body,
    .list-group-item,
    .btn,
    .form-control {
        background: transparent !important;
        color: #fff;
    }

    .list-group-item {
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        margin-bottom: 0.5rem;
    }

    .btn-outline-secondary {
        border-color: rgba(255, 255, 255, 0.5);
        color: #fff;
    }

    .btn-outline-secondary:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .form-control {
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    /* Optional: Scrollbar customization */
    .offcanvas-body::-webkit-scrollbar {
        width: 6px;
    }

    .offcanvas-body::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }
</style>