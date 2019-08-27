<?php
    require 'dbconnection.php';
    session_start();
    if(isset($_SESSION['kullanici_adi'])){
        $k_ad = $_SESSION['kullanici_adi'];
        $select = "SELECT * FROM kullanici where kullanici_ad = '$k_ad'";
        $result = $con->query($select);
        if($result->num_rows > 0)
            if($row = $result->fetch_assoc()){
                $k_sube = $row['kullanici_sube'];        
                $k_tur = $row['kullanici_tur'];
            }
    }
    else
        header("Location:/login.php");        

    $k_ad = $_SESSION['kullanici_adi'];
    if(isset($_POST['sifredegissubmit'])){        
        $mevcutsifre = $_POST['mevcutsifre'];
        $yenisifre = $_POST['yenisifre'];
        $yenisifretekrar = $_POST['yenisifretekrar'];
        if($mevcutsifre == "" || $yenisifre == "" || $yenisifretekrar == "")
            echo "alanları doldur";
        else{
            $select = "SELECT kullanici_sifre FROM kullanici where kullanici_ad = '$k_ad'";
            $result = $con->query($select);
            if($result->num_rows > 0)
                if($row = $result->fetch_assoc())
                    if($row["kullanici_sifre"] == $mevcutsifre && $yenisifre == $yenisifretekrar){
                        $update = "UPDATE kullanici SET kullanici_sifre = '$yenisifre' WHERE kullanici_ad = '$k_ad'";
                        if(($con->query($update) === TRUE)) echo "başarıylad değiştrildi";
                    }
                    else
                        echo "mevcut şifreniz veya şifre tekrarınız hatalı";
        }
    }
    if(isset($_POST['maildegissubmit'])){//Cari Modal'ı submit edilmişse
        $yeniemail = $_POST['yeniemail'];
        if($yeniemail != ""){
            $update = "UPDATE kullanici SET kullanici_email = '$yeniemail' WHERE kullanici_ad = '$k_ad'";
            if(($con->query($update) === TRUE)) echo "başarıylad değiştrildi";
        }
        else
            echo "alanları doldurunuz";
    }
    if(isset($_POST['kayitetsubmit'])){//Giriş formu gönderilirse
        $adsoyad = $_POST["adsoyad"];
        $kullaniciad = $_POST["kullaniciad"];
        $sifre = $_POST["sifre"];
        $email = $_POST["email"];
        @$sube = $_POST["sube"];
        if(@$_POST["adminmi"]) $adminmi = 1; else $adminmi = 0;
        if($adsoyad != "" && $kullaniciad != "" && $sifre != "" && $email != "" && $sube != ""){
            $insert = "INSERT INTO kullanici (kullanici_adsoyad,kullanici_ad,kullanici_sifre,kullanici_email,kullanici_sube,kullanici_tur)
            VALUES ('$adsoyad','$kullaniciad','$sifre','$email','$sube','$adminmi')";
            
            if ($con->query($insert) === TRUE) {
                echo "New record successfully";
            } else
                echo "Error: " . $insert . "<br>" . $con->error;
        }
        else
            echo "alanları doldur";  
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type='text/css' href="css/bootstrap.css">
    <link rel='icon' href='image/restaurant.ico' type='image/x-icon'/>
    <link rel='stylesheet' type='text/css' href='css/style.css'>
    <title>BIGET STEAK & Co | Web'den Gir</title>
</head>
<style>
li a:hover{
    background:#d6d6c2 !important;
    color:#fff !important;
}
</style>
<body>

<?php include 'header.php'; ?>


    <div class="row mt-5 p-3">          

        <div class="col md-1"></div>
        <div class="col md-10 bg-white">               
            <ul class="nav nav-tabs">
                <a class="nav-link active" href="index.php"><img src="image/backicon.png" class="w-50"></a>             
                <li class="nav-item">
                    <a class="nav-link active" href="#" onclick="openCity('sifredegis')">Şifre Değiştir</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#" onclick="openCity('maildegis')">Mail Değiştir</a>
                </li>         
                <?php 
                    if($k_tur == 1) echo '<li class="nav-item">
                    <a class="nav-link active" href="#" onclick="openCity(\'kayitolustur\')">Kullanıcı Oluştur</a>
                </li> ';                
                ?>
            </ul>    
            <div id="sifredegis" class="w3-container city">
                    <form action="" method="post" class="m-1">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mevcut Şifre</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="mevcutsifre">
                        </div>  
                        <div class="form-group">
                            <label for="exampleInputPassword1">Yeni Şifre</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="yenisifre">
                        </div>  
                        <div class="form-group">
                            <label for="exampleInputPassword1">Yeni Şifre Tekrar</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="yenisifretekrar">
                        </div>                    
                        <input type="hidden" name="sifredegissubmit" value="1">
                        <button type="submit" class="btn btn-primary w-100">Değiştir</button>&nbsp;
                    </form>
            </div>
            <div id="maildegis" class="w3-container city" style="display:none"> 
                    <form action="" method="post" class="m-1">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Yeni mail adresi</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="yeniemail"> 
                        </div>
                        <input type="hidden" name="maildegissubmit" value="1">
                        <button type="submit" class="btn btn-primary w-100">Değiştir</button>&nbsp;
                    </form>
            </div>


            <div id="kayitolustur" class="w3-container city" style="display:none"> 
            <form action="" method="post" class="m-1">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Ad Soyad</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="adsoyad">
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Kullanıcı Ad</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="kullaniciad">
                    </div>            
                    <div class="form-group">
                        <label for="exampleInputPassword1">Şifre</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="sifre">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email Adresi</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email"> 
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Şube Seçimi</label>
                        <select multiple class="form-control" id="exampleFormControlSelect2" name="sube">
                        <?php 
                            $select = "SELECT depo_ad FROM sube";
                            $result = $con->query($select);
                            if($result->num_rows>0){
                                while($row = $result->fetch_assoc()){
                                    echo "<option>$row[depo_ad]</option>";
                                }
                            }
                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="adminmi">
                        <label class="form-check-label" for="gridCheck">Admin</label>
                        </div>
                    </div>
                    <input type="hidden" name="kayitetsubmit" value="1">
                    <button type="submit" class="btn btn-primary w-100">Kayıt Oluştur</button>&nbsp;
                </form>
                </div>
        </div>
        <div class="col md-1"></div>
    </div>
    <!-- <?php require 'footer.html'; ?> -->
 

<script src="js/jquery-3.4.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>
function openCity(fieldname) {
var i;
var x = document.getElementsByClassName("city");
for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
}
document.getElementById(fieldname).style.display = "block";  
}
</script>
</body>
</html>