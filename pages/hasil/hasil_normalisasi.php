<?php
  require 'pages/perhitungan/proses_perhitungan.php';
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Hasil Normalisasi</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php?beranda.php">Beranda</a></li>
          <li class="breadcrumb-item active">Hasil Normalisasi</li>
        </ol>
      </div>
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
            <div class="row">
              <div class="col">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr class="text-center">
                        <th class="text-nowrap">Kriteria</th>
                        <?php foreach ($alternatif as $alt) { ?>
                          <th class="text-nowrap"><?= $alt['Nama_Menu'] ?></th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <?php
                      $kriteria = ['C1', 'C2', 'C3', 'C4'];
                      foreach ($kriteria as $index => $kri) {
                        echo "<tr>";
                        echo "<td class='font-weight-bold text-nowrap'>{$kri}</td>";
                        foreach ($hasilNormalisasi as $data) {
                          echo "<td>{$data[$kri]}</td>";
                        }
                        echo "</tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row text-right mt-3">
              <div class="col">
                <form method="post" class="d-flex justify-content-end">
                  <div class="opsi-2">
                    <button type="submit" class="btn btn-primary" name="reset" onclick="return confirm('Yakin ingin reset ulang? Semua data serta hasil akan terhapus semua');"><i class="fas fa-redo"></i> Reset Ulang</button>
                  </div>
                </form>
              </div>
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
