<?php
 // Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<script>window.alert('Untuk mengakses modul, Anda harus login dulu.');
        window.location = 'index.php'</script>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modules/keuangan/aksi.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : '';

  switch($act){
    // Tampil User
    default:

    // Query Total saldo //
    $total = "SELECT ROUND ( SUM(IF(status = 'Pemasukan', jumlah, 0))-(SUM(IF( status = 'Pengeluaran',
    		 jumlah, 0))) ) AS subtotal FROM keuangan";
    $view  = mysqli_query($connect, $total);
    $r     = mysqli_fetch_array($view);
    $idr   = $r['subtotal'];
    $for   = number_format($idr,0,",",".");
    //---------------------------------------
				  
?>  
    <section class="content-header">
      <h1>
        Data Keuangan
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data Keuangan</li>
      </ol>
    </section>

    <section class="content">
    	<!-- SISA SALDO -->
	    <div class="box box-danger">
	    	<div class="box-body bg-red">
	    		<center>
    				<h4>
    					<strong>SISA SALDO SAAT INI</strong><br>
    					<small style="color: white;">Pemasukan - Pengeluaran</small>
    				</h4>
    				<h1>
    					<b>Rp. <?php echo $for; ?></b>
    				</h1>
	    		</center>
	    	</div>
      	</div>
		<div class="box-body">
          	<?php 
	            if (isset($_SESSION['namauser'])): 
		        ?>
	            <a href="?module=keuangan&act=tambah" style="margin-bottom: 10px;" class="btn btn-md btn-warning "> <i class="fa fa-plus"></i> Tambah Data</a>
	            <a href="modules/keuangan/print_data.php" style="margin-bottom: 10px;" class="btn btn-md btn-primary "> <i class="fa fa-print" target="blank"></i> Print</a>
          	<?php endif; ?>

          	<div class="nav-tabs-custom ">
		        <ul class="nav nav-tabs pull-right">
		          	<li class="active"><a href="#tab_1" data-toggle="tab"><b>Pemasukan</b></a></li>
		          	<li><a href="#tab_2" data-toggle="tab"><b>Pengeluaran</b></a></li>
		        </ul>
		        <div class="tab-content">
		        	<!-- Pemasukan -->
			        <div class="tab-pane active" id="tab_1">
			        	<?php
			        		$query  = "SELECT * FROM keuangan WHERE status = 'Pemasukan' ORDER BY id_keuangan";
   							$masuk = mysqli_query($connect, $query);
			        	?>
			        	<div class="table-responsive">
				            <table class="table table-bordered table-hover" id="example1">
				              <thead>
				                <tr>
				                  <th>NO</th>
				                  <th>STATUS</th>
				                  <th>TANGGAL</th>
				                  <th>JENIS</th>
				                  <th>KETERANGAN</th>
				                  <th>JUMLAH</th> 
				                  <th>AKSI</th>
				                </tr>
				              </thead>
				              <tbody>
				                <?php
				                $no = 1;
				                while ($r=mysqli_fetch_array($masuk)){
				                ?>
				                <tr>
				                  <td><?php echo $no; ?></td>
				                  <td><?php echo $r['status']?></td>          
				                  <td><?php echo $r['tgl']?></td>
				                  <td><?php echo $r['jenis']?></td>
				                  <td><?php echo $r['keterangan']?></td>
				                  <td>Rp. <?php echo $r['jumlah']?></td>
				                  <td>
				                    <a class="btn btn-success" href="?module=keuangan&act=edit&id=<?php echo $r['id_keuangan']; ?>"><i class="fa fa-edit"></i></a>
				                    <a class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" <?php echo "href=\"$aksi?module=keuangan&act=delete&id=$r[id_keuangan]\""; ?>><i class="fa fa-trash"></i></a>
				                  </td>
				                </tr>
				                <?php
				                  $no++;
				                }
				                ?>
				              </tbody>
				            </table>
			            </div>
			        </div>
		          	<!-- Pengeluaran -->
		          	<div class="tab-pane" id="tab_2">
		          		<?php
			        		$query  = "SELECT * FROM keuangan WHERE status = 'Pengeluaran' ORDER BY id_keuangan";
   							$keluar = mysqli_query($connect, $query);
			        	?>
		          		<div class="table-responsive">
				            <table class="table table-bordered table-hover" id="example11">
				              <thead>
				                <tr>
				                  <th>NO</th>
				                  <th>STATUS</th>
				                  <th>TANGGAL</th>
				                  <th>JENIS</th>
				                  <th>KETERANGAN</th>
				                  <th>JUMLAH</th> 
				                  <th>AKSI</th>
				                </tr>
				              </thead>
				              <tbody>
				                <?php
				                $no = 1;
				                while ($r=mysqli_fetch_array($keluar)){
				                ?>
				                <tr>
				                  <td><?php echo $no; ?></td>
				                  <td><?php echo $r['status']?></td>          
				                  <td><?php echo $r['tgl']?></td>
				                  <td><?php echo $r['jenis']?></td>
				                  <td><?php echo $r['keterangan']?></td>
				                  <td>Rp. <?php echo $r['jumlah']?></td>
				                  <td>
				                    <a class="btn btn-success" href="?module=keuangan&act=edit&id=<?php echo $r['id_keuangan']; ?>"><i class="fa fa-edit"></i></a>
				                    <a class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" <?php echo "href=\"$aksi?module=keuangan&act=delete&id=$r[id_keuangan]\""; ?>><i class="fa fa-trash"></i></a>
				                  </td>
				                </tr>
				                <?php
				                  $no++;
				                }
				                ?>
				              </tbody>
				            </table>
			            </div>
		          	</div>
		        </div>
		        <!-- /.tab-content -->
        	</div>
        </div>
      <!-- nav-tabs-custom -->
    </section>

    <?php
      break;
    ?>

    <!-- Tambah keuangan -->
    <?php
    case "tambah":
      if ($_SESSION['leveluser']=='admin'){
      ?>
        <section class="content-header">
          	<h1>
	            Tambah Data
	            <small>advanced tables</small>
          	</h1>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	            <li><a href="#">Tables</a></li>
	            <li class="active">Data Keuangan</li>
	        </ol>
        </section>
        <section class="content">
            <div class="row">
	            <div class="col-md-12">
	                <!-- general form elements disabled -->
	                <div class="box box-danger col-lg-12">
	                    <div class="box-body">
		                    <form role="form" method="post" enctype="multipart/form-data" <?php echo "action=\"$aksi?module=keuangan&act=input\""; ?>>
		                    	<input type="hidden" name="username" value="<?php echo $_SESSION['namauser']; ?>">
			                    <div class="form-group">
			                        <label>Status</label>
			                        <select class='form-control' name='status' >
			                            <option value=''>-- Please select --</option>
			                            <option value='Pemasukan'>Pemasukan</option>
			                            <option value='pengeluaran'>Pengeluaran</option>
			                        </select>
		                        </div>
			                    <div class="form-group">
			                        <label>Jenis</label>
			                        <select class='form-control' name='jenis' >
			                            <option value=''>-- Please select --</option>
			                            <option value='Denda'>Denda</option>
			                            <option value='Fotocopy'>Fotocopy</option>
			                            <option value='Kartu'>Kartu</option>
			                            <option value='Jurnal'>Jurnal</option>
			                            <option value='Buku'>Buku</option>
			                        </select>
			                    </div>
		                        <div class="form-group">
		                            <label>Tanggal</label>
		                            <div class="input-group date">
		                              <div class="input-group-addon">
		                                <i class="fa fa-calendar"></i>
		                              </div>
		                              <input type="text" class="form-control pull-right" id="datepicker" name="tgl">
			                        </div>
	                            </div>
			                    <div class="form-group">
			                        <label>Keterangan</label>
			                        <input type="text" class="form-control" name="ktr" value=""/>
			                    </div>
		                        <div class="form-group">
		                      		<label>Jumlah</label>
			                      	<div class="input-group">
				                        <span class="input-group-addon">Rp.</span>
				                		<input type="number" class="form-control" name="jumlah">
			                        </div>
			                    </div>

			                    <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Simpan</button>
			                    <button type="reset" class="btn btn-warning"> <i class="fa fa-trash"></i> Reset</button>
			                    <button type="button" class="btn btn-danger" onclick="self.history.back()"><i class="fa fa-times"></i> Batal</button>
		                    </form>
	                    </div>
	                    <!-- /.box-body -->
	                </div
	                ><!-- /.box -->
	            </div>
	            <!--/.col (right) -->
            </div>
        </section>
      <?php
      }
      else{
        echo "Anda tidak berhak mengakses halaman ini.";
      }
    break;
    ?>

    <!-- Edit keuangan -->
    <?php
    case "edit":
      
      $query = "SELECT * FROM keuangan WHERE id_keuangan='$_GET[id]'";
      $hasil = mysqli_query($connect, $query);
      $r     = mysqli_fetch_array($hasil);
     
      if ($_SESSION['leveluser']=='admin'){
    ?> 
        <section class="content-header">
          <h1>
            Edit Data
            <small>advanced tables</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Tables</a></li>
            <li class="active">Data Keuangann</li>
          </ol>
        </section>
        <section class="content">
            <div class="row">
	            <div class="col-md-12">
	                <!-- general form elements disabled -->
	                <div class="box box-danger col-lg-12">
	                    <div class="box-body">
		                    <form role="form" method="post" enctype="multipart/form-data" <?php echo "action=\"$aksi?module=keuangan&act=update\""; ?>>
		                    	<input type="hidden" name="id" value="<?php echo $r['id_keuangan']; ?>">
		                    	<input type="hidden" name="username" value="<?php echo $_SESSION['namauser']; ?>">
			                    <div class="form-group">
			                        <label>Status</label>
			                        <input type="text" class="form-control" name="status" value="<?php echo $r['status']; ?>" readonly="readonly"/>
		                        </div>
			                    <div class="form-group">
			                        <label>Jenis</label>
			                        <input type="text" class="form-control" name="jenis" value="<?php echo $r['jenis']; ?>" readonly="readonly"/>
			                    </div>
			                    <div class="form-group">
		                            <label>Tanggal</label>
		                            <div class="input-group date">
		                              <div class="input-group-addon">
		                                <i class="fa fa-calendar"></i>
		                              </div>
		                              <input type="text" class="form-control pull-right" id="datepicker" name="tgl" value="<?php echo $r['tgl']; ?>">
			                        </div>
	                            </div>
			                    <div class="form-group">
			                        <label>Keterangan</label>
			                        <input type="text" class="form-control" name="ktr" value="<?php echo $r['keterangan']; ?>"/>
			                    </div>
		                        <div class="form-group">
		                      		<label>Jumlah</label>
			                      	<div class="input-group">
				                        <span class="input-group-addon">Rp</span>
				                		<input type="number" class="form-control" name="jumlah" value="<?php echo $r['jumlah']; ?>">
			                        </div>
			                    </div>

			                    <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Update</button>
			                    <button type="reset" class="btn btn-warning"> <i class="fa fa-trash"></i> Reset</button>
			                    <button type="button" class="btn btn-danger" onclick="self.history.back()"><i class="fa fa-times"></i> Batal</button>
		                    </form>
	                    </div>
	                    <!-- /.box-body -->
	                </div
	                ><!-- /.box -->
	            </div>
	            <!--/.col (right) -->
            </div>
        </section>
    <?php
      }
      else{
        echo "Anda tidak berhak mengakses halaman ini.";
      }
    break;
  }
}
?>  
  