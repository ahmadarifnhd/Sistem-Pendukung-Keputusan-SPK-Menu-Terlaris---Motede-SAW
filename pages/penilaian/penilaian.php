<?php  
  // menampilkan seluruh data 
  function tampilData($query) {
    global $koneksi;

    $dataAlter = mysqli_query($koneksi, $query);
    $row = [];
    while ($data = mysqli_fetch_assoc($dataAlter)) {
      $row [] = $data;
    }

    return $row;
  } 
  $alternatif = tampilData("SELECT * FROM data_alternatif");
  $penilaian  = tampilData("SELECT * FROM data_penilaian"); 

  // menyimpan data yang diinput
  if (isset($_POST['simpan'])) {
    global $koneksi;

    $sql = "SELECT COUNT(*) FROM data_penilaian";
    $data = mysqli_query($koneksi, $sql);
    $isi = mysqli_fetch_row($data);

    if ($isi[0] == 10) {
      echo "<script>
              alert('Penilaian Hanya Bisa Input Maks 10 Data');
           </script>";
    } else if ($isi[0] !== 10) {
      $alternatif = htmlspecialchars($_POST['alternatif']);
      $nilai_c1 = htmlspecialchars($_POST['nilai_c1']);
      $nilai_c2 = htmlspecialchars($_POST['nilai_c2']);
      $nilai_c3 = htmlspecialchars($_POST['nilai_c3']); 
      $nilai_c4 = htmlspecialchars($_POST['nilai_c4']);

      // Mengambil ID terbesar dan menambah 1 untuk membuat ID baru
      $maxIdResult = mysqli_query($koneksi, "SELECT MAX(ID_Penilaian) as max_id FROM data_penilaian");
      $maxIdRow = mysqli_fetch_assoc($maxIdResult);
      $newId = $maxIdRow['max_id'] + 1;

      // Memasukkan data baru ke dalam database
      $query = "INSERT INTO data_penilaian (ID_Penilaian, Alternatif, Harga, Penjualan, Rasa, Feedback) 
                VALUES ('$newId', '$alternatif', '$nilai_c1', '$nilai_c2', '$nilai_c3', '$nilai_c4')";
      mysqli_query($koneksi, $query);

      echo "<script>
              alert('Data Penilaian Berhasil Disimpan');
              document.location.href = 'index.php?page=data_penilaian';
           </script>";
      }
    }    

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Penilaian</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php?beranda.php">Beranda</a></li>
          <li class="breadcrumb-item active">Penilaian</li>
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
        <h3 class="card-title">Silahkan Masukan Penilaian</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <form role="form" method="post">
          <div class="row mb-3">
            <div class="col-md-6">
              <h5 class="font-weight-bold">Kriteria</h5>
            </div>
            <div class="col-md-6">
              <h5 class="font-weight-bold">Penilaian</h5>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">   
              <label>Alternatif</label>
            </div>
            <div class="col-md-6">
              <select class="form-control select2" style="width: 100%;" name="alternatif">
                <option selected="selected" disabled>-- Pilih Alternatif --</option>
                <?php
                  foreach ($alternatif as $items) {
                ?>
                <option value="<?= $items['Nama_Menu']; ?>"><?= $items['Nama_Menu']; ?></option>
                <?php  
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">   
              <label>(C1) Harga</label>
            </div>
            <div class="col-md-6">
              <input class="form-control select2" style="width: 100%;" placeholder="Nilai" name="nilai_c1" required></input>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label>(C2) Penjualan</label>
            </div>
            <div class="col-md-6">
              <input class="form-control select2" style="width: 100%;" placeholder="Nilai" name="nilai_c2" required></input>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label>(C3) Rasa</label>
            </div>
            <div class="col-md-6">
              <input class="form-control select2" style="width: 100%;" placeholder="Nilai" name="nilai_c3" required></input>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label>(C4) Feedback</label>
            </div>
            <div class="col-md-6">
              <input class="form-control select2" style="width: 100%;" placeholder="Nilai" name="nilai_c4" required></input>
            </div>
          </div>
          <div class="simpan text-right">
            <button type="submit" class="btn btn-primary" name="simpan"><i class="far fa-save"></i> Simpan</button>
          </div>
        </form>
        <!-- /.row -->
      </div>
      <!-- /.card-body -->
    </div>
  </div>
  <!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr class="text-center">
                    <th class="text-nowrap">Kode</th>
                    <th class="text-nowrap">Alternatif</th>
                    <th class="text-nowrap">C1</th>
                    <th class="text-nowrap">C2</th>
                    <th class="text-nowrap">C3</th>
                    <th class="text-nowrap">C4</th>
                    <th class="text-nowrap">Opsi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php  
                    $no = 1;
                    foreach ($penilaian as $items) {
                  ?>
                    <tr>
                      <td class="text-center text-nowrap"><?= 'A'. $no++; ?></td>
                      <td class="text-center text-nowrap"><?= $items['Alternatif']; ?></td>
                      <td class="text-center text-nowrap"><?= $items['Harga']; ?></td>
                      <td class="text-center text-nowrap"><?= $items['Penjualan']; ?></td>
                      <td class="text-center text-nowrap"><?= $items['Rasa']; ?></td>
                      <td class="text-center text-nowrap"><?= $items['Feedback']; ?></td>
                      <td class="text-nowrap">
                        <center>
                          <a href="index.php?page=edit_penilaian&id=<?= $items['ID_Penilaian']; ?>">
                            <button type="button" class="btn btn-primary"><i class="far fa-edit"></i> Edit</button>
                          </a>
                          <a href="index.php?page=delete_penilaian&id=<?= $items['ID_Penilaian']; ?>">
                            <button type="button" class="btn btn-primary" onclick="return confirm('Hapus Penilaian Kriteria?');"><i class="far fa-trash-alt"></i> Delete</button>
                          </a>
                        </center>
                      </td>
                    </tr>
                  <?php  
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->