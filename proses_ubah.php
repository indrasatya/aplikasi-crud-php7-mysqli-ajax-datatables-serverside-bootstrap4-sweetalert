<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
    // panggil file config.php untuk koneksi ke database
    require_once "config/config.php";

    if (isset($_POST['id_transaksi'])) {
        // ambil data hasil post dari ajax
        $id_transaksi = $mysqli->real_escape_string(trim($_POST['id_transaksi']));
        $tanggal      = $mysqli->real_escape_string(trim(date('Y-m-d', strtotime($_POST['tanggal']))));
        $nama_barang  = $mysqli->real_escape_string(trim($_POST['nama_barang']));
        $harga_barang = $mysqli->real_escape_string(trim($_POST['harga_barang']));
        $jumlah_beli  = $mysqli->real_escape_string(trim($_POST['jumlah_beli']));
        $total_bayar  = $mysqli->real_escape_string(trim($_POST['total_bayar']));

        // perintah query untuk mengubah data pada tabel transaksi
        $update = $mysqli->query("UPDATE transaksi SET tanggal      = '$tanggal',
                                                       nama_barang  = '$nama_barang',
                                                       harga_barang = '$harga_barang',
                                                       jumlah_beli  = '$jumlah_beli',
                                                       total_bayar  = '$total_bayar'
                                                 WHERE id_transaksi = '$id_transaksi'")
                                  or die('Ada kesalahan pada query update : '.$mysqli->error);
        // cek query
        if ($update) {
            // jika berhasil tampilkan pesan berhasil ubah data
            echo "sukses";
        } else {
            // jika gagal tampilkan pesan gagal ubah data
            echo "gagal";
        }
    }
    // tutup koneksi
    $mysqli->close();   
} else {
    echo '<script>window.location="index.php"</script>';
}
?>