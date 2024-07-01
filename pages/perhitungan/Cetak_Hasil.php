<?php  
	require_once __DIR__ . '/../../vendor/autoload.php';
	require '../../config/koneksi_db.php';

	function printData($query) {
	    global $koneksi;

	    $dataAlter = mysqli_query($koneksi, $query);
	    if (!$dataAlter) {
	        die("Query error: " . mysqli_error($koneksi));
	    }

	    $row = [];
	    while ($data = mysqli_fetch_assoc($dataAlter)) {
	        $row[] = $data;
	    }

	    return $row;
	} 

	$alternatif = printData("SELECT Nama_Menu FROM data_alternatif");
	$printNorm = printData("SELECT * FROM hasil_normalisasi");

	// Menggabungkan nama menu dengan data normalisasi berdasarkan indeks
	foreach ($printNorm as $index => $data) {
	    $printNorm[$index]['Nama_Menu'] = $alternatif[$index]['Nama_Menu'];
	}

	$printPrefQuery = "SELECT data_alternatif.Nama_Menu, hasil_preferensi.C1, hasil_preferensi.C2, hasil_preferensi.C3, hasil_preferensi.C4, hasil_preferensi.Total 
	FROM data_alternatif 
	INNER JOIN hasil_preferensi ON data_alternatif.ID_Alternatif = hasil_preferensi.ID_Pref 
	ORDER BY Total DESC";
	$hasilPref = printData($printPrefQuery);

	$mpdf = new \Mpdf\Mpdf();
	$headerTitle = '<div>
											<h1 style="font-size: 22px;"><i>Sistem Keputusan Pemilihan Menu Terlaris RM. Berdikari (SAW Method)</i></h1>
											<hr style="color: black; border: none; margin-top: -6px;">
									</div>';

	$waktu = '<p style="margin-top: -3px;"><i>'. date("D, j F Y") .'</i></p>';

	$header1 = '<div>
    		      <h2 style="font-size: 16px;">Hasil Normalisasi</h2>
    		   </div>';

   	$tabel1 = '<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: center; font-size: 13px; 
   	margin-top: -5px;">
              <thead>
                <tr class="text-center">
                  <th>Nama Menu</th>
                  <th>C1</th>
                  <th>C2</th>
                  <th>C3</th>
                  <th>C4</th>
                </tr>
              </thead>
              <tbody>';  
                  $no1 = 1;
                  foreach($printNorm as $data1) {
			      $tabel1 .= '<tr>
			                    <td>'. $data1['Nama_Menu'] .'</td>
			                    <td>'. $data1['C1'] .'</td>
			                    <td>'. $data1['C2'] .'</td>
			                    <td>'. $data1['C3'] .'</td>
			                    <td>'. $data1['C4'] .'</td>
			                 </tr>';
                    	$no1++; 
                  }
			     $tabel1 .= '</tbody>
			            	</table>'; 

	$header2 = '<div>
	              <h2 style="font-size: 16px; margin-top: 26px;">Hasil Preferensi</h2>
	           </div>';

	$tabel2 = '<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: center; font-size: 13px;
	margin-top: -5px;">
              <thead>
                <tr class="text-center">
                  <th>Urutan</th>
                  <th>Nama Menu</th>
                  <th>C1</th>
                  <th>C2</th>
                  <th>C3</th>
                  <th>C4</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody class="text-center"> '; 
                  $no2 = 1;  
                  foreach ($hasilPref as $data2) {
		          $tabel2 .= '<tr>
			                    <td>'. $no2 .'</td>
			                    <td>'. $data2['Nama_Menu'] .'</td>
			                    <td>'. $data2['C1'] .'</td>
			                    <td>'. $data2['C2'] .'</td>
			                    <td>'. $data2['C3'] .'</td>
			                    <td>'. $data2['C4'] .'</td>
			                    <td>'. $data2['Total'] .'</td>
			                  </tr>';
			             		$no2++;
			                  }
            	  $tabel2 .='</tbody>
            			 	</table>';

  function hasilTertinggi($query) {
	    global $koneksi;

	    $dataAlter = mysqli_query($koneksi, $query);
	    if (!$dataAlter) {
	        die("Query error: " . mysqli_error($koneksi));
	    }

	    $row = [];
	    while ($data = mysqli_fetch_row($dataAlter)) {
	        $row[] = $data;
	    }

	    return $row;
	}

	$nilai = hasilTertinggi("SELECT MAX(Total) AS Total FROM hasil_preferensi");
	$hasil = $nilai[0][0];

	$alter = hasilTertinggi($printPrefQuery);
	$hasilAlt = $alter[0][0];

  $kesimpulan = '<p style="margin-top: 23px; line-height: 22px; text-align: justify;"><i>Berdasarkan jumlah alternatif, nilai bobot 
  masing-masing kriteria serta penilaian yang ada, hasil dari pemilihan menu terlaris di RM. Berdikari dengan metode SAW ini untuk nilai tertinggi pada 
  hasil preferensi adalah <b>'.$hasil.'</b>. Jadi kesimpulannya menu paling terlaris dan direkomendasikan oleh RM. Berdikari ialah <b>'.$hasilAlt.'</b>.</i></p>';

    $mpdf->WriteHTML($headerTitle);
    $mpdf->WriteHTML($waktu);
    $mpdf->WriteHTML($header1);
	$mpdf->WriteHTML($tabel1);
    $mpdf->WriteHTML($header2);
	$mpdf->WriteHTML($tabel2);
	$mpdf->WriteHTML($kesimpulan);

	$mpdf->Output('SPK_Hasil_Keputusan.pdf', \Mpdf\Output\Destination::INLINE);

?>
