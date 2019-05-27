<!--- Panel --->
<?php

    global $db;

    $ogrenci_sec = $db->prepare("SELECT * FROM uyeler");
    $ogrenci_sec->execute();

    $sinif_sec = $db->prepare("SELECT * FROM siniflar");
    $sinif_sec->execute();
    
    $kategori_sec = $db->prepare("SELECT * FROM kategoriler");
    $kategori_sec->execute();
    
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="" style="margin:3px 0 0 0"><span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span>&nbsp;DERS TANIMLAMA FORMU</h4>
    </div>
    <div class="panel-body">
<?php

    if($_POST){

        $uye_id           = $_POST["uye_id"];
        $sinif_id         = $_POST["sinif_id"];
        $kategori_id      = $_POST["kategori_id"];
        $ders_id          = $_POST["ders_id"];
        $konu_id          = $_POST["konu_id"];
        
        $ekle = $db->prepare("INSERT INTO iliskiler SET
                                uye_id = :uye_id,
                                sinif_id = :sinif_id,
                                kategori_id = :kategori_id,
                                ders_id = :ders_id,
                                konu_id = :konu_id
                            ");
        
        $ekle->bindParam(":uye_id", $uye_id, PDO::PARAM_STR);
        $ekle->bindParam(":sinif_id", $sinif_id, PDO::PARAM_STR);
        $ekle->bindParam(":kategori_id", $kategori_id, PDO::PARAM_INT);
        $ekle->bindParam(":ders_id", $ders_id, PDO::PARAM_INT);
        $ekle->bindParam(":konu_id", $konu_id, PDO::PARAM_INT);
        $kaydet = $ekle->execute();
        
        if($kaydet){
            echo '<font color="green">Ders başarıyla tanımlandı, yönlendiriliyorsunuz!</font>';
            header("Refresh:2; url='index.php?git=uyeler'");
        }else{
            echo '<font color="red">Kaydetme başarısız oldu!</font>';
            header("Refresh:2; url='index.php?git=uye-ekle'");
        }
    
    }else{ ?>
    
        <!--- Form ---> 
        <form id="" action="" method="post">
            <div class="form-group">
            <label for="ogrenci_uye_id">Öğrenci</label>
                <select class="form-control" id="ogrenci_uye_id" name="uye_id">
                    <option value="0">Öğrenci Seçiniz</option>
                    <?php
                        while($ogrenci = $ogrenci_sec->fetch(PDO::FETCH_ASSOC)){
                            echo '<option value='.$ogrenci['uye_id'].'>'.$ogrenci['uye_adi']." ".$ogrenci['uye_soyadi'].'</option>';
                        } 
                    ?>
                </select>
            </div>
            
            <div class="form-group">
            <label for="uye_sinif_id">Üye Sınıfı</label>
                <select class="form-control" id="uye_sinif_id" name="sinif_id">
                    <option value="0">Sınıf Seçiniz</option>
                    <?php
                        while($sinif = $sinif_sec->fetch(PDO::FETCH_ASSOC)){
                            echo '<option value='.$sinif['sinif_id'].'>'.$sinif['sinif_adi'].'</option>';
                        } 
                    ?>
                </select>
            </div>
                
            <div class="form-group">
            <label for="uye_kategori_id">Üye Kategorisi</label>
                <select class="form-control" id="uye_kategori_id" name="kategori_id">
                    <option value="0">Kategori Seçiniz</option>
                    <?php
                        while($kategori = $kategori_sec->fetch(PDO::FETCH_ASSOC)){
                            echo '<option value='.$kategori['kategori_id'].'>'.$kategori['kategori_adi'].'</option>';
                        } 
                    ?>
                </select>
            </div>
            
            <div class="form-group">
            <label for="uye_ders_id">Üye Ders</label>
                <select class="form-control" id="uye_ders_id" name="ders_id">
                    
                </select>
            </div>

            <div class="form-group">
            <label for="uye_konu_id">Üye Ders Konusu</label>
                <select class="form-control" id="uye_konu_id" name="konu_id">
                    
                </select>
            </div>

        <button type="submit" class="btn btn-primary pull-right">Kaydet</button>
        </form>
        <!--- # Form # --->

<?php } ?>
    </div>
</div>
<!--- # Panel # --->
<script>

$('#uye_kategori_id').on('change',function(){
        var categoryID = $(this).val();
        if(categoryID){
            $.ajax({
                type:'POST',
                url:'ajax.php',
                data:'kategori_id='+categoryID,
                success:function(html){
                    $('#uye_ders_id').html(html);
                    $('#uye_konu_id').html('<option value="">Önce ders seçiniz</option>'); 
                }
            }); 
        }else{
            $('#uye_ders_id').html('<option value="">Önce kategori seçiniz</option>');
            $('#uye_konu_id').html('<option value="">Önce ders seçiniz</option>'); 
        }
    });
    
    $('#uye_ders_id').on('change',function(){
        var stateID = $(this).val();
        if(stateID){
            $.ajax({
                type:'POST',
                url:'ajax.php',
                data:'ders_id='+stateID,
                success:function(html){
                    $('#uye_konu_id').html(html);
                }
            }); 
        }else{
            $('#uye_konu_id').html('<option value="">Select state first</option>'); 
        }
    });


</script>
