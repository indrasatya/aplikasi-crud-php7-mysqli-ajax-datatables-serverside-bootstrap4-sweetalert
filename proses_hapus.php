<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
    // panggil file config.php untuk koneksi ke database
    require_once "config/config.php";
    // jika tombol hapus diklik
    if (isset($_POST['id_transaksi'])) {
        // ambil data post dari ajax 
        $id_transaksi = $_POST['id_transaksi'];
        // perintah query untuk menghapus data pada tabel transaksi
        $delete = $mysqli->query("DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'")
                                  or die('Ada kesalahan pada query delete : '.$mysqli->error);
        // cek hasil query
        if ($delete) {
            // jika berhasil tampilkan pesan berhasil hapus data
            echo "sukses";
        } else {
            // jika gagal tampilkan pesan gagal hapus data
            echo "gagal";
        }
    }
    // tutup koneksi
    $mysqli->close();   
} else {
    echo '<script>window.location="index.php"</script>';
}
?>