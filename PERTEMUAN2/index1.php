<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "sistem_pengelolaan_buku_perpustakaan";

$koneksi = mysqli_connect($host, $user, $password, $db);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$isbn = "";
$judul = "";
$pengarang = "";
$penerbit = "";
$tahun_terbit = "";
$sukses = "";
$error = "";
$op = "";
$id = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
if (isset($_POST['op'])) {
    $op = $_POST['op'];
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($op == 'delete') {
    $sql1 = "DELETE FROM buku WHERE ID = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Data berhasil dihapus.";
    } else {
        $error = "Data gagal dihapus.";
    }
}

if (isset($_POST['simpan'])) {
    $isbn = trim($_POST['isbn']);
    $judul = trim($_POST['judul']);
    $pengarang = trim($_POST['pengarang']);
    $penerbit = trim($_POST['penerbit']);
    $tahun_terbit = trim($_POST['tahun_terbit']);

    if ($isbn == "" || $judul == "" || $pengarang == "" || $penerbit == "" || $tahun_terbit == "") {
        $error = "Silakan isi semua data buku!";
    } elseif (!is_numeric($tahun_terbit)) {
        $error = "Tahun terbit harus berupa angka!";
    } else {
        if ($op == 'edit') {
            $cek_isbn = mysqli_query($koneksi, "SELECT ID FROM buku WHERE ISBN = '$isbn' AND ID != '$id'");
            if (mysqli_num_rows($cek_isbn) > 0) {
                $error = "ISBN sudah digunakan oleh buku lain!";
            } else {
                $sql1 = "UPDATE buku SET ISBN = '$isbn', JUDUL = '$judul', PENGARANG = '$pengarang', PENERBIT = '$penerbit', TAHUN_TERBIT = '$tahun_terbit' WHERE ID = '$id'";
                $q1 = mysqli_query($koneksi, $sql1);
                if ($q1) {
                    $sukses = "Data berhasil diubah!";
                    $isbn = "";
                    $judul = "";
                    $pengarang = "";
                    $penerbit = "";
                    $tahun_terbit = "";
                    $op = "";
                    $id = "";
                } else {
                    $error = "Data gagal diubah.";
                }
            }
        } else {
            $cek_isbn = mysqli_query($koneksi, "SELECT ID FROM buku WHERE ISBN = '$isbn'");
            if (mysqli_num_rows($cek_isbn) > 0) {
                $error = "ISBN sudah terdaftar, silakan gunakan ISBN yang lain!";
            } else {
                $sql1 = "INSERT INTO buku (ISBN, JUDUL, PENGARANG, PENERBIT, TAHUN_TERBIT) VALUES ('$isbn', '$judul', '$pengarang', '$penerbit', '$tahun_terbit')";
                $q1 = mysqli_query($koneksi, $sql1);
                if ($q1) {
                    $sukses = "Berhasil menambahkan data buku!";
                    $isbn = "";
                    $judul = "";
                    $pengarang = "";
                    $penerbit = "";
                    $tahun_terbit = "";
                } else {
                    $error = "Gagal menambahkan data buku!";
                }
            }
        }
    }
}

if ($op == 'edit' && !isset($_POST['simpan'])) {
    $sql1 = "SELECT * FROM buku WHERE ID = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    if ($r1) {
        $isbn = $r1['ISBN'];
        $judul = $r1['JUDUL'];
        $pengarang = $r1['PENGARANG'];
        $penerbit = $r1['PENERBIT'];
        $tahun_terbit = $r1['TAHUN_TERBIT'];
    } else {
        $error = "Data buku tidak ditemukan.";
    }
}

$sql2 = "SELECT * FROM buku ORDER BY ID DESC";
$q2 = mysqli_query($koneksi, $sql2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengelolaan Buku Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 1000px;
        }
        .card {
            margin-top: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container my-4">
    <div class="mx-auto" style="max-width: 1000px; width: 100%;">
        <h2 class="text-center mb-4">Sistem Pengelolaan Buku Perpustakaan</h2>

        <div class="card" id="form-buku">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span><?php echo ($op == 'edit') ? "Edit Data Buku" : "Tambah Data Buku"; ?></span>
                <?php if ($op == 'edit') { ?>
                    <a href="index1.php" class="btn btn-sm btn-light">Batal Edit</a>
                <?php } ?>
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($sukses); ?>
                    </div>
                <?php
                }
                ?>
                <form action="" method="POST">
                    <input type="hidden" name="op" value="<?php echo htmlspecialchars($op); ?>">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="mb-3 row">
                        <label for="isbn" class="col-sm-2 col-form-label">ISBN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="judul" class="col-sm-2 col-form-label">Judul Buku</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($judul); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="pengarang" class="col-sm-2 col-form-label">Pengarang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?php echo htmlspecialchars($pengarang); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo htmlspecialchars($penerbit); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tahun_terbit" class="col-sm-2 col-form-label">Tahun Terbit</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?php echo htmlspecialchars($tahun_terbit); ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="<?php echo ($op == 'edit') ? "Simpan Perubahan" : "Simpan Data"; ?>" class="btn btn-primary">
                        <?php if ($op == 'edit') { ?>
                            <a href="index1.php" class="btn btn-secondary ms-2">Kembali</a>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-white bg-secondary d-flex justify-content-between align-items-center">
                <span class="fw-bold">Daftar Buku Perpustakaan</span>
                <a href="#form-buku" class="btn btn-light btn-sm">+ Tambah Buku</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-center">No.</th>
                                <th scope="col" class="text-center">ID</th>
                                <th scope="col">ISBN</th>
                                <th scope="col">Judul Buku</th>
                                <th scope="col">Pengarang</th>
                                <th scope="col">Penerbit</th>
                                <th scope="col" class="text-center">Tahun Terbit</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($q2 && mysqli_num_rows($q2) > 0) {
                            $urut = 1;
                            while ($r2 = mysqli_fetch_array($q2)) {
                                $buku_id = $r2['ID'];
                                $buku_isbn = $r2['ISBN'];
                                $buku_judul = $r2['JUDUL'];
                                $buku_pengarang = $r2['PENGARANG'];
                                $buku_penerbit = $r2['PENERBIT'];
                                $buku_tahun_terbit = $r2['TAHUN_TERBIT'];
                        ?>
                            <tr>
                                <th scope="row" class="text-center"><?php echo $urut++; ?></th>
                                <td class="text-center"><?php echo htmlspecialchars($buku_id); ?></td>
                                <td><?php echo htmlspecialchars($buku_isbn); ?></td>
                                <td><?php echo htmlspecialchars($buku_judul); ?></td>
                                <td><?php echo htmlspecialchars($buku_pengarang); ?></td>
                                <td><?php echo htmlspecialchars($buku_penerbit); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($buku_tahun_terbit); ?></td>
                                <td class="text-center">
                                    <a href="index1.php?op=edit&id=<?php echo htmlspecialchars($buku_id); ?>"><button type="button" class="btn btn-warning btn-sm">Edit</button></a>
                                    <a href="index1.php?op=delete&id=<?php echo htmlspecialchars($buku_id); ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data buku ini?')"><button type="button" class="btn btn-danger btn-sm">Hapus</button></a>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-3">Belum ada data buku.</td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
