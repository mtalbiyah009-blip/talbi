
<?php
include "koneksi.php";

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID tidak valid.");
}

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM nilai WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data siswa tidak ditemukan.");
}

if (isset($_POST['update'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama_siswa']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);

    $tugas = (float) $_POST['nilai_tugas'];
    $uts   = (float) $_POST['nilai_uts'];
    $uas   = (float) $_POST['nilai_uas'];

    if (
        $tugas < 0 || $tugas > 100 ||
        $uts < 0 || $uts > 100 ||
        $uas < 0 || $uas > 100
    ) {
        die("Nilai harus berada antara 0 sampai 100.");
    }

    // Menghitung ulang nilai akhir
    $akhir = ($tugas * 0.30) +
             ($uts * 0.30) +
             ($uas * 0.40);

    $update = "UPDATE nilai SET
               nama_siswa = '$nama',
               kelas = '$kelas',
               nilai_tugas = '$tugas',
               nilai_uts = '$uts',
               nilai_uas = '$uas',
               nilai_akhir = '$akhir'
               WHERE id = $id";

    if (mysqli_query($conn, $update)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Nilai Siswa</title>
</head>
<body>

<h2>Edit Nilai Siswa</h2>

<form method="POST">

    <label>Nama Siswa</label><br>
    <input type="text" name="nama_siswa"
           value="<?= htmlspecialchars($data['nama_siswa']); ?>"
           required><br><br>

    <label>Kelas</label><br>
    <input type="text" name="kelas"
           value="<?= htmlspecialchars($data['kelas']); ?>"
           required><br><br>

    <label>Nilai Tugas (30%)</label><br>
    <input type="number" name="nilai_tugas"
           min="0" max="100" step="0.01"
           value="<?= $data['nilai_tugas']; ?>" required><br><br>

    <label>Nilai UTS (30%)</label><br>
    <input type="number" name="nilai_uts"
           min="0" max="100" step="0.01"
           value="<?= $data['nilai_uts']; ?>" required><br><br>

    <label>Nilai UAS (40%)</label><br>
    <input type="number" name="nilai_uas"
           min="0" max="100" step="0.01"
           value="<?= $data['nilai_uas']; ?>" required><br><br>

    <button type="submit" name="update">Update Nilai</button>
    <a href="index.php">Kembali</a>

</form>

</body>
</html>
