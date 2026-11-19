
<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama_siswa']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);

    $tugas = (float) $_POST['nilai_tugas'];
    $uts   = (float) $_POST['nilai_uts'];
    $uas   = (float) $_POST['nilai_uas'];

    // Validasi nilai
    if (
        $tugas < 0 || $tugas > 100 ||
        $uts < 0 || $uts > 100 ||
        $uas < 0 || $uas > 100
    ) {
        die("Nilai harus berada antara 0 sampai 100.");
    }

    // Menghitung nilai akhir
    $akhir = ($tugas * 0.30) +
             ($uts * 0.30) +
             ($uas * 0.40);

    $query = "INSERT INTO nilai
              (nama_siswa, kelas, nilai_tugas, nilai_uts, nilai_uas, nilai_akhir)
              VALUES
              ('$nama', '$kelas', '$tugas', '$uts', '$uas', '$akhir')";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Nilai Siswa</title>
</head>
<body>

<h2>Tambah Nilai Siswa</h2>

<form method="POST">
    <label>Nama Siswa</label><br>
    <input type="text" name="nama_siswa" required><br><br>

    <label>Kelas</label><br>
    <input type="text" name="kelas" required><br><br>

    <label>Nilai Tugas (30%)</label><br>
    <input type="number" name="nilai_tugas" min="0" max="100" step="0.01" required><br><br>

    <label>Nilai UTS (30%)</label><br>
    <input type="number" name="nilai_uts" min="0" max="100" step="0.01" required><br><br>

    <label>Nilai UAS (40%)</label><br>
    <input type="number" name="nilai_uas" min="0" max="100" step="0.01" required><br><br>

    <button type="submit" name="simpan">Simpan Nilai</button>
    <a href="index.php">Kembali</a>
</form>

</body>
</html>
