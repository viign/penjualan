<?php

require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Masuk - Van Java Comp</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Van Java Comp</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">MENU</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                Pesanan
                            </a>
                            <a class="nav-link" href="stock.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                Stok Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-dolly-flatbed"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Admin
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Barang</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Selamat datang di website penjualan Van Java Comp</li>
                        </ol>


                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-secondary mb-4" data-bs-toggle="modal" data-bs-target="#myModal">    
                            Tambah Barang
                            </button>
                        

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Barang
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                    $get = mysqli_query($c,"select * from masuk m, produk p where m.idproduk=p.idproduk");
                                    $i = 1;

                                    while($p=mysqli_fetch_array($get)){
                                    $namaproduk = $p['namaproduk'];
                                    $deskripsi = $p['deskripsi'];
                                    $qty = $p['qty'];
                                    $idmasuk = $p['idmasuk'];
                                    $idproduk = $p['idproduk'];
                                    $tanggal = $p['tanggalmasuk'];
                                    
                                    ?>

                                    
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namaproduk;?> <?=$deskripsi;?></td>
                                            <td><?=$qty;?></td>
                                            <td><?=$tanggal;?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idmasuk;?>">    
                                                Edit
                                                </button> 
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idmasuk;?>">    
                                                Delete
                                                </button>
                                            </td>
                                        </tr>


                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="edit<?=$idmasuk;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Ubah Data Barang Masuk</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>


                                            <form method="post">

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <input type="text" name="namaproduk" class="form-control" placeholder="Nama Produk" value="<?=$namaproduk;?> <?=$deskripsi;?>" disabled>
                                                <input type="number" name="qty" class="form-control mt-3" placeholder="Jumlah Masuk" value="<?=$qty;?>">
                                                <input type="hidden" name="idm" value="<?=$idmasuk;?>">
                                                <input type="hidden" name="idp" value="<?=$idproduk;?>">
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="editdatabarangmasuk">Submit</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                            </form>

                                            </div>
                                        </div>
                                    </div>



                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="delete<?=$idmasuk;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Data Barang Masuk</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>


                                            <form method="post">

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                Apakah anda yakin ingin menghapus data ini?
                                                <input type="hidden" name="idp" value="<?=$idproduk;?>">
                                                <input type="hidden" name="idm" value="<?=$idmasuk;?>">
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="hapusdatabarangmasuk">Hapus</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                            </form>

                                            </div>
                                        </div>
                                    </div>


                                        <?php
                                        }; //end of while
                                        ?>

                                    </tbody>
                                </table>



                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Daffa Vignaditya 2022</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>


   <!-- The Modal -->
   <div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Barang</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>


      <form method="post">

      <!-- Modal body -->
      <div class="modal-body">
        Pilih Barang
        <select name="idproduk" class="form-control">

        <?php
        $getproduk = mysqli_query($c,"select * from produk");

        while($pl=mysqli_fetch_array($getproduk)){
            $namaproduk = $pl['namaproduk'];
            $stock = $pl['stock'];
            $deskripsi = $pl['deskripsi'];
            $idproduk = $pl['idproduk'];
        ?>

        <option value="<?=$idproduk;?>"><?=$namaproduk;?> - <?=$deskripsi;?> (Stok : <?=$stock;?>)</option>
        
        <?php
        }
        ?>

        </select>

        <input type="number" name="qty" class="form-control mt-4" placeholder="Jumlah" min="1" required>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" name="barangmasuk">Submit</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
      </form>

    </div>
    
  </div>

</html>
