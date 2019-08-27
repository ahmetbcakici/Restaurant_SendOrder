<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><img src="image/bgtkck.png" alt="image_error"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mr-5" id="navbarColor01">
      <ul class="navbar-nav ml-auto">
    <?php 
      if(isset($_SESSION['kullanici_adi'])){//Kullanıcı girişi yapılmışsa navbar'a ayarlar için dropdown yerleştirilsin.
        echo '<li class="nav-item active ">          
          <div class="dropdown text-white">
            <div class="nav-item active dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            '.$_SESSION["kullanici_adi"].'
            </div>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="kullaniciayar.php">Kullanıcı Ayarları</a>
              <a class="dropdown-item" href="cikis.php">Çıkış Yap</a>
            </div>
          </div>
        </li>';
      }
    ?>
      </ul>
    </div>
    

        <!-- <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li> -->

  </nav>