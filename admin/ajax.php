<?php 

require("../sistem/ayar.php");

if(!empty($_POST["kategori_id"])){
$kategori_id = $_POST['kategori_id']; 
$dersler = $db->query("SELECT * FROM dersler WHERE ders_kategori_id = '{$kategori_id}'");
$rowCount = $dersler->rowCount();

if($rowCount > 0){
        echo '<option value="">Ders Seçiniz</option>';
        while($row = $dersler->fetch(PDO::FETCH_ASSOC)){ 
            echo '<option value="'.$row['ders_id'].'">'.$row['ders_adi'].'</option>';
        }
}else{
        echo '<option value="">Bu kategoriye ders tanımlı değil</option>';
       
        }
}elseif(!empty($_POST["ders_id"])){
    $konular = $db->query("SELECT * FROM konular WHERE konu_ders_id = ".$_POST['ders_id']." AND konu_durum = 1 ORDER BY konu_adi ASC");
    $rowCount = $konular->rowCount();
    
    if($rowCount > 0){
        echo '<option value="">Konu Seçiniz</option>';
        while($row = $konular->fetch(PDO::FETCH_ASSOC)){ 
            echo '<option value="'.$row['konu_id'].'">'.$row['konu_adi'].'</option>';
        }
    }else{
        echo '<option value="">Bu derse ait konu girilmemiş</option>';
    }
}

 ?>
