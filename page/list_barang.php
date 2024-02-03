<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Inventaris</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="text-center">Daftar Inventaris</h2
    <hr>
    <a href="?p=tambah_barang" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-plus"></span> Tambah Inventaris</a>
    <form class="navbar-form navbar-right" role="search" method="get">
        <div class="form-group">
            <input type="hidden" name="p" value="list_barang">
            <input type="text" class="form-control" placeholder="Cari Barang" name="cari">
        </div>
        <button type="submit" class="btn btn-default">Cari</button>
    </form>
    <br><br>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Inventaris</th>
                <th>Nama Inventaris</th>
                <!-- <th>Kondisi</th> -->
                <th>Jumlah Inventaris</th>
                <th>Gambar Inventaris</th>
                <!-- <th>Barcode</th> -->
                <!-- <th>Ruang</th> -->
                <!-- <th>Tanggal Register</th> -->
                <!-- <th>Keterangan</th> -->
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            @$cari = $_GET['cari'];
            $q_cari = "";
            if (!empty($cari)) {
                $q_cari .= "and kode_inventaris like '%" . $cari . "%'";
            }
            $pembagian = 50;
            $page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
            $mulai = $page > 1 ? $page * $pembagian - $pembagian : 0;

            $sql = "SELECT *, inventaris.keterangan as ket FROM inventaris LEFT JOIN ruang ON ruang.id_ruang = inventaris.id_ruang WHERE 1=1 $q_cari LIMIT $mulai, $pembagian";
            $query = mysqli_query($koneksi, $sql);
            $cek = mysqli_num_rows($query);

            // Mencari Total Halaman
            $sql_total = "SELECT * FROM inventaris";
            $q_total = mysqli_query($koneksi, $sql_total);
            $total = mysqli_num_rows($q_total);

            $jumlahHalaman = ceil($total / $pembagian);

            if ($cek > 0) {
                $no = $mulai + 1;
                while ($data = mysqli_fetch_array($query)) {
                    $tgl = $data['tanggal_register'];
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data['kode_inventaris'] ?></td>
                <td><?= $data['nama'] ?></td>
                <!-- <td><?= $data['kondisi'] ?></td> -->
                <td><?= $data['jumlah'] ?></td>
                <td>
                    <a href="?p=list_barang&id_inventaris=<?= $data['id_inventaris'] ?>#gambar/<?= $data['gambar'] ?>">
                        <img src="gambar/<?php echo $data['gambar']; ?>" id="preview" width="50">
                    </a>
                    <!-- Menampilkan popup gambar -->
                    <div class="overlay" id="gambar/<?= $data['gambar'] ?>">
                        <a href="#" class="close">
                            <svg style="width:47px;height:47px" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2C6.47,2 2,6.47 2,12C2,17.53 6.47,22 12,22C17.53,22 22,17.53 22,12C22,6.47 17.53,2 12,2M14.59,8L12,10.59L9.41,8L8,9.41L10.59,12L8,14.59L9.41,16L12,13.41L14.59,16L16,14.59L13.41,12L16,9.41L14.59,8Z" />
                            </svg>
                        </a>
                        <img src="gambar/<?php echo $data['gambar']; ?>" alt="Nelayan Kode">
                    </div>
                </td>
                <td>
                    <a href="?p=detail_barang&id_inventaris=<?= $data['id_inventaris'] ?>" class="btn btn-md btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>
                    <a href="?p=edit_barang&id_inventaris=<?= $data['id_inventaris'] ?>" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                    <a onclick="return confirm('Apakah anda yakin untuk menghapusnya?')" href="page/hapus_barang.php?id_inventaris=<?= $data['id_inventaris'] ?>" class="btn btn-md btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

    <div class="float-left">Jumlah : <?= $total ?></div>
    <div class="" style="float:right">
        <nav>
            <ul class="pagination">
                <li>
                    <a href="?p=list_barang&halaman=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                for ($i = 1; $i <= $jumlahHalaman; $i++) {
                ?>
                    <!-- <li class="<?= ($i == $_GET['halaman'] ? 'active' : '') ?>">
                        <a href="?p=list_barang&halaman=<?= $i ?>"><?= $i ?></a>
                    </li> -->
                <?php
                }
                ?>

                <li>
                    <a href="?p=list_barang&halaman
