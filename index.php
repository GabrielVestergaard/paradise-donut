<?php
// Paradise Donut: home page. Lists available donuts from the database.

$config = require __DIR__ . '/config.php';

// 1. Connect to the database on RDS
$db = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);

// 2. Build the category tabs from the categories that exist in the database
$categories = ['All'];
$result = $db->query("SELECT DISTINCT category FROM donuts WHERE available = TRUE ORDER BY category");
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}

// 3. Which tab did the visitor click? (default: All)
$selected = $_GET['category'] ?? 'All';
if (!in_array($selected, $categories, true)) {
    $selected = 'All';
}

// 4. Get the donuts to show
if ($selected === 'All') {
    $result = $db->query("SELECT name, image FROM donuts WHERE available = TRUE ORDER BY id");
} else {
    $stmt = $db->prepare("SELECT name, image FROM donuts WHERE available = TRUE AND category = ? ORDER BY id");
    $stmt->bind_param('s', $selected);
    $stmt->execute();
    $result = $stmt->get_result();
}
$donuts = $result->fetch_all(MYSQLI_ASSOC);

// Makes text safe to put inside HTML
function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paradise Donut</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <main class="container py-5">
        <h1 class="page-title text-center">DOUGHNUTS</h1>
        <p class="text-center text-muted small">Daily selection varies by shop</p>

        <!-- Category tabs -->
        <nav class="tabs d-flex justify-content-center flex-wrap gap-4 my-4">
            <?php foreach ($categories as $cat): ?>
                <a href="?category=<?= urlencode($cat) ?>"
                   class="tab <?= $cat === $selected ? 'active' : '' ?>">
                    <?= e(strtoupper($cat)) ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <!-- Donut grid: 2 per row on phones, 4 per row on larger screens -->
        <div class="row row-cols-2 row-cols-md-4 g-5">
            <?php foreach ($donuts as $donut): ?>
                <div class="col text-center">
                    <img src="images/<?= e($donut['image']) ?>" alt="<?= e($donut['name']) ?>" class="donut-img">
                    <h2 class="donut-name"><?= e(strtoupper($donut['name'])) ?></h2>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
