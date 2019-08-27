<?php
	require 'dbconnection.php';

    if(isset($_POST['submit'])){//Giriş formu gönderilirse
        $adsoyad = $_POST["adsoyad"];
        $kullaniciad = $_POST["kullaniciad"];
        $sifre = $_POST["sifre"];
        $email = $_POST["email"];
        $sube = $_POST["sube"];

        $insert = "INSERT INTO kullanici (kullanici_adsoyad,kullanici_ad,kullanici_sifre,kullanici_email,kullanici_sube)
        VALUES ('$adsoyad','$kullaniciad','$sifre','$email','$sube')";
        
        if ($con->query($insert) === TRUE) {
            echo "New record successfully";
            header('Location:/login.php');
        } else {
            echo "Error: " . $insert . "<br>" . $con->error;
        }        
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
<body>

<?php include 'header.php'; ?>
  
    <div class="container">
        <div class="row mt-5 p-3  ">
            <div class="col md-4"></div>
            <div class="col md-4 m-5 border bg-white">
                <form action="" method="post" class="m-1">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Ad Soyad</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="adsoyad" value=" ">
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Kullanıcı Ad</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="kullaniciad" value=" ">
                    </div>            
                    <div class="form-group">
                        <label for="exampleInputPassword1">Şifre</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="sifre" value=" ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email Adresi</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value=" "> 
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
                    <input type="hidden" name="submit" value="1">
                    <a href="login.php"><small>Giriş Yap</small></a><br>
                    <button type="submit" class="btn btn-primary w-100">Kayıt Ol</button>&nbsp;
                </form>
            </div>
            <div class="col md-4"></div>
        </div>
        <!-- <?php require 'footer.html'; ?> -->
    </div>

    

    <script src="js/jquery-3.4.1.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>