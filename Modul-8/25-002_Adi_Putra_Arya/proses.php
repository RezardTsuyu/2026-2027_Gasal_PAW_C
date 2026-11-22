<?php
switch ($url) {
    case '/':
        require __DIR__ . '/views/home.php';
        break;

    // transaksi
    case '/transaksi':
        require __DIR__ . '/views/transaksi/transaksi.php';
        break;
    case '/transaksi/add':
        require __DIR__ . '/views/transaksi/transaksiAdd.php';
        break;
    case '/transaksi/edit':
        require __DIR__ . '/views/transaksi/transaksiEdit.php';
        break;
    case '/transaksi/delete':
        require __DIR__ . '/views/transaksi/transaksiDelete.php';
        break;
    case '/transaksi/laporan':
        require __DIR__ . '/views/transaksi/transaksiLaporan.php';
        break;

    // helper aksi
    case '/api/transaksi/delete':
        require __DIR__ . '/actions/transaksi/apiTransaksiDelete.php';
        break;
    case '/api/transaksi/add':
        require __DIR__ . '/actions/transaksi/apiTransaksiAdd.php';
        break;
    case '/api/transaksi/edit':
        require __DIR__ . '/actions/transaksi/apiTransaksiEdit.php';
        break;

   
    // transaksi detail
    case '/transaksiDetail':
        require __DIR__ . '/views/transaksiDetail/transaksiDetail.php';
        break;
    case '/transaksiDetail/add':
        require __DIR__ . '/views/transaksiDetail/transaksiDetailAdd.php';
        break;
    case '/transaksiDetail/edit':
        require __DIR__ . '/views/transaksiDetail/transaksiDetailEdit.php';
        break;
    case '/transaksiDetail/delete':
        require __DIR__ . '/views/transaksiDetail/transaksiDetailDelete.php';
        break;

    // helper aksi
    case '/api/transaksiDetail/delete':
        require __DIR__ . '/actions/transaksiDetail/apiTransaksiDetailDelete.php';
        break;
    case '/api/transaksiDetail/add':
        require __DIR__ . '/actions/transaksiDetail/apiTransaksiDetailAdd.php';
        break;
    case '/api/transaksiDetail/edit':
        require __DIR__ . '/actions/transaksiDetail/apiTransaksiDetailEdit.php';
        break;

    // barang
    case '/barang':
        require __DIR__ . '/views/barang/barang.php';
        break;
    case '/barang/add':
        require __DIR__ . '/views/barang/barangAdd.php';
        break;
    case '/barang/edit':
        require __DIR__ . '/views/barang/barangEdit.php';
        break;
    case '/barang/delete':
        require __DIR__ . '/views/barang/barangDelete.php';
        break;

    // helper aksi
    case '/api/barang/delete':
        require __DIR__ . '/actions/barang/apiBarangDelete.php';
        break;
    case '/api/barang/add':
        require __DIR__ . '/actions/barang/apiBarangAdd.php';
        break;
    case '/api/barang/edit':
        require __DIR__ . '/actions/barang/apiBarangEdit.php';
        break;

    // supplier
    case '/supplier':
        require __DIR__ . '/views/supplier/supplier.php';
        break;
    case '/supplier/add':
        require __DIR__ . '/views/supplier/supplierAdd.php';
        break;
    case '/supplier/edit':
        require __DIR__ . '/views/supplier/supplierEdit.php';
        break;

    // helper aksi
    case '/api/supplier/delete':
        require __DIR__ . '/actions/supplier/apiSupplierDelete.php';
        break;
    case '/api/supplier/add':
        require __DIR__ . '/actions/supplier/apiSupplierAdd.php';
        break;
    case '/api/supplier/edit':
        require __DIR__ . '/actions/supplier/apiSupplierEdit.php';
        break;

    // pelanggan
    case '/pelanggan':
        require __DIR__ . '/views/pelanggan/pelanggan.php';
        break;
    case '/pelanggan/add':
        require __DIR__ . '/views/pelanggan/pelangganAdd.php';
        break;
    case '/pelanggan/edit':
        require __DIR__ . '/views/pelanggan/pelangganEdit.php';
        break;

    // helper aksi
    case '/api/pelanggan/delete':
        require __DIR__ . '/actions/pelanggan/apiPelangganDelete.php';
        break;
    case '/api/pelanggan/add':
        require __DIR__ . '/actions/pelanggan/apiPelangganAdd.php';
        break;
    case '/api/pelanggan/edit':
        require __DIR__ . '/actions/pelanggan/apiPelangganEdit.php';
        break;

    // user
    case '/user':
        require __DIR__ . '/views/user/user.php';
        break;
    case '/user/add':
        require __DIR__ . '/views/user/userAdd.php';
        break;
    case '/user/edit':
        require __DIR__ . '/views/user/userEdit.php';
        break;

    // helper aksi
    case '/api/user/delete':
        require __DIR__ . '/actions/user/apiUserDelete.php';
        break;
    case '/api/user/add':
        require __DIR__ . '/actions/user/apiUserAdd.php';
        break;
    case '/api/user/edit':
        require __DIR__ . '/actions/user/apiUserEdit.php';
        break;

    default:
        require __DIR__ . '/views/notFound.php';
        break;
}
?>