<?php 
require 'connection/db.php'; 

// Fetch categories for mapping URL parameters to category_ids
$categories = [];
$stmt = $pdo->query("SELECT id, slug FROM categories");
while ($row = $stmt->fetch()) {
    $categories[$row['slug']] = $row['id'];
}

$productId = null;
$productCategoryId = null;
$paramFound = false;
$debugParamName = '';
$debugParamValue = '';

// 1. Check for 'id' parameter (primary product ID)
if (isset($_GET['id'])) {
    $productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($productId) {
        $paramFound = true;
        $debugParamName = 'id';
        $debugParamValue = $productId;
    }
} 
// 2. Check for category-specific parameters
else {
    $paramMap = [
        'attendance' => $categories['attendance'] ?? null,
        'lanyard'    => $categories['lanyard'] ?? null,
        'badge'      => $categories['badge'] ?? null,
        'erp'        => $categories['erp'] ?? null,
    ];

    foreach ($paramMap as $paramName => $categoryId) {
        if (isset($_GET[$paramName]) && $categoryId !== null) {
            $productId = filter_input(INPUT_GET, $paramName, FILTER_VALIDATE_INT);
            if ($productId) {
                $productCategoryId = $categoryId;
                $paramFound = true;
                $debugParamName = $paramName;
                $debugParamValue = $productId;
                break;
            }
        }
    }
}

// If no valid parameter was found, redirect to homepage
if (!$paramFound) {
    error_log("Redirecting from product.php: No valid parameter found. Detected Param Name: {$debugParamName}, Value: {$debugParamValue}");
    header("Location: index.php");
    exit;
}

// 3. Construct the database query dynamically
$sql = "SELECT * FROM products WHERE id = ?";
$params = [$productId];

// For category-specific parameters, check category_id OR NULL (for products without category)
if ($productCategoryId !== null) {
    // For lanyard/badge products, they might have NULL category_id, so check both
    $sql .= " AND (category_id = ? OR category_id IS NULL)";
    $params[] = $productCategoryId;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$product = $stmt->fetch();

// 4. If no product is found with that ID, redirect
if (!$product) {
    header("Location: index.php");
    exit;
}

include 'includes/header.php'; 
?>

<main>
    <section class="py-3" style="background-color: var(--light-gray);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="id-cards.php">ID Cards</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['title']); ?></li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="product-image-gallery">
                        <?php
                            $image_path = 'assets/images/products/placeholder.png'; // Default image
                            $category_folder = '';

                            if ($product['category_id'] == 5) { // This is the 'ID Cards' category
                                $category_folder = 'id-cards';
                            } else if ($product['category_id'] == 1) {
                                $category_folder = 'attendance';
                            } else if ($product['category_id'] == 2) {
                                $category_folder = 'lanyards';
                            } else if ($product['category_id'] == 3) {
                                $category_folder = 'badges';
                            } else if ($product['category_id'] == 4) {
                                $category_folder = 'erp';
                            }

                            if (!empty($category_folder) && !empty($product['image'])) {
                                $image_path = "assets/images/products/{$category_folder}/" . $product['image'];
                            }
                            
                            // For the zoom to work best, you should have a larger version of the image.
                            // For now, we'll use the same image for both.
                            $large_image_path = $image_path; 
                        ?>
                        <a href="<?php echo htmlspecialchars($image_path); ?>" class="zoom-link">
                            <img src="<?php echo htmlspecialchars($image_path); ?>" 
                                class="main-product-image" 
                                loading="lazy"
                                data-zoom="<?php echo htmlspecialchars($image_path); ?>"
                                alt="<?php echo htmlspecialchars($product['title']); ?>">
                        </a>
                    </div>
                    <div class="zoom-pane"></div>
                </div>

                <div class="col-lg-6">
                    <h1 class="product-page-title"><?php echo htmlspecialchars($product['title']); ?></h1>
                    <p class="product-page-price">₹<?php echo number_format($product['price'], 2); ?></p>
                    <?php
                    // Display only the description part, not the specifications
                    $full_description = $product['description'];
                    if (strpos($full_description, 'Specifications:') !== false) {
                        // Extract only the description part before "Specifications:"
                        $parts = explode('Specifications:', $full_description, 2);
                        $description_only = trim($parts[0]);
                        echo '<p class="lead">' . htmlspecialchars($description_only) . '</p>';
                    } else {
                        // If no specifications section, display the full description
                        echo '<p class="lead">' . htmlspecialchars($full_description) . '</p>';
                    }
                    ?>

                    <hr class="my-4">

                   <form method="POST" action="add_to_cart.php">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['title']); ?>">
    <input type="hidden" name="product_price" value="<?php echo number_format($product['price'], 2); ?>">
    <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($category_folder . '/' . $product['image']); ?>">

    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity:</label>
        <input type="number" name="quantity" id="quantity" class="form-control quantity-input" value="1" min="1">
    </div>

    <div class="mt-4">
        <button type="submit" name="add_to_cart" class="btn btn-success btn-lg">
            Add to Cart
        </button>
        
        <a href="quote.php?product_id=<?php echo $product['id']; ?>" class="btn btn-primary btn-lg ms-2">Get a Quote</a>
        <a href="contact.php" class="btn btn-secondary btn-lg ms-2">Ask a Question</a>
    </div>
</form>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Full Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">Specifications</button>
                        </li>
                    </ul>
                    <div class="tab-content p-4 border border-top-0">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <?php
                            // Display only the description part, not the specifications
                            $full_description = $product['description'];
                            if (strpos($full_description, 'Specifications:') !== false) {
                                // Extract only the description part before "Specifications:"
                                $parts = explode('Specifications:', $full_description, 2);
                                $description_only = trim($parts[0]);
                                echo '<p>' . nl2br(htmlspecialchars($description_only)) . '</p>';
                            } else {
                                // If no specifications section, display the full description
                                echo '<p>' . nl2br(htmlspecialchars($full_description)) . '</p>';
                            }
                            ?>
                        </div>
                        <div class="tab-pane fade" id="specs" role="tabpanel">
                            <?php
                            // Extract specifications from the description
                            $full_description = $product['description'];
                            $specs_content = '';
                            
                            // Check if description contains specifications
                            if (strpos($full_description, 'Specifications:') !== false) {
                                // Split the description at "Specifications:"
                                $parts = explode('Specifications:', $full_description, 2);
                                if (count($parts) == 2) {
                                    // Get the specifications part and format it as a list
                                    $specs_text = trim($parts[1]);
                                    $specs_lines = explode("\n", $specs_text);
                                    
                                    echo '<ul class="list-unstyled">';
                                    foreach ($specs_lines as $line) {
                                        $line = trim($line);
                                        if (!empty($line) && $line[0] == '-') {
                                            echo '<li>' . htmlspecialchars($line) . '</li>';
                                        }
                                    }
                                    echo '</ul>';
                                }
                            } else {
                                echo '<p>Detailed specifications for ' . htmlspecialchars($product['title']) . ' will be listed here.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>