<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../connection/db.php'; 
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../connection/db.php'; 

// START NEW CART COUNT LOGIC
// START NEW CART COUNT LOGIC
$cart_item_count = 0;
if (isset($_SESSION['enquiry']) && is_array($_SESSION['enquiry'])) {
    foreach ($_SESSION['enquiry'] as $item) { // Ensure loop uses 'enquiry' as well
        // Sum the quantities of all distinct products
        // Ensure 'quantity' exists and is an integer before summing
        $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
        $cart_item_count += $quantity; 
    }
}
// END NEW CART COUNT LOGIC
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simption Tech - Creative ID & Attendance Solutions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/drift-zoom/dist/drift-basic.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<!-- Top Bar -->
<div class="container-fluid bg-light py-2">
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="small me-4">
                <i class="fas fa-headset me-1"></i> Happy to help: +91  9074822542
            </div>
            <div>
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="small me-3">Welcome, <?php echo htmlspecialchars($_SESSION['user']['name']); ?></span>
                    <a href="profile.php" class="text-decoration-none text-dark me-3"><i class="fas fa-user me-1"></i> Profile</a>
                    <a href="logout.php" class="text-decoration-none text-dark"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-decoration-none text-dark me-3"><i class="fas fa-user me-1"></i> Login / Register</a>
                <?php endif; ?>
                <a href="cart.php" class="text-decoration-none text-dark position-relative">
    <i class="fas fa-shopping-cart me-1"></i> Cart
    <?php if ($cart_item_count > 0): ?>
    <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle" style="font-size: 0.7em;">
        <?php echo $cart_item_count; ?>
        <span class="visually-hidden">items in cart</span>
    </span>
    <?php endif; ?>
</a>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="bg-white shadow-sm sticky-top" id="mainHeader" style="z-index: 1050;">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/Simption Logo.png" alt="Simption Tech Logo" style="height: 40px;">
            </a>

            <!-- Search Bar -->
            <div class="mx-auto d-none d-lg-block" style="width: 20%;">
                <form action="search.php" method="GET" class="input-group">
                    <input type="text" name="query" class="form-control search-bar" placeholder="Search..." aria-label="Search" value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <!-- Right Side Buttons -->
            <div class="d-flex align-items-center">
                <a href="quote.php" class="btn btn-primary me-2 d-none d-lg-block">Order in Bulk</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto justify-content-center mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    
                    <!-- All Products Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="allProductsDropdown" role="button">All Products</a>
                        <div class="dropdown-menu mega-menu" aria-labelledby="allProductsDropdown">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mega-menu-links">
                                                <h5>ID Cards</h5>
                                                <a href="product.php?id=2" data-image="assets/images/menu-featured/id-cards/pvc-card.jpg">PVC Card</a>
                                                <a href="product.php?id=4" data-image="assets/images/menu-featured/id-cards/pouch-card.jpg">Pouch Card</a>
                                                <a href="product.php?id=5" data-image="assets/images/menu-featured/id-cards/uv-card.jpg">UV-Card</a>
                                                <a href="product.php?id=1" data-image="assets/images/menu-featured/id-cards/rfid-card.jpg">RFID-Card</a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mega-menu-links">
                                                <h5>Attendance</h5>
                                                <a href="product.php?attendance=11" data-image="assets/images/menu-featured/attendance/rfid-machine.jpg">RFID Machine</a>
                                                <a href="product.php?attendance=13" data-image="assets/images/menu-featured/attendance/fingerprint-machine.jpg">Fingerprint Machine</a>
                                                <a href="product.php?attendance=12" data-image="assets/images/menu-featured/attendance/face-scanner.jpg">Face Scanner</a>
                                                <a href="product.php?attendance=14" data-image="assets/images/menu-featured/attendance/qr-scanner.jpg">QR Scanner</a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mega-menu-links">
                                                <h5>Lanyards</h5>
                                                <a href="product.php?lanyard=3" data-image="assets/images/menu-featured/lanyards/polyester-lanyards.jpg">Polyester Lanyards</a>
                                                <a href="product.php?lanyard=7" data-image="assets/images/menu-featured/lanyards/nylon-lanyards.jpg">Nylon Lanyards</a>
                                                <a href="product.php?lanyard=8" data-image="assets/images/menu-featured/lanyards/lanyard-prints.jpg">Lanyard Prints</a>
                                                <a href="product.php?lanyard=9" data-image="assets/images/menu-featured/lanyards/customized-lanyards.jpg">Customized Lanyards</a>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mega-menu-links">
                                                <h5>Badges</h5>
                                                <a href="product.php?badge=6" data-image="assets/images/menu-featured/badges/metal-badges.jpg">Metal Badges</a>
                                                <a href="product.php?badge=5" data-image="assets/images/menu-featured/badges/plastic-badges.jpg">Plastic Badges</a>
                                                <a href="product.php?badge=19" data-image="assets/images/menu-featured/badges/clip-badges.jpg">Clip Badges</a>
                                                <a href="product.php?badge=20" data-image="assets/images/menu-featured/badges/magnetic-badges.jpg">Magnetic Badges</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mega-menu-image">
                                        <img src="assets/images/menu-featured/attendance-promo.jpg" class="mega-menu-preview-image" alt="Featured Products">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <!-- ID Cards Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="id-cards.php" id="idCardsDropdown" role="button">ID Cards</a>
                        <div class="dropdown-menu mega-menu" aria-labelledby="idCardsDropdown">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="mega-menu-links">
                                        <a href="product.php?id=2" data-image="assets/images/menu-featured/id-cards/pvc-card.jpg">PVC Card</a>
                                        <a href="product.php?id=4" data-image="assets/images/menu-featured/id-cards/pouch-card.jpg">Pouch Card</a>
                                        <a href="product.php?id=5" data-image="assets/images/menu-featured/id-cards/uv-card.jpg">UV-Card</a>
                                        <a href="product.php?id=1" data-image="assets/images/menu-featured/id-cards/rfid-card.jpg">RFID-Card</a>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mega-menu-image">
                                        <img src="assets/images/menu-featured/id-cards/id-cards-promo.jpg" class="mega-menu-preview-image" alt="ID Card Products">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Attendance Device Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="attendance.php" id="attendanceDropdown" role="button">Attendance Device</a>
                        <div class="dropdown-menu mega-menu" aria-labelledby="attendanceDropdown">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="mega-menu-links">
                                        <a href="product.php?attendance=11" data-image="assets/images/menu-featured/attendance/rfid-machine.jpg">RFID Machine</a>
                                        <a href="product.php?attendance=13" data-image="assets/images/menu-featured/attendance/fingerprint-machine.jpg">Fingerprint Machine</a>
                                        <a href="product.php?attendance=12" data-image="assets/images/menu-featured/attendance/face-scanner.jpg">Face Scanner</a>
                                        <a href="product.php?attendance=12" data-image="assets/images/menu-featured/attendance/face-id-attendance-machine.jpg">Face ID Attendance Machine</a>
                                        <a href="product.php?attendance=14" data-image="assets/images/menu-featured/attendance/qr-scanner.jpg">QR Scanner</a>
                                        <a href="product.php?attendance=14" data-image="assets/images/menu-featured/attendance/barcode-scanner.jpg">Barcode Scanner</a>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mega-menu-image">
                                        <img src="assets/images/menu-featured/attendance/attendance-promo.jpg" class="mega-menu-preview-image" alt="Attendance Devices">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Lanyards Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="lanyard.php" id="lanyardsDropdown" role="button">Lanyards</a>
                        <div class="dropdown-menu mega-menu" aria-labelledby="lanyardsDropdown">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="mega-menu-links">
                                        <a href="product.php?lanyard=3" data-image="assets/images/menu-featured/lanyards/polyester-lanyards.jpg">Polyester Lanyards</a>
                                        <a href="product.php?lanyard=7" data-image="assets/images/menu-featured/lanyards/nylon-lanyards.jpg">Nylon Lanyards</a>
                                        <a href="product.php?lanyard=8" data-image="assets/images/menu-featured/lanyards/lanyard-prints.jpg">Lanyard Prints</a>
                                        <a href="product.php?lanyard=9" data-image="assets/images/menu-featured/lanyards/customized-lanyards.jpg">Customized Lanyards</a>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mega-menu-image">
                                        <img src="assets/images/menu-featured/lanyards/lanyards-promo.jpg" class="mega-menu-preview-image" alt="Lanyards">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Badges Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="badge.php" id="badgesDropdown" role="button">Badges</a>
                        <div class="dropdown-menu mega-menu" aria-labelledby="badgesDropdown">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="mega-menu-links">
                                        <a href="product.php?badge=6" data-image="assets/images/menu-featured/badges/metal-badges.jpg">Metal Badges</a>
                                        <a href="product.php?badge=5" data-image="assets/images/menu-featured/badges/plastic-badges.jpg">Plastic Badges</a>
                                        <a href="product.php?badge=19" data-image="assets/images/menu-featured/badges/clip-badges.jpg">Clip Badges</a>
                                        <a href="product.php?badge=20" data-image="assets/images/menu-featured/badges/magnetic-badges.jpg">Magnetic Badges</a>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mega-menu-image">
                                        <img src="assets/images/menu-featured/badges/badges-promo.jpg" class="mega-menu-preview-image" alt="Badges">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <!-- ERP Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="erp.php" id="erpDropdown" role="button">ERP</a>
                        <div class="dropdown-menu mega-menu" aria-labelledby="erpDropdown">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="mega-menu-links">
                                        <a href="erp_module_detail.php?id=1">School Management Software</a>
                                        <a href="erp_module_detail.php?id=2">Attendance Management Systems</a>
                                        <a href="erp_module_detail.php?id=3">Website Development Services</a>
                                        <a href="erp_module_detail.php?id=4">Android App Development</a>
                                        <a href="erp_module_detail.php?id=5">Communication Services</a>
                                        <a href="erp_module_detail.php?id=6">Bus Tracking System</a>
                                        <a href="erp_module_detail.php?id=7">Online Learning Solutions</a>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mega-menu-image">
                                        <img src="assets/images/menu-featured/erp/erp-promo.jpg" class="mega-menu-preview-image" alt="ERP Solutions">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <li class="nav-item"><a class="nav-link" href="clients.php">Clients</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<script>
// Add scrolled class to header when scrolling
window.addEventListener('scroll', function() {
    const header = document.getElementById('mainHeader');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});
</script>