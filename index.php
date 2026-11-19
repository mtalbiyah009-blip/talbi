
<?php
include "koneksi.php";

$query = mysqli_query($conn, "SELECT * FROM nilai ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akumulasi Nilai Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h2 {
            color: #1e293b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background: #2563eb;
            color: white;
        }

        a, button {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            border: none;
            cursor: pointer;
        }

        .tambah {
            background: #16a34a;
        }

        .edit {
            background: #2563eb;
        }

        .hapus {
            background: #dc2626;
        }

        .nilai {
            font-weight: bold;
            color: #15803d;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Sistem Akumulasi Nilai Siswa</h2>

    <p>Perhitungan nilai tugas 30%, UTS 30%, dan UAS 40%.</p>

    <a href="create.php" class="tambah">+ Tambah Nilai</a>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Tugas (30%)</th>
            <th>UTS (30%)</th>
            <th>UAS (40%)</th>
            <th>Nilai Akhir</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($data['nama_siswa']); ?></td>
            <td><?= htmlspecialchars($data['kelas']); ?></td>
            <td><?= $data['nilai_tugas']; ?></td>
            <td><?= $data['nilai_uts']; ?></td>
            <td><?= $data['nilai_uas']; ?></td>

            <td class="nilai">
                <?= number_format($data['nilai_akhir'], 2); ?>
            </td>

            <td>
                <a href="edit.php?id=<?= $data['id']; ?>"
                   class="edit">Edit</a>

                <form action="hapus.php" method="POST"
                      style="display:inline;"
                      onsubmit="return confirm('Yakin ingin menghapus data ini?');">

                    <input type="hidden" name="id"
                           value="<?= $data['id']; ?>">

                    <button type="submit" class="hapus">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>
