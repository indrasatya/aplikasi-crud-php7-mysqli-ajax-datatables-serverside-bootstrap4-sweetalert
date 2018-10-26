<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	// panggil file config.php untuk koneksi ke database
	require_once "config/config.php";

	// fungsi untuk membuat id transaksi
	$result = $mysqli->query("SELECT RIGHT(id_transaksi,4) as kode FROM transaksi ORDER BY id_transaksi DESC LIMIT 1")
	                          or die('Ada kesalahan pada query tampil data id_transaksi: '.$mysqli->error);
	$rows = $result->num_rows;
	// cek id_transaksi
	if ($rows <> 0) {
	    // mengambil data id_transaksi
	    $data = $result->fetch_assoc();
	    $kode = $data['kode']+1; 			// jika sudah ada id_transaksi maka nomor urut + 1
	} else {
	    $kode = 1;							// jika belum ada id_transaksi maka nomor urut = 1
	}
	// buat id_transaksi
	$tanggal      = date("Ymd");                             // Tahun-Bulan-Hari
	$buat_id      = str_pad($kode, 4, "0", STR_PAD_LEFT);    // Nomor Urut
	$id_transaksi = "T-$tanggal-$buat_id";
	// ambil data hasil post dari ajax
	$tanggal      = $mysqli->real_escape_string(trim(date('Y-m-d', strtotime($_POST['tanggal']))));
	$nama_barang  = $mysqli->real_escape_string(trim($_POST['nama_barang']));
	$harga_barang = $mysqli->real_escape_string(trim($_POST['harga_barang']));
	$jumlah_beli  = $mysqli->real_escape_string(trim($_POST['jumlah_beli']));
	$total_bayar  = $mysqli->real_escape_string(trim($_POST['total_bayar']));

	// perintah query untuk menyimpan data ke tabel transaksi
	$insert = $mysqli->query("INSERT INTO transaksi(id_transaksi,tanggal,nama_barang,harga_barang,jumlah_beli,total_bayar)
	                          VALUES('$id_transaksi','$tanggal','$nama_barang','$harga_barang','$jumlah_beli','$total_bayar')")
	                          or die('Ada kesalahan pada query insert : '.$mysqli->error); 
	// cek query
	if ($insert) {
	    // jika berhasil tampilkan pesan berhasil simpan data
	    echo "sukses";
	} else {
		// jika gagal tampilkan pesan gagal simpan data
	    echo "gagal";
	}
	// tutup koneksi
	$mysqli->close();   
} else {
    echo '<script>window.location="index.php"</script>';
}
?>