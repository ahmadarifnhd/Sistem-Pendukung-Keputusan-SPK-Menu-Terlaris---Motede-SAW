<?php  
	// menampilkan data yang dipilih
	$query = "SELECT * FROM data_alternatif WHERE ID_Alternatif = $_GET[id]";
	$data = mysqli_query($koneksi, $query);
	$hasil = mysqli_fetch_assoc($data);

	// mengubah / edit data
	if (isset($_POST['edit'])) {
    $idAlter        = $_GET['id']; 
    $namaAlternatif = htmlspecialchars($_POST['alternatif']);
    $jenisMenu = htmlspecialchars($_POST['jenis']);

    $query = "UPDATE data_alternatif SET Nama_Menu = '$namaAlternatif', 
		Jenis_Menu = '$jenisMenu' WHERE ID_Alternatif = '$idAlter'";

    mysqli_query($koneksi, $query);

    echo "<script>
            alert('Data Alternatif Berhasil Diupdate');
            document.location.href = 'index.php?page=data_alternatif';
         </script>";
	}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Alternatif</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php?page=data_alternatif">Alternatif</a></li>
          <li class="breadcrumb-item active">Edit Alternatif</li>
        </ol>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Edit Data Alternatif</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <form role="form" method="post">
		      <div class="form-group" hidden="hidden">
		        <label>ID Alternatif</label>
		        <input class="form-control" style="width: 100%;" name="alternatif" value="<?= $hasil['ID_Alternatif'];?>" disabled></input>
		      </div>
		      <div class="form-group">
		        <label>Nama Alternatif</label>
		        <input class="form-control" style="width: 100%;" name="alternatif" value="<?= $hasil['Nama_Menu'];?>"></input>
		      </div>
		      <div class="form-group">
            <label>Jenis Menu</label>
            <select class="form-control select2" style="width: 100%;" name="jenis" required>
              <option value="Makanan" <?= $hasil['Jenis_Menu'] == 'Makanan' ? 'selected' : '' ?>>Makanan</option>
              <option value="Minuman" <?= $hasil['Jenis_Menu'] == 'Minuman' ? 'selected' : '' ?>>Minuman</option>
            </select>
          </div>
          <div class="d-flex justify-content-between">
          	<a href="index.php?page=data_alternatif">
          	  <button type="button" class="btn btn-primary">Kembali</button>
          	</a>
            <button type="submit" class="btn btn-primary" name="edit"><i class="far fa-edit"></i> Edit</button>
          </div>
        </form>
        <!-- /.row -->
      </div>
      <!-- /.card-body -->
    </div>
  </div>
  <!-- /.container-fluid -->
</section>