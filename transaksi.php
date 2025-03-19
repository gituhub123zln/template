<?php
// Daftar produk dalam bentuk array dengan nama, deskripsi, harga, dan gambar
$dataproduk = array(
    array("sofa", "sudah termasuk dengan sofa dan meja", 3000000, "sofa.jpg"),
    array("lemari", "lemari dengan fitur keamanan jangkar dan buka kunci", 2500000, "lemari.jpg"),
    array("kasur", "sudah termasuk dengan bantal dan guling", 4500000, "kasur.jpg"),
    array("lampu hias", "sudah termasuk dengan pasang", 3500000, "lampuhias.jpg"),
);

// Mengambil parameter ID produk dari URL dan memastikan itu adalah angka
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
// Memeriksa apakah ID yang diberikan sesuai dengan indeks dalam array
// Jika valid, produk dipilih dari array berdasarkan ID.
// Jika ID tidak valid, produk pertama dipilih secara default.
if ($id >= 0 && $id < count($dataproduk)) {
    $paket = $dataproduk[$id];
} else {
    $paket = $dataproduk[0]; // Default ke produk pertama jika ID tidak valid
}

// Inisialisasi variabel transaksi
$no_transaksi = "";
$nama_cus = "";
$tanggal = "";
$jumlah_produk = 1;
$total_harga = 0;
$pembayaran = 0;
$kembalian = 0;

// Mengecek apakah ada data yang dikirim dari form menggunakan metode POST.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $harga = isset($_POST['harga']) ? (int)$_POST['harga'] : 0;
    $no_transaksi = $_POST['no_transaksi'];
    $nama_cus = $_POST['nama'];
    $tanggal = $_POST['tanggal'];
    $jumlah_produk = isset($_POST['jumlah_produk']) ? (int)$_POST['jumlah_produk'] : 1;
    $total_harga = $harga * $jumlah_produk; // Menghitung total harga
    $pembayaran = isset($_POST['pembayaran']) ? (int)$_POST['pembayaran'] : 0;

    // Menghitung kembalian jika tombol hitung kembalian ditekan
    if (isset($_POST['hitung_kembalian'])) {
        $kembalian = $pembayaran - $total_harga;
    }

    // Menampilkan pesan sukses dan mengarahkan ke halaman beranda jika transaksi disimpan
    if (isset($_POST['simpan'])) {
        echo "<script>
                alert('Transaksi berhasil disimpan!');
                window.location.href = 'beranda.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transaksi Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar bg-dark navbar-dark shadow">
        <div class="container-fluid">
            <div class="d-flex">
                <a class="nav-link text-light mx-2 fs-6 py-1 px-2" href="beranda.php">Home</a>
                <a class="nav-link text-light mx-2 fs-6 py-1 px-2" href="transaksi.php">Transaksi</a>
            </div>
            <a class="nav-link text-light mx-2 fs-6 py-1 px-2" href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center fw-bold">Transaksi</h2>
                        <form method="POST">
                            <!-- Input Nomor Transaksi -->
                            <div class="mb-3">
                                <label class="form-label">No. Transaksi</label>
                                <input type="number" class="form-control" name="no_transaksi" value="<?= $no_transaksi; ?>" required>
                            </div>
                            <!-- Input Tanggal Transaksi -->
                            <div class="mb-3">
                                <label class="form-label">Tanggal Transaksi</label>
                                <input type="date" class="form-control" name="tanggal" value="<?= $tanggal; ?>" required>
                            </div>
                            <!-- Input Nama Customer -->
                            <div class="mb-3">
                                <label class="form-label">Nama Customer</label>
                                <input type="text" class="form-control" name="nama" value="<?= $nama_cus; ?>" required>
                            </div>
                            <!-- Menampilkan Nama Produk yang Dipilih -->
                            <div class="mb-3">
                                <label class="form-label">Pilih Produk</label>
                                <input type="text" class="form-control" name="paket" value="<?= $dataproduk[$id][0]; ?>" readonly>
                            </div>
                            <!-- Menampilkan Harga Produk -->
                            <div class="mb-3">
                                <label class="form-label">Harga Produk</label>
                                <input type="number" class="form-control" name="harga" value="<?= $dataproduk[$id][2]; ?>" readonly>
                            </div>
                            <!-- Input Jumlah Produk -->
                            <div class="mb-3">
                                <label class="form-label">Jumlah Produk</label>
                                <input type="number" class="form-control" name="jumlah_produk" value="<?= $jumlah_produk; ?>" min="1" required>
                            </div>
                            <!-- Tombol Hitung Total Harga -->
                            <button type="submit" class="btn btn-dark mb-3" name="hitung">Hitung Total Harga</button>
                            <!-- Menampilkan Total Harga -->
                            <div class="mb-3">
                                <label class="form-label">Total Harga</label>
                                <input type="number" class="form-control" name="total_harga" value="<?= $total_harga; ?>" readonly>
                            </div>
                            <!-- Input Pembayaran -->
                            <div class="mb-3">
                                <label class="form-label">Pembayaran</label>
                                <input type="number" class="form-control" name="pembayaran" value="<?= $pembayaran; ?>">
                            </div>
                            <!-- Tombol Hitung Kembalian -->
                            <button type="submit" class="btn btn-dark" name="hitung_kembalian">Hitung Kembalian</button>
                            <!-- Menampilkan Kembalian -->
                            <div class="mb-3">
                                <label class="form-label">Kembalian</label>
                                <input type="number" class="form-control" name="kembalian" value="<?= $kembalian; ?>" readonly>
                            </div>
                            <!-- Tombol Simpan Transaksi -->
                            <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>