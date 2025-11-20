<?php 
include 'includes/header.php';

// Handle remove single item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    $id = intval($_POST['remove_id']);
    if (!empty($_SESSION['enquiry'][$id])) {
        unset($_SESSION['enquiry'][$id]);
    }
}

// Handle clear cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_cart'])) {
    $_SESSION['enquiry'] = [];
}

// Get current cart
$cart = $_SESSION['enquiry'] ?? [];

// Initialize total cost variable
$total_cost = 0; 
?> 

<div class="container py-5">
    <h1>Enquiry Cart</h1>

    <?php if (empty($cart)): ?>
        <div class="alert alert-info">Your enquiry cart is empty.</div>
    <?php else: ?>
        
        <div class="row">
            
            <div class="col-lg-8">
                
                <?php foreach ($cart as $product_id => $item): ?>
                    
                    <?php
                        // Calculate Subtotal and update Grand Total
                        $quantity = $item['quantity'] ?? 1;
                        $subtotal = $item['price'] * $quantity;
                        $total_cost += $subtotal;
                    ?>

                    <div class="card mb-3 cart-item-card shadow-sm border">
                        <div class="card-body p-3">
                            <div class="row g-0 align-items-center">
                                
                                <div class="col-md-3 d-flex justify-content-center">
                                    <img src="assets/images/<?php echo htmlspecialchars($item['image']); ?>" 
                                         class="img-fluid rounded" 
                                         alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                         style="max-height: 120px; width: 100px; object-fit: contain;">
                                </div>
                                
                                <div class="col-md-6 ps-md-4">
                                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($item['title']); ?></h5>
                                    <p class="text-muted small mb-3">ID: <?php echo htmlspecialchars($item['id']); ?></p>
                                    
                                 <div class="d-flex align-items-center mb-3">
                                  <form method="POST" action="update_cart.php" class="d-flex align-items-center">
                                 <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        
                                 <label class="me-2 mb-0 small text-muted">Quantity:</label>
        
                                 <div class="input-group input-group-sm" style="width: 130px;">
                                 <button class="btn btn-outline-secondary btn-sm" type="submit" name="action" value="decrease" style="padding: 0 8px;">
                                  <i class="fas fa-minus"></i>
                                   </button>
            
            <input type="text" 
                   name="quantity" 
                   class="form-control text-center" 
                   value="<?php echo htmlspecialchars($quantity); ?>" 
                   readonly 
                   style="height: 30px; font-weight: bold;">
            
            <button class="btn btn-outline-secondary btn-sm" type="submit" name="action" value="increase" style="padding: 0 8px;">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </form>
</div>
                                    <div class="d-flex small pt-2">
                                        
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="remove_id" value="<?php echo $product_id; ?>">
                                            <button type="submit" class="btn btn-link text-decoration-none text-danger p-0 fw-bold"
                                                    onclick="return confirm('Remove this item from cart?');">
                                                REMOVE
                                            </button>
                                        </form>
                                        <span class="text-muted mx-2">|</span>
                                        <a href="product.php?id=<?php echo $product_id; ?>" class="btn btn-link text-decoration-none p-0">View Product</a>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 text-end">
                                    <div class="mb-2">
                                        <span class="text-muted small me-2">Unit Price:</span>
                                        <span class="fw-normal">₹<?php echo number_format($item['price'], 2); ?></span>
                                    </div>
                                    <p class="fw-bold fs-5 mb-0">Total: ₹<?php echo number_format($subtotal, 2); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div class="d-flex justify-content-between mt-4 p-3 bg-light rounded shadow-sm">
                    <form method="post">
                        <input type="hidden" name="clear_cart" value="1">
                        <button type="submit" class="btn btn-warning"
                                onclick="return confirm('Are you sure you want to clear the entire cart?');">
                            Clear Cart
                        </button>
                    </form>
                    
                    <a href="contact.php?enquiry=1" class="btn btn-success btn-lg">Proceed to Enquiry</a>
                </div>
                
            </div>
            
            <div class="col-lg-4">
                <div class="card sticky-top shadow-sm" style="top: 80px;">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">PRICE DETAILS</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Price (<?php echo count($cart); ?> items)</span>
                            <span>₹<?php echo number_format($total_cost, 2); ?></span> 
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Shipping/Service Charge</span>
                            <span>Free</span> 
                        </div>
                        
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                            <span>Total Payable Amount</span>
                            <span>₹<?php echo number_format($total_cost, 2); ?></span>
                        </div>
                        
                        <p class="text-success small fw-bold">You will be contacted by our team for a finalized quote.</p>
                    </div>
                </div>
            </div>
            
        </div>
        
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>