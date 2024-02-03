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

?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Edit Inventaris <?= $data['nama'] ?></div>
            <div class="panel-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group col-md-4">
                        <label for="">Kode Inventaris</label>
                        <input type="text" class="form-control" name="kode_inventaris" value="<?= $data['kode_inventaris'] ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Nama Inventaris</label>
                        <input type="text" class="form-control" name="nama" value="<?= $data['nama'] ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Kondisi</label>
                        <select name="kondisi" id="" class="form-control">
                            <option value="<?= $data['kondisi'] ?>" name="kondisi" class="form-control"><?= $data['kondisi'] ?></option>
                            <option value="Baik" name="kondisi" class="form-control">Baik</option>
                            <option value="Rusak" name="kondisi" class="form-control">Rusak</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" value="<?= $data['jumlah'] ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Jenis Inventaris</label>
                        <select name="id_jenis" id="" class="form-control">
                            <option value="<?= $data['id_jenis'] ?>" class="form-control"><?= $data['nama_jenis'] ?></option>
                            <?php
                            $sql_jenis = "SELECT * FROM jenis";
                            $q_jenis = mysqli_query($koneksi, $sql_jenis);
                            while ($jenis = mysqli_fetch_array($q_jenis)) {
                            ?>
                                <option value="<?= $jenis['id_jenis'] ?>"><?= $jenis['nama_jenis'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Nama Ruang</label>
                        <select name="id_ruang" id="" class="form-control">
                            <option value="<?= $data['id_ruang'] ?>" class="form-control"><?= $data['nama_ruang'] ?></option>
                            <?php
                            $sql_ruang = "SELECT * FROM ruang";
                            $q_ruang = mysqli_query($koneksi, $sql_ruang);
                            while ($ruang = mysqli_fetch_array($q_ruang)) {
                            ?>
                                <option value="<?= $ruang['id_ruang'] ?>"><?= $ruang['nama_ruang'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Keterangan</label>
                        <textarea name="ket" id="" cols="30" rows="5" class="form-control" value="<?= $data['ket'] ?>"><?= $data['ket'] ?></textarea>
                    </div>
                    <div class="form-group col-md-4">
                        <div id="msg"></div>
                        <input type="file" name="gambar" class="file">
                        <div class="input-group my-3">
                            <input type="text" class="form-control" disabled placeholder="Upload Gambar" id="file">
                            <div class="input-group-append">
                                <button type="button" id="pilih_gambar" class="browse btn btn-dark">Pilih Gambar</button>
                            </div>
                        </div>
                        <img src="gambar/<?php echo $data['gambar']; ?>" id="preview" class="img-thumbnail">
                    </div>
                    <div class="form-group col-md-12">
                        <button class="btn btn-md btn-primary" name="simpan" type="submit">Simpan</button>
                        <a href="?p=list_barang" class="btn btn-md btn-default">Kembali</a>
                    </div>
                </form>

                <?php
                if (isset($_POST['simpan'])) {
                    // membuat variabel untuk menampung data dari form
                    $kode_inventaris = $_POST['kode_inventaris'];
                    $nama = $_POST['nama'];
                    $kondisi = $_POST['kondisi'];
                    $jumlah = $_POST['jumlah'];
                    $id_jenis = $_POST['id_jenis'];
                    $id_ruang = $_POST['id_ruang'];
                    $ket = $_POST['ket'];
                    $gambar = $_FILES['gambar']['name'];
                    //cek dulu jika merubah gambar produk jalankan coding ini
                    if ($gambar != "") {
                        $ekstensi_diperbolehkan = array('png', 'jpg', 'JPG'); //ekstensi file gambar yang bisa diupload 
                        $x = explode('.', $gambar); //memisahkan nama file dengan ekstensi yang diupload
                        $ekstensi = strtolower(end($x));
                        $file_tmp = $_FILES['gambar']['tmp_name'];
                        $angka_acak     = rand(1, 999);
                        $nama_gambar_baru = $angka_acak . '-' . $gambar; //menggabungkan angka acak dengan nama file sebenarnya
                        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                            move_uploaded_file($file_tmp, 'gambar/' . $nama_gambar_baru); //memindah file gambar ke folder gambar

                            // jalankan query UPDATE berdasarkan ID yang produknya kita edit
                            // $query  = "UPDATE produk SET nama_produk = '$nama_produk', deskripsi = '$deskripsi', harga_beli = '$harga_beli', harga_jual = '$harga_jual', gambar_produk = '$nama_gambar_baru'";
                            $query = "UPDATE inventaris SET 
                            kode_inventaris='$kode_inventaris',
                            nama='$nama', 
                            kondisi='$kondisi',
                            jumlah='$jumlah', 
                            id_jenis='$id_jenis', 
                            id_ruang='$id_ruang', 
                            keterangan='$ket',
                            gambar= '$nama_gambar_baru'";
                            $query .= "WHERE id_inventaris = '$id_inventaris'";
                            $result = mysqli_query($koneksi, $query);
                            // periska query apakah ada error
                            if (!$result) {
                                die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
                                    " - " . mysqli_error($koneksi));
                            } else {
                                //tampil alert dan akan redirect ke halaman index.php
                                //silahkan ganti index.php sesuai halaman yang akan dituju
                                echo "<script>alert('Data berhasil diubah.');window.location='?p=list_barang';</script>";
                            }
                        } else {
                            //jika file ekstensi tidak jpg dan png maka alert ini yang tampil
                            echo "<script>alert('Ekstensi gambar yang boleh hanya jpg atau png.');window.location='?p=list_barang';</script>";
                        }
                    } else {
                        // jalankan query UPDATE berdasarkan ID yang produknya kita edit
                        $query  = "UPDATE inventaris SET 
                        kode_inventaris='$kode_inventaris',
                        nama='$nama', 
                        kondisi='$kondisi',
                        jumlah='$jumlah', 
                        id_jenis='$id_jenis', 
                        id_ruang='$id_ruang', 
                        keterangan='$ket'";
                        $query .= "WHERE id_inventaris = '$id_inventaris'";
                        $result = mysqli_query($koneksi, $query);
                        // periska query apakah ada error
                        if (!$result) {
                            die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
                                " - " . mysqli_error($koneksi));
                        } else {
                            //tampil alert dan akan redirect ke halaman index.php
                            //silahkan ganti index.php sesuai halaman yang akan dituju
                            echo "<script>alert('Data berhasil diubah.');window.location='?p=list_barang';</script>";
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

</div>