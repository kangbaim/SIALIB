<?php
require_once "../config/db.php";
require_once "../config/fungsi_antiinjection.php";

$username = anti_injection($_POST['username']);
$password = anti_injection($_POST['password']);

    // perlu dibuat sebarang pengacak
    $pengacak  = "L1BR4rYUN!D490nToR102496B15M!LL4H";

    // mengenkripsi password dengan md5() dan pengacak
    $pass_enkripsi = md5($pengacak . md5($password) . $pengacak);

// menghindari sql injection
$injeksi_username = mysqli_real_escape_string($connect, $username);
$injeksi_password = mysqli_real_escape_string($connect, $pass_enkripsi);

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($injeksi_username) OR !ctype_alnum($injeksi_password)){
  echo "<script>window.alert('Sekarang loginnya tidak bisa di injeksi lho.');
        self.history.back();</script>";
}
else{
  $query  = "SELECT * FROM users WHERE username='$username' AND password='$pass_enkripsi'";
  $login  = mysqli_query($connect, $query);
  $ketemu = mysqli_num_rows($login);
  $r      = mysqli_fetch_array($login); 

  // Apabila username dan password ditemukan (benar)
  if ($ketemu > 0){
    session_start();
    //require_once "config/timeout.php";

    // bikin variabel session
    $_SESSION['namauser']    = $r['username'];
    $_SESSION['passuser']    = $r['password'];
    $_SESSION['namalengkap'] = $r['nama_lengkap'];
    $_SESSION['email']       = $r['email'];
    $_SESSION['leveluser']   = $r['level'];
      
    // session timeout
   // $_SESSION[login] = 1;
   // timer();
    // bikin id_session yang unik dan mengupdatenya agar slalu berubah 
    // agar user biasa sulit untuk mengganti password Administrator 
    $sid_lama = session_id();
	  session_regenerate_id();
    $sid_baru = session_id();
    mysqli_query($connect, "UPDATE users SET id_session='$sid_baru' WHERE username='$username'");
    
    //echo "masuk";
    header("location:media.php?module=dashboard");
  }
  else{
    echo "
    <script>window.alert('Login Gagal !! ..Username & Password salah..');
        self.history.back();</script>
    ";  
  }
}
?>
