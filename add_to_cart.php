<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    
    // 1. Get product data from the POST request
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT) ?: 1; // Default to 1
    
    if (!$product_id || $quantity <= 0) {
        header('Location: index.php');
        exit;
    }
    
    $product_name = $_POST['product_name'] ?? 'Product';
    $product_price = $_POST['product_price'] ?? '0.00';
    $image_path = $_POST['product_image'] ?? 'placeholder.png'; // NOTE: You need to add this to product.php (see Step 3)
    
    $price = (float)str_replace(['₹', ','], '', $product_price);
    
    // 2. *** CRUCIAL CHANGE: Use $_SESSION['enquiry'] ***
    if (!isset($_SESSION['enquiry'])) {
        $_SESSION['enquiry'] = [];
    }
    
    // 3. Add or update the product in the enquiry cart
    if (array_key_exists($product_id, $_SESSION['enquiry'])) {
        // Product exists: overwrite the entry with new quantity (or you could sum it up)
        // Since your cart.php currently doesn't display quantity, we'll simplify and just ensure the product is present.
        // If you want to handle Quantity, see Step 2 below.
        
        // For now, let's store quantity, but we'll adapt cart.php in Step 2.
        $_SESSION['enquiry'][$product_id]['quantity'] += $quantity; 
        
    } else {
        // Product is new: add as a new item
        $_SESSION['enquiry'][$product_id] = [
            'id' => $product_id,
            'title' => $product_name, // Your cart.php expects 'title'
            'price' => $price,
            'quantity' => $quantity,
            'image' => $image_path // Your cart.php expects 'image'
        ];
    }
    
    // Redirect to the cart page
header('Location: product.php?id=' . $product_id); 
exit;
    
} else {
    header('Location: index.php');
    exit;
}
?>