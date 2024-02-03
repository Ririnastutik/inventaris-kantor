<?php
$id_inventaris = $_GET['id_inventaris'];
if (empty($id_inventaris)) {
?>
    <script type="text/javascript">
        window.location.href = "?p=list_barang";
    </script>
<?php
}
$sql = "SELECT *, inventaris.keterangan as ket FROM inventaris LEFT JOIN ruang ON ruang.id_ruang = inventaris.id_ruang LEFT JOIN jenis ON jenis.id_jenis = inventaris.id_jenis WHERE id_inventaris = '$id_inventaris'";
$query = mysqli_query($koneksi, $sql);
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $data = mysqli_fetch_array($query);
} else {
    $data = NULL;
}
$tgl = $data['tanggal_register'];
?>
<div class="container">
    <div class="row">
        <h2 class="text-center">Detail Barang Inventaris <?= $data['nama'] ?></h2>
        <hr>

    </div>
    <div class="row mb-3">
        <div class="col-sm-6">
            <a href="#gambar-1">
                <img src="gambar/<?php echo $data['gambar']; ?>" id="preview" class="img-thumbnail thumb">
            </a>
        </div>
        <!-- Menampilkan popup gambar -->
        <div class="overlay" id="gambar-1">
            <a href="#" class="close">
                <svg style="width:47px;height:47px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2C6.47,2 2,6.47 2,12C2,17.53 6.47,22 12,22C17.53,22 22,17.53 22,12C22,6.47 17.53,2 12,2M14.59,8L12,10.59L9.41,8L8,9.41L10.59,12L8,14.59L9.41,16L12,13.41L14.59,16L16,14.59L13.41,12L16,9.41L14.59,8Z" />
                </svg>
            </a>
            <img src="gambar/<?php echo $data['gambar']; ?>" alt="Nelayan Kode">
        </div>
        <div class="col-sm-6 themed-grid-col">
            <table class="table table-nobordered table-striped no-border" width="100%">
                
                <tr>
                    <th>Kode Inventaris</th>
                    <td>:</td>
                    <td><?= $data['kode_inventaris'] ?></td>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <td>:</td>
                    <td><?= $data['nama'] ?></td>
                </tr>

                <tr>
                    <th>Tanggal Masuk</th>
                    <td>:</td>
                    <td><?= date("d-m-Y", strtotime($tgl)) ?></td>
                </tr>
                <tr>
                    <th>Kondisi Barang</th>
                    <td>:</td>
                    <td><?= $data['kondisi'] ?></td>
                </tr>
                <tr>
                    <th>Jumlah Stok Barang</th>
                    <td>:</td>
                    <td><?= $data['jumlah'] ?></td>
                </tr>
                <tr>
                    <th>Ruangan Barang</th>
                    <td>:</td>
                    <td><?= $data['nama_ruang'] ?></td>
                </tr>
                <tr>
                    <th>Keterangan Barang</th>
                    <td>:</td>
                    <td><?= $data['ket'] ?></td>
                </tr>

            </table>
            <div>
                <a href="?p=edit_barang&id_inventaris=<?= $data['id_inventaris'] ?>" class="btn btn-md btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit Barang</a>
                <a href="?p=list_barang" class="btn btn-md btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Kembali</a>
            </div>
        </div>
    </div>
</div>