<style>
    .input-group-append {
        margin-left: -1px;
    }

    .input-group-append,
    .input-group-prepend {
        display: -ms-flexbox;
        display: flex;
    }

    .input-group {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-align: stretch;
        align-items: stretch;
        width: 100%;
    }

    .mb-3,
    .my-3 {
        margin-bottom: 1rem !important;
    }

    .mt-3,
    .my-3 {
        margin-top: 1rem !important;
    }

    .file {
        visibility: hidden;
        position: absolute;
    }

    button,
    input {
        overflow: visible;
    }

    .input-group>.form-control {
        position: relative;
        -ms-flex: 1 1 0%;
        flex: 1 1 0%;
        min-width: 0;
        margin-bottom: 0;
    }

    .btn-dark {
        color: #fff;
        background-color: #343a40;
        border-color: #343a40;
    }

    .btn-dark:hover {
        color: #fff;
        background-color: black;
        border-color: black;

    }
</style>
<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Tambah Inventaris</div>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Kode Inventaris</label>
                        <input type="text" class="form-control" name="kode_inventaris" placeholder="Masukkan Kode Barang">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Inventaris</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Barang">
                    </div>
                    <div class="form-group">
                        <label for="">Kondisi</label>
                        <select name="kondisi" id="" class="form-control">
                            <option value="" name="kondisi" class="form-control">- Pilih -</option>
                            <option value="Baik" name="kondisi" class="form-control">Baik</option>
                            <option value="Rusak" name="kondisi" class="form-control">Rusak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" placeholder="Masukkan Jumlah Barang">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Inventaris</label>
                        <select name="id_jenis" id="" class="form-control">
                            <option value="" class="form-control">- PILIH -</option>
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

                    <div class="form-group">
                        <label for="">Nama Ruang</label>
                        <select name="id_ruang" id="" class="form-control">
                            <option value="" class="form-control">- PILIH -</option>
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
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea name="keterangan" id="" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <div id="msg"></div>
                        <input type="file" name="gambar" class="file">
                        <div class="input-group my-3">
                            <input type="text" class="form-control" disabled placeholder="Upload Gambar" id="file">
                            <div class="input-group-append">
                                <button type="button" id="pilih_gambar" class="browse btn btn-dark">Pilih Gambar</button>
                            </div>
                        </div>
                        <!-- <img src="gambar/80x80.png" id="preview" class="img-thumbnail"> -->
                    </div>
                    <div class="form-group hidden">
                        <label for="">petugas</label>
                        <input type="number" name="id_petugas" value="2" class="form-control">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-md btn-primary" name="simpan">Simpan</button>
                        <a href="?p=list_barang" class="btn btn-md btn-default">Kembali</a>
                    </div>
                </form>

                <?php
                if (isset($_POST['simpan'])) {

                    //buat folder untuk simpan file image
                    $tempdir    = "img-barcode/";
                    if (!file_exists($tempdir))
                        mkdir($tempdir, 0755);

                    $target_path    = $tempdir . $_POST['kode_inventaris'] . ".png";
                    //cek apakah server menggunakan http atau https
                    $protocol    = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';

                    //url file image barcode 
                    $fileImage    = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "../lib/barcode.php?text=" . $_POST['kode_inventaris'] . "&codetype=code128&print=true&size=55";

                    //ambil gambar barcode dari url diatas
                    $content    = file_get_contents($fileImage);

                    //simpan gambar ke folder
                    file_put_contents($target_path, $content);

                    $ekstensi_diperbolehkan    = array('png', 'jpg');
                    $gambar = $_FILES['gambar']['name'];
                    $x = explode('.', $gambar);
                    $ekstensi = strtolower(end($x));
                    $file_tmp = $_FILES['gambar']['tmp_name'];

                    $kode_inventaris = $_POST['kode_inventaris'];
                    $nama = $_POST['nama'];
                    $kondisi = $_POST['kondisi'];
                    $jumlah = $_POST['jumlah'];
                    $id_jenis = $_POST['id_jenis'];
                    $id_ruang = $_POST['id_ruang'];
                    $keterangan = $_POST['keterangan'];
                    $id_petugas = $_POST['id_petugas'];

                    if (!empty($gambar)) {
                        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {

                            //Mengupload gambar
                            move_uploaded_file($file_tmp, 'gambar/' . $gambar);

                            $sql = "insert into inventaris (kode_inventaris, gambar, nama, kondisi, jumlah, id_jenis, id_ruang, keterangan, id_petugas) values ('$kode_inventaris', '$gambar', '$nama', '$kondisi', '$jumlah', '$id_jenis', '$id_ruang', '$keterangan', '$id_petugas')";
                            // $sql = "INSERT INTO inventaris SET 
                            // kode_inventaris='$kode_inventaris',
                            // gambar='$gambar';
                            // nama='$nama', 
                            // kondisi='$kondisi',
                            // jumlah='$jumlah', 
                            // id_jenis='$id_jenis', 
                            // id_ruang='$id_ruang', 
                            // keterangan='$keterangan',
                            // id_petugas='$id_petugas' ";

                            $query = mysqli_query($koneksi, $sql);

                            if ($query) {
                                echo "<script>alert('Data berhasil ditambah.');window.location='?p=list_barang';</script>";
                            } else {
                                echo "<script>alert('Data gagal ditambahkan.');window.location='?p=tambah_barang';</script>";
                            }
                        }
                    } else {
                        $gambar = "80x80.png";
                    }
                }

                ?>
            </div>
        </div>
    </div>

</div>