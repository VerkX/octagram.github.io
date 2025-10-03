<?php
require 'function.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $player = trim($_POST['player_name'] ?? '');
    $category = $_POST['category'] ?? '';
    $amount = (int)($_POST['gold_amount'] ?? 0);

    if ($player === '' || $amount <= 0) {
        $errors[] = 'Nama pemain dan jumlah gold harus diisi (jumlah > 0).';
    }

    // validasi kategori (sama dengan enum di DB)
    $valid_categories = ['Officer','Cross-Server Event','Monthly Jotun'];
    if (!in_array($category, $valid_categories)) {
        $errors[] = 'Kategori tidak valid.';
    }

    if (empty($errors)) {
        // mulai transaction
        mysqli_begin_transaction($conn);
        try {
            // kunci baris stok untuk update atomik
            $res = mysqli_query($conn, "SELECT total_gold FROM gold_stock WHERE id = 1 FOR UPDATE");
            if (!$res || mysqli_num_rows($res) === 0) {
                throw new Exception('Baris stok tidak ditemukan.');
            }
            $row = mysqli_fetch_assoc($res);
            $current = (int)$row['total_gold'];
            if ($current < $amount) {
                throw new Exception('Saldo guild tidak cukup. Sisa: ' . number_format($current,0,',','.'));
            }

            // insert distribusi
            $stmt = $conn->prepare("INSERT INTO gold_distribution (player_name, category, gold_amount) VALUES (?, ?, ?)");
            $stmt->bind_param('ssi', $player, $category, $amount);
            $stmt->execute();

            // update stok
            $stmt2 = $conn->prepare("UPDATE gold_stock SET total_gold = total_gold - ? WHERE id = 1");
            $stmt2->bind_param('i', $amount);
            $stmt2->execute();

            mysqli_commit($conn);
            $success = "Distribusi berhasil: $player mendapat $amount gold.";
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $errors[] = 'Gagal melakukan distribusi: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="utf-8"><title>Distribusi Gold</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container py-4">
    <h2>Form Distribusi Gold</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php foreach($errors as $err): ?>
        <div class="alert alert-danger"><?php echo $err; ?></div>
    <?php endforeach; ?>

    <form method="post">
        <div class="mb-3">
            <label>Nama Pemain</label>
            <input type="text" name="player_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="category" class="form-select" required>
                <option value="Officer">Officer</option>
                <option value="Cross-Server Event">Cross-Server Event</option>
                <option value="Monthly Jotun">Monthly Jotun</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Jumlah Gold</label>
            <input type="number" name="gold_amount" class="form-control" min="1" required>
        </div>
        <button class="btn btn-primary">Distribusikan</button>
    </form>
</div>
</body>
</html>
