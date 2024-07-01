<?php
// Menampilkan seluruh data
function tampilData($query) {
    global $koneksi;

    $dataAlter = mysqli_query($koneksi, $query);
    $row = [];
    while ($data = mysqli_fetch_assoc($dataAlter)) {
        $row[] = $data;
    }

    return $row;
}
$alternatif = tampilData("SELECT * FROM data_alternatif");
$kriteria = tampilData("SELECT * FROM data_kriteria");
$penilaian = tampilData("SELECT * FROM data_penilaian");

// Proses perhitungan
if (isset($_POST['hitung'])) {
    $sql1 = "SELECT COUNT(*) FROM data_penilaian";
    $dataPenilai = mysqli_query($koneksi, $sql1);
    $isiPenilai = mysqli_fetch_row($dataPenilai);

    $sql2 = "SELECT COUNT(*) FROM hasil_normalisasi";
    $dataNorm = mysqli_query($koneksi, $sql2);
    $isiNorm = mysqli_fetch_row($dataNorm);

    $sql3 = "SELECT COUNT(*) FROM hasil_preferensi";
    $dataPref = mysqli_query($koneksi, $sql3);
    $isiPref = mysqli_fetch_row($dataPref);

    if ($isiPenilai[0] == 0) {
        echo "<script>
                alert('Mohon Inputkan Data Terlebih Dahulu');
             </script>";
    } else if ($isiNorm[0] > 0 && $isiPref[0] > 0) {
        echo "<script>
                alert('Proses Hitung Telah Dilakukan');
             </script>";
    } else {
        // Fungsi menambil data dari DB    
        function Data($sql) {
            global $koneksi;

            $dataNilai = mysqli_query($koneksi, $sql);
            $baris = [];
            while ($hasil = mysqli_fetch_row($dataNilai)) {
                $baris[] = $hasil;
            }

            return $baris;
        }

        // Proses normalisasi
        $ambil = Data("SELECT * FROM data_penilaian");

        function normalisasi($dataPenilaian) {
            global $koneksi;
            $jumlahAlternatif = count($dataPenilaian);
            $jumlahKriteria = count($dataPenilaian[0]) - 2;

            $hasil = [];

            for ($i = 0; $i < $jumlahKriteria; $i++) {
                $kolom = array_column($dataPenilaian, $i + 2);
                $nilaiTerbesar = max($kolom);

                for ($j = 0; $j < $jumlahAlternatif; $j++) {
                    $hasil[$j][$i] = number_format($dataPenilaian[$j][$i + 2] / $nilaiTerbesar, 3);
                }
            }

            foreach ($hasil as $index => $row) {
                $query = "INSERT INTO hasil_normalisasi VALUES ('', '" . implode("', '", $row) . "')";
                mysqli_query($koneksi, $query);
            }

            return mysqli_affected_rows($koneksi);
        }

        normalisasi($ambil);

        // Proses preferensi
        $bobot = Data("SELECT * FROM data_kriteria");

        // Data / nilai bobot
        $bobotC1 = $bobot[0][1];
        $bobotC2 = $bobot[0][2];
        $bobotC3 = $bobot[0][3];
        $bobotC4 = $bobot[0][4];

        function preferensi($hasilNorm, $bobotC1, $bobotC2, $bobotC3, $bobotC4) {
            global $koneksi;

            foreach ($hasilNorm as $row) {
                $prefR1 = $bobotC1 * $row[1];
                $prefR2 = $bobotC2 * $row[2];
                $prefR3 = $bobotC3 * $row[3];
                $prefR4 = $bobotC4 * $row[4];

                // Memformat panjang nominal angka jumlah hasil  
                $pre1 = number_format($prefR1, 3);
                $pre2 = number_format($prefR2, 3);
                $pre3 = number_format($prefR3, 3);
                $pre4 = number_format($prefR4, 3);

                $totalPref = $pre1 + $pre2 + $pre3 + $pre4;

                // Memformat panjang nominal jumlah angka total hasil  
                $hasilTotal = number_format($totalPref, 3);

                $query = "INSERT INTO hasil_preferensi VALUES ('', '$pre1', '$pre2', '$pre3', '$pre4', '$hasilTotal')";
                mysqli_query($koneksi, $query);
            }

            return mysqli_affected_rows($koneksi);
        }

        $hasilNorm = Data("SELECT * FROM hasil_normalisasi");

        preferensi($hasilNorm, $bobotC1, $bobotC2, $bobotC3, $bobotC4);

        echo "<script>
                  document.location.href = 'index.php?page=hasil_normalisasi';
             </script>";
    }
}

$hasilNormalisasi = tampilData("SELECT * FROM hasil_normalisasi");

$sqlHasilpref = "SELECT
  data_alternatif.Nama_Menu,
  hasil_preferensi.C1,
  hasil_preferensi.C2,
  hasil_preferensi.C3,
  hasil_preferensi.C4,
  hasil_preferensi.Total
FROM data_alternatif
INNER JOIN hasil_preferensi
ON data_alternatif.ID_Alternatif = hasil_preferensi.ID_Pref
ORDER BY Total DESC;
";
$hasilPreferensi = tampilData($sqlHasilpref);

if (isset($_POST['reset'])) {
    $sqlNorm = "SELECT COUNT(*) FROM hasil_normalisasi";
    $dataNorm = mysqli_query($koneksi, $sqlNorm);
    $isiNorm = mysqli_fetch_row($dataNorm);

    $sqlPref = "SELECT COUNT(*) FROM hasil_preferensi";
    $dataPref = mysqli_query($koneksi, $sqlPref);
    $isiPref = mysqli_fetch_row($dataPref);

    if ($isiNorm[0] == 0 && $isiPref[0] == 0) {
        echo "<script>
                alert('Tidak Bisa Mereset, Karena Tidak Ada Data Satupun');
             </script>";
    } else {
        $resetNorm = "TRUNCATE TABLE hasil_normalisasi";
        $resetPref = "TRUNCATE TABLE hasil_preferensi";

        mysqli_query($koneksi, $resetNorm);
        mysqli_query($koneksi, $resetPref);

        echo "<script>
                alert('Reset Berhasil');
                document.location.href = 'index.php';
             </script>";
    }
}
?>