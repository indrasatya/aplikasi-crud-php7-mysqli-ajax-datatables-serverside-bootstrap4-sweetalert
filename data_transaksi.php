<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

    // nama table
    $table = 'transaksi';
    // Table's primary key
    $primaryKey = 'id_transaksi';

    $columns = array(
        array( 'db' => 'id_transaksi', 'dt' => 1 ),
        array(
            'db' => 'tanggal',
            'dt' => 2,
            'formatter' => function( $d, $row ) {
                return date('d-m-Y', strtotime($d));
            }
        ),
        array( 'db' => 'nama_barang', 'dt' => 3 ),
        array(
            'db'        => 'harga_barang',
            'dt'        => 4,
            'formatter' => function( $d, $row ) {
                return 'Rp. '.number_format($d);
            }
        ),
        array(
            'db'        => 'jumlah_beli',
            'dt'        => 5,
            'formatter' => function( $d, $row ) {
                return number_format($d);
            }
        ),
        array(
            'db'        => 'total_bayar',
            'dt'        => 6,
            'formatter' => function( $d, $row ) {
                return 'Rp. '.number_format($d);
            }
        ),
        array( 'db' => 'id_transaksi', 'dt' => 7 )
    );

    // SQL server connection information
    require_once "config/database.php";
    // ssp class
    require 'config/ssp.class.php';
    // require 'config/ssp.class.php';

    echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
    );
} else {
    echo '<script>window.location="index.php"</script>';
}
?>