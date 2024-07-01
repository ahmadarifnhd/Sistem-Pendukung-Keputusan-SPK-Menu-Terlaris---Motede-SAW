<?php
include "koneksi.php"; // Pastikan file koneksi.php telah menyediakan $koneksi

if (isset($_GET['id'])) {
    $id_alternatif = $_GET['id'];

    // Hapus data dari tabel berdasarkan ID_Alternatif
    $delete_query = "DELETE FROM data_alternatif WHERE ID_Alternatif = $id_alternatif";
    mysqli_query($koneksi, $delete_query);

    // Setelah penghapusan, perbarui urutan ID_Alternatif agar berurutan
    // Lakukan query untuk mengurutkan ulang ID_Alternatif
    $update_query = "SET @num := 0;
                     UPDATE data_alternatif SET ID_Alternatif = @num := (@num+1);
                     ALTER TABLE data_alternatif AUTO_INCREMENT = 1;";
    mysqli_multi_query($koneksi, $update_query);

    echo "<script>
            alert('Data Alternatif Berhasil Terhapus');
            document.location.href = 'index.php?page=data_alternatif';
         </script>";
}
?>
