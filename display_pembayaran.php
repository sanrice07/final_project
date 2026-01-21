<?php
// display_pembayaran.php - versi aman & dinamis
require_once __DIR__ . '/db_mahasiswa.php';

if (!isset($con) || !($con instanceof mysqli)) {
    die('Koneksi database ($con) tidak tersedia. Periksa db_mahasiswa.php');
}

$err = '';
$cols = [];
$rows = [];

// Ambil struktur kolom (SHOW COLUMNS)
$qc = mysqli_query($con, "SHOW COLUMNS FROM `pembayaran`");
if (!$qc) {
    $err = 'Gagal mengambil struktur tabel pembayaran: ' . mysqli_error($con);
} else {
    while ($r = mysqli_fetch_assoc($qc)) {
        $cols[] = $r['Field'];
    }

    // Ambil semua data dari tabel pembayaran (SELECT *)
    $q = mysqli_query($con, "SELECT * FROM `pembayaran` ORDER BY 1 DESC");
    if (!$q) {
        $err = 'Gagal mengambil data tabel pembayaran: ' . mysqli_error($con);
    } else {
        while ($r = mysqli_fetch_assoc($q))
            $rows[] = $r;
    }
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Display Pembayaran (Aman)</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <style>
        .info {
            margin-bottom: 12px;
            padding: 10px;
            border-radius: 8px;
            background: #fff7e6;
            border: 1px solid #f0d8b7
        }

        .error {
            background: #fff0f0;
            border: 1px solid #f0b7b7;
            color: #7a1b1b;
            padding: 10px;
            border-radius: 8px
        }

        .small {
            font-size: 13px;
            color: #666
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #e6eef6;
            text-align: left
        }

        th {
            background: #f1f7ff
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Data Pembayaran</h2>
        <?php if ($err): ?>
            <div class="error"><?= htmlspecialchars($err) ?></div>
        <?php else: ?>

            <?php if (count($rows) === 0): ?>
                <div class="info">Belum ada data pada tabel <code>pembayaran</code>.</div>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <?php foreach ($cols as $c): ?>
                                <th><?= htmlspecialchars($c) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $r): ?>
                            <tr>
                                <?php foreach ($cols as $c): ?>
                                    <td><?= htmlspecialchars($r[$c]) ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <div style="margin-top:12px;">
                <a class="btn" href="add_pembayaran.php">Tambah Pembayaran</a>
                <a class="btn secondary" href="dashboard.php" style="margin-left:8px">Kembali ke Dashboard</a>
            </div>

        <?php endif; ?>
    </div>
</body>

</html>