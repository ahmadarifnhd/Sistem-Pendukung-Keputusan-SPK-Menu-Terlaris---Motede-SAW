<?php
  require_once 'proses_perhitungan.php';
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Perhitungan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php?beranda.php">Beranda</a></li>
          <li class="breadcrumb-item active">Perhitungan</li>
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
                <h3 class="card-title font-weight-bold mb-2">Tabel Matrix / Penilaian</h3>
              </div>
            </div>
            <div class="row">
              <div class="col">
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
                        </tr>
                      <?php  
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row text-right mt-3">
              <div class="col">
                <form method="post">
                  <button type="submit" class="btn btn-primary" name="hitung"><i class="far fa-hourglass"></i> Hitung</button>
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