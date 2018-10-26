<!-- Aplikasi CRUD dengan PHP 7, MySQLi, Ajax, DataTables ServerSide, Bootstrap 4, dan SweetAlert 
*************************************************************************************************
* Developer    : Indra Styawantoro
* Company      : Indra Studio
* Release Date : Oktober 2018
* Update       : -
* Website      : www.indrasatya.com
* E-mail       : indra.setyawantoro@gmail.com
* Phone / WA   : +62-813-7778-3334
-->

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Aplikasi CRUD dengan PHP 7, MySQLi, Ajax, DataTables ServerSide, Bootstrap 4, dan SweetAlert">
        <meta name="keywords" content="Aplikasi CRUD dengan PHP 7, MySQLi, Ajax, DataTables ServerSide, Bootstrap 4, dan SweetAlert">
        <meta name="author" content="Indra Styawantoro">
        
        <!-- favicon -->
        <link rel="shortcut icon" href="assets/img/favicon.png">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/DataTables/css/dataTables.bootstrap4.min.css">
        <!-- datepicker CSS -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/datepicker/css/datepicker.min.css">
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/fontawesome-free-5.4.1-web/css/all.min.css">
        <!-- Sweetalert CSS -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/sweetalert/css/sweetalert.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <!-- Fungsi untuk membatasi karakter yang diinputkan -->
        <script type="text/javascript" src="assets/js/fungsi_validasi_karakter.js"></script>

        <title>Data Transaksi Penjualan</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
                <h5 class="my-0 mr-md-auto font-weight-normal"><i class="fas fa-shopping-cart title-icon"></i> Data Transaksi Penjualan</h5>
                <a class="btn btn-info" id="btnTambah" href="#" data-toggle="modal" data-target="#modalTambah" role="button"><i class="fas fa-plus"></i> Tambah</a>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Tabel transaksi penjualan untuk menampilkan data transaksi penjualan dari database -->
                    <table id="tabel-transaksi" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>ID Transaksi</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Harga Barang</th>
                                <th>Jumlah Beli</th>
                                <th>Total Pembayaran</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal tambah data transaksi penjualan -->
        <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambah" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Input Data Transaksi Penjualan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="formTambah">
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="tanggal" name="tanggal" autocomplete="off" value="<?php echo date("d-m-Y"); ?>">
                            </div>

                            <div class="form-group">
                                <label>Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Harga Barang</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend"><div class="input-group-text">Rp.</div></div>
                                    <input type="text" class="form-control" id="harga_barang" name="harga_barang" onkeyup="hitung_total_bayar(this)" onKeyPress="return goodchars(event,'0123456789.',this)" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Jumlah Beli</label>
                                <input type="text" class="form-control" id="jumlah_beli" name="jumlah_beli" onkeyup="hitung_total_bayar(this)" onKeyPress="return goodchars(event,'0123456789',this)" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Total Pembayaran</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend"><div class="input-group-text">Rp.</div></div>
                                    <input type="text" class="form-control" id="total_bayar" name="total_bayar" autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info btn-submit" id="btnSimpan">Simpan</button>
                            <button type="button" class="btn btn-secondary btn-reset" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal ubah data transaksi penjualan -->
        <div class="modal fade" id="modalUbah" tabindex="-1" role="dialog" aria-labelledby="modalUbah" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Ubah Data Transaksi Penjualan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="formUbah">
                        <div class="modal-body">

                            <div class="form-group">
                                <label>ID Transaksi</label>
                                <input type="text" class="form-control" id="id_transaksi" name="id_transaksi" autocomplete="off" readonly>
                            </div>

                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="tanggal_ubah" name="tanggal" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang_ubah" name="nama_barang" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Harga Barang</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend"><div class="input-group-text">Rp.</div></div>
                                    <input type="text" class="form-control" id="harga_barang_ubah" name="harga_barang" onkeyup="hitung_total_bayar_ubah(this)" onKeyPress="return goodchars(event,'0123456789.',this)" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Jumlah Beli</label>
                                <input type="text" class="form-control" id="jumlah_beli_ubah" name="jumlah_beli" onkeyup="hitung_total_bayar_ubah(this)" onKeyPress="return goodchars(event,'0123456789',this)" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Total Pembayaran</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend"><div class="input-group-text">Rp.</div></div>
                                    <input type="text" class="form-control" id="total_bayar_ubah" name="total_bayar" autocomplete="off" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info btn-submit" id="btnUbah">Ubah</button>
                            <button type="button" class="btn btn-secondary btn-reset" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <footer class="pt-4 my-md-4 pt-md-3 border-top">
                <div class="row">
                    <div class="col-12 col-md center">
                        &copy; 2018 - <a class="text-info" href="http://www.indrasatya.com/">www.indrasatya.com</a>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script type="text/javascript" src="assets/js/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="assets/js/popper.min.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <!-- fontawesome Plugin JS -->
        <script type="text/javascript" src="assets/plugins/fontawesome-free-5.4.1-web/js/all.min.js"></script>
        <!-- DataTables Plugin JS -->
        <script type="text/javascript" src="assets/plugins/DataTables/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="assets/plugins/DataTables/js/dataTables.bootstrap4.min.js"></script>
        <!-- datepicker Plugin JS -->
        <script type="text/javascript" src="assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script>
        <!-- SweetAlert Plugin JS -->
        <script type="text/javascript" src="assets/plugins/sweetalert/js/sweetalert.min.js"></script>

        <script type="text/javascript">
        // fungsi untuk menghitung total bayar pada form tambah
        function hitung_total_bayar(input) {
            var harga  = $('#harga_barang').val();
            var jumlah = $('#jumlah_beli').val();

            if (jumlah=='') {
                var total = '';
            } else {
                var total = harga * jumlah;
            }
            $('#total_bayar').val(total);
        }

        // fungsi untuk menghitung total bayar pada form ubah
        function hitung_total_bayar_ubah(input) {
            var harga  = $('#harga_barang_ubah').val();
            var jumlah = $('#jumlah_beli_ubah').val();

            if (jumlah=='') {
                var total = '';
            } else {
                var total = harga * jumlah;
            }
            $('#total_bayar_ubah').val(total);
        }

        $(document).ready(function(){
            // initiate plugin ====================================================================================
            // ----------------------------------------------------------------------------------------------------
            // datepicker plugin
            $('.date-picker').datepicker({
                autoclose: true,
                todayHighlight: true
            });

            // dataTables plugin
            $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings)
            {
                return {
                    "iStart": oSettings._iDisplayStart,
                    "iEnd": oSettings.fnDisplayEnd(),
                    "iLength": oSettings._iDisplayLength,
                    "iTotal": oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                    "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                };
            };
            // ====================================================================================================

            // Tampil Data ========================================================================================
            // ----------------------------------------------------------------------------------------------------
            // datatables serverside processing
            var table = $('#tabel-transaksi').DataTable( {
                "bAutoWidth": false,
                "scrollY": '58vh',
                "scrollCollapse": true,
                "processing": true,
                "serverSide": true,
                "ajax": 'data_transaksi.php',     // panggil file data_transaksi.php untuk menampilkan data transaksi dari database
                "columnDefs": [ 
                    { "targets": 0, "data": null, "orderable": false, "searchable": false, "width": '30px', "className": 'center' },
                    { "targets": 1, "width": '130px', "className": 'center' },
                    { "targets": 2, "width": '80px', "className": 'center' },
                    { "targets": 3, "width": '170px' },
                    { "targets": 4, "width": '100px', "className": 'right' },
                    { "targets": 5, "width": '80px', "className": 'right' },
                    { "targets": 6, "width": '120px', "className": 'right' },
                    {
                      "targets": 7, "data": null, "orderable": false, "searchable": false, "width": '70px', "className": 'center',
                      "render": function(data, type, row) {
                          var btn = "<a style=\"margin-right:7px\" title=\"Ubah\" class=\"btn btn-info btn-sm getUbah\" href=\"#\"><i class=\"fas fa-edit\"></i></a><a title=\"Hapus\" class=\"btn btn-danger btn-sm btnHapus\" href=\"#\"><i class=\"fas fa-trash\"></i></a>";
                          return btn;
                      } 
                    } 
                ],
                "order": [[ 1, "desc" ]],           // urutkan data berdasarkan id_transaksi secara descending
                "iDisplayLength": 10,               // tampilkan 10 data
                "rowCallback": function (row, data, iDisplayIndex) {
                    var info   = this.fnPagingInfo();
                    var page   = info.iPage;
                    var length = info.iLength;
                    var index  = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html(index);
                }
            } );
            // ====================================================================================================

            // Simpan Data ========================================================================================
            // ----------------------------------------------------------------------------------------------------
            // Tampikan Form Tambah Data
            $('#btnTambah').click(function(reload){
                // reset form
                $('#formTambah')[0].reset();
            });

            // Proses Simpan Data
            $('#btnSimpan').click(function(){
                // Validasi form input
                // jika tanggal kosong
                if ($('#tanggal').val()==""){
                    // focus ke input tanggal
                    $( "#tanggal" ).focus();
                    // tampilkan peringatan data tidak boleh kosong
                    swal("Peringatan!", "Tanggal tidak boleh kosong.", "warning");
                }
                // jika nama_barang kosong
                else if ($('#nama_barang').val()==""){
                    // focus ke input nama_barang
                    $( "#nama_barang" ).focus();
                    // tampilkan peringatan data tidak boleh kosong
                    swal("Peringatan!", "Nama barang tidak boleh kosong.", "warning");
                }
                // jika harga_barang kosong atau 0 (nol)
                else if ($('#harga_barang').val()=="" || $('#harga_barang').val()==0){
                    // focus ke input harga_barang
                    $( "#harga_barang" ).focus();
                    // tampilkan peringatan data tidak boleh kosong
                    swal("Peringatan!", "Harga barang tidak boleh kosong atau 0 (nol).", "warning");
                }
                // jika jumlah_beli kosong atau 0 (nol)
                else if ($('#jumlah_beli').val()=="" || $('#jumlah_beli').val()==0){
                    // focus ke input jumlah_beli
                    $( "#jumlah_beli" ).focus();
                    // tampilkan peringatan data tidak boleh kosong
                    swal("Peringatan!", "Jumlah beli tidak boleh kosong atau 0 (nol).", "warning");
                }
                // jika semua data sudah terisi, jalankan perintah simpan data
                else{
                    var data = $('#formTambah').serialize();
                    $.ajax({
                        type : "POST",
                        url  : "proses_simpan.php",
                        data : data,
                        success: function(result){                          // ketika sukses menyimpan data
                            if (result==="sukses") {
                                // tutup modal tambah data transaksi
                                $('#modalTambah').modal('hide');
                                // tampilkan pesan sukses simpan data
                                swal("Sukses!", "Data Transaksi Penjualan berhasil disimpan.", "success");
                                // tampilkan data transaksi
                                var table = $('#tabel-transaksi').DataTable(); 
                                table.ajax.reload( null, false );
                            } else {
                                // tampilkan pesan gagal simpan data
                                swal("Gagal!", "Data Transaksi Penjualan tidak bisa disimpan.", "error");
                            }
                        }
                    });
                    return false;
                }
            });
            // ====================================================================================================

            // Ubah Data ==========================================================================================
            // ----------------------------------------------------------------------------------------------------
            // Tampilkan Form Ubah Data
            $('#tabel-transaksi tbody').on( 'click', '.getUbah', function (){
                var data = table.row( $(this).parents('tr') ).data();
                var id_transaksi = data[ 1 ];
                
                $.ajax({
                    type : "GET",
                    url  : "get_transaksi.php",
                    data : {id_transaksi:id_transaksi},
                    dataType : "JSON",
                    success: function(result){
                        // ubah tanggal menjadi d-m-Y
                        var tgl           = result.tanggal;
                        var dateAr        = tgl.split('-');
                        var tgl_transaksi = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
                        // tampilkan modal ubah data transaksi
                        $('#modalUbah').modal('show');
                        // tampilkan data transaksi
                        $('#id_transaksi').val(result.id_transaksi);
                        $('#tanggal_ubah').val(tgl_transaksi);
                        $('#nama_barang_ubah').val(result.nama_barang);
                        $('#harga_barang_ubah').val(result.harga_barang);
                        $('#jumlah_beli_ubah').val(result.jumlah_beli);
                        $('#total_bayar_ubah').val(result.total_bayar);
                    }
                });
            });

            // Proses Ubah Data
            $('#btnUbah').click(function(){
                // Validasi form input
                // jika tanggal_ubah kosong
                if ($('#tanggal_ubah').val()==""){
                    // focus ke input tanggal_ubah
                    $( "#tanggal_ubah" ).focus();
                    // tampilkan peringatan data tidak boleh kosong
                    swal("Peringatan!", "Tanggal tidak boleh kosong.", "warning");
                }
                // jika nama_barang_ubah kosong
                else if ($('#nama_barang_ubah').val()==""){
                    // focus ke input nama_barang_ubah
                    $( "#nama_barang_ubah" ).focus();
                    // tampilkan peringatan data tidak boleh kosong
                    swal("Peringatan!", "Nama barang tidak boleh kosong.", "warning");
                }
                // jika harga_barang_ubah kosong atau 0 (nol)
                else if ($('#harga_barang_ubah').val()=="" || $('#harga_barang_ubah').val()==0){
                    // focus ke input harga_barang_ubah
                    $( "#harga_barang_ubah" ).focus();
                    // tampilkan peringatan data tidak boleh kosong
                    swal("Peringatan!", "Harga barang tidak boleh kosong atau 0 (nol).", "warning");
                }
                // jika jumlah_beli_ubah kosong atau 0 (nol)
                else if ($('#jumlah_beli_ubah').val()=="" || $('#jumlah_beli_ubah').val()==0){
                    // focus ke input jumlah_beli_ubah
                    $( "#jumlah_beli_ubah" ).focus();
                    // tampilkan peringatan data tidak boleh kosong
                    swal("Peringatan!", "Jumlah beli tidak boleh kosong atau 0 (nol).", "warning");
                }
                // jika semua data sudah terisi, jalankan perintah ubah data
                else{
                    var data = $('#formUbah').serialize();
                    $.ajax({
                        type : "POST",
                        url  : "proses_ubah.php",
                        data : data,
                        success: function(result){                          // ketika sukses mengubah data
                            if (result==="sukses") {
                                // tutup modal ubah data transaksi
                                $('#modalUbah').modal('hide');
                                // tampilkan pesan sukses ubah data
                                swal("Sukses!", "Data Transaksi Penjualan berhasil diubah.", "success");
                                // tampilkan data transaksi
                                var table = $('#tabel-transaksi').DataTable(); 
                                table.ajax.reload( null, false );
                            } else {
                                // tampilkan pesan gagal ubah data
                                swal("Gagal!", "Data Transaksi Penjualan tidak bisa diubah.", "error");
                            }
                        }
                    });
                    return false;
                }
            });
            // ====================================================================================================
            
            // Proses Hapus Data ==================================================================================
            // ----------------------------------------------------------------------------------------------------
            $('#tabel-transaksi tbody').on( 'click', '.btnHapus', function (){
                var data = table.row( $(this).parents('tr') ).data();
                // tampilkan notifikasi saat akan menghapus data
                swal({
                    title: "Apakah Anda Yakin?",
                    text: "Anda akan menghapus data transaksi penjualan dengan ID Penjualan : "+ data[ 1 ] +"",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Hapus!",
                    closeOnConfirm: false
                }, 
                // jika dipilih ya, maka jalankan perintah hapus data
                function () {
                    var id_transaksi = data[ 1 ];
                    $.ajax({
                        type : "POST",
                        url  : "proses_hapus.php",
                        data : {id_transaksi:id_transaksi},
                        success: function(result){                          // ketika sukses menghapus data
                            if (result==="sukses") {
                                // tampilkan pesan sukses hapus data
                                swal("Sukses!", "Data Transaksi Penjualan berhasil dihapus.", "success");
                                // tampilkan data transaksi
                                var table = $('#tabel-transaksi').DataTable(); 
                                table.ajax.reload( null, false );
                            } else {
                                // tampilkan pesan gagal hapus hapus data
                                swal("Gagal!", "Data Transaksi Penjualan tidak bisa dihapus.", "error");
                            }
                        }
                    });
                });
            });
            // ====================================================================================================
        });
        </script>
    </body>
</html>