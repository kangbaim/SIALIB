<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo  "<script>window.alert('Untuk mengakses modul, Anda harus login dulu.');
        window.location = 'index.php'</script>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session

else{
  include "../config/db.php";


  // Home (Beranda)
  if ($_GET['module']=='dashboard'){               
    if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='user'){
      include "modules/beranda/beranda.php";
    }  
  }

  // Keuangan
  elseif ($_GET['module']=='keuangan'){
    if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='user'){
      include "modules/keuangan/keuangan.php";
    }
  }

  // Print Laporan
  elseif ($_GET['module']=='print'){
    if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='user'){
      include "modules/keuangan/print_data.php";
    }
  }

  // Manajemen User
  elseif ($_GET['module']=='user'){
    if ($_SESSION['leveluser']=='admin'){
      include "modules/user/user.php";
    }
  }

    // iedntitas
  elseif ($_GET['module']=='identitas'){
    if ($_SESSION['leveluser']=='admin'){
      include "modules/identitas/identitas.php";
    }
  }



  // Apabila modul tidak ditemukan
  else{
    echo "<p>Modul tidak ada.</p>";
  }
}
?>
