<?php
session_start();

// Ensure the request is POST and we have the necessary data
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['product_id'], $_POST['action'])) {
    header('Location: cart.php');
    exit;
}

$product_id = intval($_POST['product_id']);
$action = $_POST['action'];

// Check if the product exists in the enquiry cart
if (isset($_SESSION['enquiry'][$product_id])) {
    $current_qty = $_SESSION['enquiry'][$product_id]['quantity'];
    $new_qty = $current_qty;

    if ($action === 'increase') {
        // Increase quantity by 1
        $new_qty = $current_qty + 1;
    } elseif ($action === 'decrease') {
        // Decrease quantity by 1, minimum is 1
        $new_qty = max(1, $current_qty - 1);
        
        // OPTIONAL: If the quantity hits 0, you could unset the item entirely here:
        // if ($new_qty === 0) {
        //     unset($_SESSION['enquiry'][$product_id]);
        //     header('Location: cart.php'); 
        //     exit;
        // }
    }
    
    // Update the quantity in the session
    $_SESSION['enquiry'][$product_id]['quantity'] = $new_qty;
}

// Redirect back to the cart page to see the updated quantity
header('Location: cart.php');
exit;
?>