<?php
	require 'dbconnection.php';

    if(isset($_POST['submit'])){//Giriş formu gönderilirse
        $email = $_POST['email'];
        $sifre = $_POST['sifre'];
        $select = "SELECT * FROM kullanici where kullanici_email = '$email'";
        $result = $con->query($select);
        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()){
                if($row["kullanici_sifre"] == $sifre){//Email bulunduktan sonra şifre kontrolü
                    $_SESSION['kullanici_adi'] = $row["kullanici_ad"];
                    header('Location:/webdengir');
                }
                else echo "Yanlış şifre girdiniz!";//Şifreler uyuşmuyorsa
            }
        }
        else//Veri tabanında girilen emaile sahip bir kullanıcı bulunmazsa
            echo "Bu email adresine sahip kullanıcı bulunamadı!";
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
        <div class="row mt-5">
            <div class="col md-4"></div>
            <div class="col md-4 m-5 border bg-white">
                <form action="" method="post" class="m-1">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email adresi</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email"> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Şifre</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="sifre">
                    </div>
                    <input type="hidden" name="submit" value="1">
                    <button type="submit" class="btn btn-primary w-100 mt-1">Giriş Yap</button>&nbsp;
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