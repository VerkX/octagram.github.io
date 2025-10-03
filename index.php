<?php 
require 'function.php'; // koneksi database
include 'includes/navbar.php'; // navbar

// ========================
// Ambil total gold guild (saldo saat ini)
// ========================
$stockGold = 0;
$sql = "SELECT total_gold FROM gold_stock WHERE id = 1";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $stockGold = (int)($row['total_gold'] ?? 0);
}

// ========================
// Ambil total gold yang sudah didistribusi
// ========================
$distributedGold = 0;
$sql2 = "SELECT COALESCE(SUM(gold_amount),0) as total FROM gold_distribution";
$result2 = mysqli_query($conn, $sql2);
if ($result2 && $row2 = mysqli_fetch_assoc($result2)) {
    $distributedGold = (int)($row2['total'] ?? 0);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Gold Guild Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>
    <!-- Hero Section -->
    <section class="hero d-flex align-items-center justify-content-center text-center text-light">
        <div data-aos="zoom-in">
            <h1 class="display-4 fw-bold">Welcome to Gold Guild</h1>
            <p class="lead">Sistem Distribusi Gold Berdasarkan Kinerja & Event</p>
            
            <!-- Stok Guild -->
            <h3 class="mt-4">💰 Total Gold Guild Saat Ini: 
                <span class="text-warning fw-bold">
                    <?php echo number_format($stockGold, 0, ',', '.'); ?>
                </span>
            </h3>

            <!-- Terdistribusi -->
            <h5 class="mt-2">📊 Total Gold Terdistribusi: 
                <span class="text-light">
                    <?php echo number_format($distributedGold, 0, ',', '.'); ?>
                </span>
            </h5>

            <a href="distribusi.php" class="btn btn-warning btn-lg mt-3">Mulai Distribusi</a>
        </div>
    </section>

    <!-- Info Kategori -->
    <div class="container py-5">
        <div class="row text-center">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card shadow-lg border-0 rounded-4">
                    <img src="assets/officer.png" class="card-img-top" alt="Officer">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Officer</h5>
                        <p class="card-text">Distribusi Gold sesuai kinerja Officer.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card shadow-lg border-0 rounded-4">
                    <img src="assets/cross.png" class="card-img-top" alt="CrossServer">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Cross-Server Event</h5>
                        <p class="card-text">Reward untuk 10 besar, dengan bonus tambahan 3 besar.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card shadow-lg border-0 rounded-4">
                    <img src="assets/jotun.png" class="card-img-top" alt="Jotun">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Monthly Jotun</h5>
                        <p class="card-text">Reward khusus untuk 3 besar setiap bulan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light text-center py-3">
        <p>&copy; <?php echo date("Y"); ?> Gold Guild Management | Powered by PHP & MySQL</p>
    </footer>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init();</script>
</body>
</html>
