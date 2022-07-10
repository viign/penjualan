<?php

session_start();

//Koneksi
$c = mysqli_connect('localhost','root','','vanjava');

//Login
if(isset($_POST['login'])){
    //Initiate variabel
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($c,"SELECT * FROM user WHERE username='$username' and password='$password' ");
    $hitung = mysqli_num_rows($check);

    if($hitung>0){
        //Jika ketemu
        //berhasil login

        $_SESSION['login'] = 'True';
        header('location:index.php');
    } else{
        //gak ketemu
        //gagal login
        echo'
        <script>alert("Username atau Password salah!");
        window.location.href="login.php"
        </script>
        ';
    }
}


if(isset($_POST['tambahbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $insert = mysqli_query($c,"insert into produk (namaproduk,deskripsi,harga,stock) values ('$namaproduk','$deskripsi','$harga','$stock')");

    if($insert){
        header('location:stock.php');
    } else {
        echo'
        <script>alert("Gagal menambah barang!");
        window.location.href="stock.php"
        </script>
        ';  
    }
};


if(isset($_POST['tambahpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $insert = mysqli_query($c,"insert into pelanggan (namapelanggan,notelp,alamat) values ('$namapelanggan','$notelp','$alamat')");

    if($insert){
        header('location:pelanggan.php');
    } else {
        echo'
        <script>alert("Gagal menambah pelanggan!");
        window.location.href="pelanggan.php"
        </script>
        ';  
    }
}


if(isset($_POST['tambahpesanan'])){
    $idpelanggan = $_POST['idpelanggan'];

    $insert = mysqli_query($c,"insert into pesanan (idpelanggan) values ('$idpelanggan')");

    if($insert){
        header('location:index.php');
    } else {
        echo'
        <script>alert("Gagal menambah pesanan!");
        window.location.href="index.php"
        </script>
        ';  
    }
}


//Produk dipilih di pesanan
if(isset($_POST['addproduk'])){
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp']; // idpesanan
    $qty = $_POST['qty'];

    //hitung stok sekarang
    $hitung1 = mysqli_query($c,"select * from produk where idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stocksekarang = $hitung2['stock']; //stok barang saat ini

    if($stocksekarang>=$qty){
        $selisih = $stocksekarang-$qty;


        //stok cukup
        $insert = mysqli_query($c,"insert into detailpesanan (idpesanan,idproduk,qty) values ('$idp','$idproduk','$qty')");
        $update = mysqli_query($c,"update produk set stock='$selisih' where idproduk='$idproduk'");

        if($insert&&$update){
            header('location:view.php?idp='.$idp);
        } else {
            echo'
            <script>alert("Gagal menambah pesanan!");
            window.location.href="view.php?idp='.$idp.'"
            </script>
            ';  
        }
    } else {
        //ga cukup
        echo'
        <script>alert("Stok barang tidak cukup!");
        window.location.href="view.php?idp='.$idp.'"
        </script>
        '; 
    }
}



//Menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    //cari tau syok sekarang
    $caristock = mysqli_query($c,"select * from produk where idproduk='$idproduk'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    //hitung
    $newstock = $stocksekarang+$qty;

    $insertb = mysqli_query($c,"insert into masuk (idproduk,qty) values('$idproduk','$qty')");
    $updatetb = mysqli_query($c,"update produk set stock='$newstock' where idproduk='$idproduk'");

    if($insertb&&$updatetb){
        header('location:masuk.php');
    } else {
        //ga cukup
        echo'
        <script>alert("Gagal!");
        window.location.href="masuk.php"
        </script>
        '; 
    }
}


//HAPUS PRODUK PESANAN
if(isset($_POST['hapusprodukpesanan'])){
    $idp = $_POST['idp'];
    $idpr = $_POST['idpr'];
    $idorder = $_POST['idorder'];

    //Cek qty sekarang
    $cek1 = mysqli_query($c,"select * from detailpesanan where iddetailpesanan='$idp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    //cek stok sekarang
    $cek3 = mysqli_query($c,"select * from produk where idproduk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stocksekarang = $cek4['stock'];

    $hitung = $stocksekarang+$qtysekarang;

    $update = mysqli_query($c,"update produk set stock='$hitung' where idproduk='$idpr'"); //update stock
    $hapus = mysqli_query($c,"delete from detailpesanan where idproduk='$idpr' and iddetailpesanan='$idp'");

    if($update&&$hapus){
        header('location:view.php?idp='.$idorder);
    } else {
        echo'
        <script>alert("Gagal menghapus barang!");
        window.location.href="view.php?idp='.$idorder.'"
        </script>
        ';  
    }
}


//edit barang
if(isset($_POST['editbarang'])){
    $np = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idp = $_POST['idp']; //ini idproduk

    $query = mysqli_query($c,"update produk set namaproduk='$np', deskripsi='$deskripsi', harga='$harga' where idproduk='$idp' ");

    if($query){
        header('location:stock.php');
    } else {
        echo'
        <script>alert("Gagal ubah barang!");
        window.location.href="stock.php"
        </script>
        ';
    }
}



//Hapus barang
if(isset($_POST['hapusbarang'])){
    $idp = $_POST['idp'];

    $query = mysqli_query($c,"delete from produk where idproduk='$idp'");

    if($query){
        header('location:stock.php');
    } else {
        echo'
        <script>alert("Gagal hapus barang!");
        window.location.href="stock.php"
        </script>
        ';
    }
}


//edit pelanggan
if(isset($_POST['editpelanggan'])){
    $np = $_POST['namapelanggan'];
    $nt = $_POST['notelp'];
    $a = $_POST['alamat'];
    $id = $_POST['idpl'];

    $query = mysqli_query($c,"update pelanggan set namapelanggan='$np', notelp='$nt', alamat='$a' where idpelanggan='$id' ");

    if($query){
        header('location:pelanggan.php');
    } else {
        echo'
        <script>alert("Gagal ubah pelanggan!");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}


//Hapus pelanggan
if(isset($_POST['hapuspelanggan'])){
    $idpl = $_POST['idpl'];

    $query = mysqli_query($c,"delete from pelanggan where idpelanggan='$idpl'");

    if($query){
        header('location:pelanggan.php');
    } else {
        echo'
        <script>alert("Gagal hapus pelanggan!");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}


//mengubah data barang masuk
if(isset($_POST['editdatabarangmasuk'])){
    $qty = $_POST['qty'];
    $idm = $_POST['idm']; //ini idmasuk
    $idp = $_POST['idp']; //ini idproduk

    //cari tau qty dulu
    $caritahu = mysqli_query($c,"select * from masuk where idmasuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tau syok sekarang
    $caristock = mysqli_query($c,"select * from produk where idproduk='$idp'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];


    if($qty >= $qtysekarang){
        //kalau input lebih besar dari qty sekarang
        //menghitung selisih
        $selisih = $qty-$qtysekarang;
        $newstock = $stocksekarang+$selisih;

        $query1 = mysqli_query($c,"update masuk set qty='$qty' where idmasuk='$idm'");
        $query2 = mysqli_query($c,"update produk set stock='$newstock' where idproduk='$idp'");

        if($query1&&$query2){
            header('location:masuk.php');
        } else {
            echo'
            <script>alert("Gagal ubah data barang masuk!");
            window.location.href="masuk.php"
            </script>
            ';
        }
    } else {
        //kalau input lebih kecil dari qty sekarang
        //hitung selisih juga
        $selisih = $qtysekarang-$qty;
        $newstock = $stocksekarang-$selisih;

        $query1 = mysqli_query($c,"update masuk set qty='$qty' where idmasuk='$idm'");
        $query2 = mysqli_query($c,"update produk set stock='$newstock' where idproduk='$idp'");

        if($query1&&$query2){
            header('location:masuk.php');
        } else {
            echo'
            <script>alert("Gagal ubah data barang masuk!");
            window.location.href="masuk.php"
            </script>
            ';
        }
    }
}




//hapus data barang masuk
if(isset($_POST['hapusdatabarangmasuk'])){
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];

    //cari tau qty dulu
    $caritahu = mysqli_query($c,"select * from masuk where idmasuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tau stok sekarang
    $caristock = mysqli_query($c,"select * from produk where idproduk='$idp'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    //langsung hitung
    $newstock = $stocksekarang-$qtysekarang;

    $query1 = mysqli_query($c,"delete from masuk where idmasuk='$idm'");
    $query2 = mysqli_query($c,"update produk set stock='$newstock' where idproduk='$idp'");

    if($query1&&$query2){
        header('location:masuk.php');
    } else {
        echo'
        <script>alert("Gagal ubah data barang masuk!");
        window.location.href="masuk.php"
        </script>
        ';
    }

}



//hapus data pesanan
if(isset($_POST['hapusorder'])){
    $ido = $_POST['ido'];

    $cekdata = mysqli_query($c,"select * from detailpesanan dp where idpesanan='$ido'");

    while($oke=mysqli_fetch_array($cekdata)){
        //balikan stok
        $qty = $oke['qty'];
        $idproduk = $oke['idproduk'];
        $iddp = $oke['iddetailpesanan'];

        //cari tau stok sekarang
        $caristock = mysqli_query($c,"select * from produk where idproduk='$idproduk'");
        $caristock2 = mysqli_fetch_array($caristock);
        $stocksekarang = $caristock2['stock'];

        $newstock = $stocksekarang+$qty;

        $queryupdate = mysqli_query($c,"update produk set stock='$newstock' where idproduk='$idproduk'");

        
        //hapus data jangan lupa
        $querydelete = mysqli_query($c,"delete from detailpesanan where iddetailpesanan='$iddp'");

    }

    $query = mysqli_query($c,"delete from pesanan where idorder='$ido'");
    if($queryupdate && $querydelete && $query){
        header('location:index.php');
    } else {
        echo'
        <script>alert("Gagal hapus data!");
        window.location.href="index.php"
        </script>
        ';
    }
}



//mengubah detail pesanan
if(isset($_POST['editdetailpesanan'])){
    $qty = $_POST['qty'];
    $iddp = $_POST['iddp']; //ini idmasuk
    $idpr = $_POST['idpr']; //ini idproduk
    $idp = $_POST['idp']; //ini idpesanan / idorder

    //cari tau qty dulu
    $caritahu = mysqli_query($c,"select * from detailpesanan where iddetailpesanan='$iddp'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tau syok sekarang
    $caristock = mysqli_query($c,"select * from produk where idproduk='$idpr'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];


    if($qty >= $qtysekarang){
        //kalau input lebih besar dari qty sekarang
        //menghitung selisih
        $selisih = $qty-$qtysekarang;
        $newstock = $stocksekarang-$selisih;

        $query1 = mysqli_query($c,"update detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
        $query2 = mysqli_query($c,"update produk set stock='$newstock' where idproduk='$idpr'");

        if($query1&&$query2){
            header('location:view.php?idp='.$idp);
        } else {
            echo'
            <script>alert("Gagal ubah data !");
            window.location.href="view.php?idp='.$idp.'"
            </script>
            ';
        }
    } else {
        //kalau input lebih kecil dari qty sekarang
        //hitung selisih juga
        $selisih = $qtysekarang-$qty;
        $newstock = $stocksekarang+$selisih;

        $query1 = mysqli_query($c,"update detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
        $query2 = mysqli_query($c,"update produk set stock='$newstock' where idproduk='$idpr'");

        if($query1&&$query2){
            header('location:view.php?idp='.$idp);
        } else {
            echo'
            <script>alert("Gagal ubah data !");
            window.location.href="view.php?idp='.$idp.'"
            </script>
            ';
        }
    }
}



?>