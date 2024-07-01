<?php
include "koneksi.php"; // Pastikan file koneksi.php telah menyediakan $koneksi

if (isset($_GET['id'])) {
    $id_penilaian = $_GET['id'];

    // Hapus data dari tabel berdasarkan ID_Penilaian
    $delete_query = "DELETE FROM data_penilaian WHERE ID_Penilaian = $id_penilaian";
    mysqli_query($koneksi, $delete_query);

    // Setelah penghapusan, perbarui urutan ID_Penilaian agar berurutan
    // Lakukan query untuk mengurutkan ulang ID_Penilaian
    $update_query = "SET @num := 0;
                     UPDATE data_penilaian SET ID_Penilaian = @num := (@num+1);
                     ALTER TABLE data_penilaian AUTO_INCREMENT = 1;";
    mysqli_multi_query($koneksi, $update_query);

    echo "<script>
            alert('Nilai Berhasil Terhapus');
            document.location.href = 'index.php?page=data_penilaian';
         </script>";
}
?>
