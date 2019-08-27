<!DOCTYPE html>
<html lang="tr">
<head>    
    <?php        
        require 'dbconnection.php';
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
            header("Location:webdengir/login.php");
        
        if(isset($_POST['submitcari'])){//Cari Modal'ı submit edilmişse
            $carikod = $_POST['carikod'];
            $cariunvan = $_POST['cariunvan'];
            $select = "SELECT * FROM cari WHERE cari_kod = '$carikod'";
            $result = $con->query($select);
            if($result->num_rows>0)
                echo "bu koda sahip cari mevcut!";
            else{
                $insert = "INSERT INTO cari (cari_kod,cari_ad) values ('$carikod','$cariunvan')";
                if(($con->query($insert) === TRUE)) echo "başarılı";
            }
        }
        if(isset($_POST['submitstok'])){//Stok Modal'ı submit edilmişse            
            $stokkod = $_POST['stokkod'];
            $stokad = $_POST['stokad'];
            $select = "SELECT * FROM stok WHERE stok_kod = '$stokkod'";
            $result = $con->query($select);
            if($result->num_rows>0)
                echo "bu koda sahip stok mevcut!";
            else{
                $insert = "INSERT INTO stok (stok_kod,stok_ad) values ('$stokkod','$stokad')";
                if(($con->query($insert) === TRUE)) echo "başarılı";
            }
        }
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type='text/css' href="css/bootstrap.css">
    <link rel='stylesheet' type='text/css' href='css/style.css'>
    <link rel='icon' href='image/restaurant.ico' type='image/x-icon'/>
    <title>BIGET STEAK & Co | Web'den Gir</title>
</head>

<body>
    <?php include 'header.php';?>

    <div id="container">
        <header id="header">
            <h1>Sipariş Giriş Formu</h1>
        </header><br>
        <article id="main">
            <table id="maintable">
                <col style="width:110px;background:#9c9696;">
                <col style="width:469px;">
                <col style="width:100px;background:#9c9696;">
                <tr>
                    <th>Şube</th>
                    <td>
                    <?php
                        $select="SELECT depo_ad FROM sube WHERE depo_ad != '$k_sube'";
                        $result=$con->query($select);
                        if($result->num_rows > 0){
                            echo'<select style="width:153px;" id="subesec">';
                            echo "<option>".$k_sube."</option>";
                            while($row = $result->fetch_assoc()){                                
                                if($k_tur != 1) echo "<option value='$row[depo_ad]' disabled>$row[depo_ad]</option>";
                                else echo "<option value='$row[depo_ad]'>$row[depo_ad]</option>";
                            }
                                
                            echo"</select>";
                        }
                        else
                            echo "Veri bulunamadı!";
                    ?>                        
                    </td>
                    <th>Tarih</th>
                    <td>
                        <input style="width:125px;" type="date" id="tarih">
                    </td>
                </tr>
                <tr>
                    <th>Cari Kodu</th>
                    <td><input type='text' id="carikod" style="width:150px;" autocomplete="off" onkeypress='validate(event)'/></td>
                    <th>Evrak No</th>
                    <td>
                        <input style="width:125px;" type="text" id="evrakno">
                    </td>
                </tr>
                <tr>
                <th>Cari Unvanı&nbsp;&nbsp;<a data-target="#cariekleModal" data-toggle="modal" class="MainNavText" id="cariekle" href="#myModal" title="Yeni bir cari oluşturmak için tıklayınız."><img src = "image/addicon.png" style="width:23%;"></a></th>
                    <td>                        
                        <input type='text' id="cariad" style="width:100%;" list="cari_ad"/>
                        <datalist id="cari_ad">
                            <?php
                                $commandtext = "SELECT cari_ad from cari order by cari_ad";
                                $result = $con->query($commandtext);
                                if($result->num_rows>0)
                                    while($row=$result->fetch_assoc())
                                        echo '<option value="'.$row['cari_ad'].'">';
                            ?>
                        </datalist>
                    </td> 
                    <p id="kullanici" hidden><?php echo $_SESSION['kullanici_adi']; ?></p>
                </tr>
            </table>    
            <table class="enterdatatable">
                <col style="width:175px;"> 
                <col style="width:0px;">  
                <col style="width:75px;"> 
                <col style="width:100px;"> 
                <tr style="background:#9c9696;">
                    <th>Stok Kodu</th>
                    <th>Stok Adı&nbsp;&nbsp;<a data-target="#stokekleModal" data-toggle="modal" class="MainNavText" id="stokekle" href="#myModal" title="Yeni bir stok oluşturmak için tıklayınız."><img src = "image/addicon.png" style="width:5%;"></a></th>
                    <th>Birim</th>
                    <th>Miktar</th>
                </tr>
                <tr>
                    <td><input type='text' id="stokkod" autocomplete="off" onkeypress='validate(event)'/></td>
                    <td>
                        <input type='text' id="stokad" autocomplete="off" style="width:100%;" list="stok_ad"/>
                        <datalist id="stok_ad">
                            <?php
                                $commandtext = "SELECT stok_ad from stok order by stok_ad";
                                $result = $con->query($commandtext);
                                if($result->num_rows>0){
                                    while($row=$result->fetch_assoc()){
                                        echo '<option value="'.$row['stok_ad'].'">';
                                    }
                                }
                            ?>
                        </datalist>
                    </td>
                    <td>
                        <select id='birim'>
                            <option value="kg">KG</option>
                            <option value="lt">LT</option>
                            <option value="adet">Adet</option>
                            <option hidden></option>
                        </select>
                    </td>
                    <td><input type='number' id='miktar' min="0" step="1" placeholder="0"/></td>
                </tr>
                <tr style="background:white;">
                    <td colspan="4"><button id="sendrow">Ekle</button></td>
                </tr>
            </table>

            <table id="datatable">
                <tr id="headersrow" style="background:#dddddd;"><td>Stok Kodu</td><td>Stok Adı</td><td>Birim</td><td>Miktar</td></tr>
                <tr id="sendmailbutton">
                    <td colspan="6">
                        <button id="mailgonder" style="font-size:20px;">Merkeze Gönder</button>
                    </td>
                </tr>
            </table>
        </article>
        <?php include 'footer.html'; ?>
    </div>


        <!-- Cari Ekleme Modalı -->
        <div class="modal fade" id="cariekleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cari Kayıt</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">                        
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Cari Kod:</label>
                                <input type="text" class="form-control w-25" id="recipient-name" name="carikod">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Cari Unvan:</label>
                                <input type="text" class="form-control" id="recipient-name" name="cariunvan">
                            </div>                        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                            <input type="hidden" name="submitcari" value="1">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  

        <!-- Stok Ekleme Modalı -->
        <div class="modal fade" id="stokekleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Stok Kayıt</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">                        
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Stok Kod:</label>
                                <input type="text" class="form-control w-25" id="recipient-name" name="stokkod">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Stok Ad:</label>
                                <input type="text" class="form-control" id="recipient-name" name="stokad">
                            </div>                        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                            <input type="hidden" name="submitstok" value="1">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>           
        
    <script src="js/jquery-3.4.1.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src='js/justnumber.js'></script>
</body>
<script>
var table = document.getElementById("datatable"),rIndex;
anliktarih();
function deleterow(element){
    table=element.parentElement.parentElement.parentElement;
    satir=element.parentElement.parentElement;
    table.removeChild(satir);
}
function clearinputs(){
	document.getElementById('stokkod').value = '';
	document.getElementById('stokad').value = '';
    document.getElementById("birim").selectedIndex = "0";
    document.getElementById('miktar').value = 0;
}
function anliktarih(){
  var d = new Date();
  var day = d.getDate();
  var month = d.getMonth() + 1;
  var year = d.getFullYear();
  if (month < 10) month = "0" + month;
  if (day < 10) day = "0" + day;
  var today = year + "-" + month + "-" + day;
  $("input#tarih").attr("value", today);
}
$(document).ready(function(){
    $("#headersrow").css("visibility","hidden");
    $("#sendmailbutton").css("visibility","hidden");
    $("table#datatable tbody").click(function(e){        
        var table = document.getElementById("datatable");
        var rows = table.getElementsByTagName("tr");
        for (i = 0; i < rows.length; i++) {
            var currentRow = table.rows[i];        
            var createClickHandler = 
                function(row) 
                {
                    return function(){
                        try{
                        var cell0 = row.getElementsByTagName("td")[0];
                        var cell1 = row.getElementsByTagName("td")[1];
                        var cell2 = row.getElementsByTagName("td")[2];
                        var cell3 = row.getElementsByTagName("td")[3];
                        document.getElementById('stokkod').value = cell0.innerHTML;
                        document.getElementById('stokad').value = cell1.innerHTML;
                        //document.getElementById('birim').options[document.getElementById('birim').selectedIndex].text = cell2.innerHTML;
                        document.getElementById('miktar').value = cell3.innerHTML;
                        }
                        catch(err){//merkeze gönder butonuna basılmıssa
                            data = {
                                mail:"null",
                                datatablehtml:table.outerHTML,
                                sube:document.getElementById("subesec").options[document.getElementById("subesec").selectedIndex].value,
                                carikod:document.getElementById("carikod").value,
                                cariad:document.getElementById("cariad").value,
                                tarih:document.getElementById("tarih").value,
                                evrakno:document.getElementById("evrakno").value

                            }
                            $.post("code.php",data, function(res){
                                if(res[res.length-1] == 1){
                                    alert("Merkez birimine mail başarıyla gönderildi!");
                                    location.reload();
                                }
                                else
                                    alert("Mail gönderilemedi!\nHata mesajı :"+res);                                
                            }); 
                            clearinputs();
                        }
                    };
                };
            currentRow.onclick = createClickHandler(currentRow);
        }
    });
    $("#sendrow").click(function(){
        var stokkodu = document.getElementById('stokkod').value;
        var stokadi = document.getElementById('stokad').value;
        var birim = document.getElementById('birim').options[document.getElementById('birim').selectedIndex].text;
        var miktar = document.getElementById('miktar').value;
        var duplicated = false;
        var row = table.insertRow(1);
        var rows = $('#datatable tbody >tr');
        var columns;        
        if(stokkodu == "" || stokadi == "" || !(miktar > 0))
            alert("Alanları doldurunuz!");
        else{
            for (var i = 0; i < rows.length; i++) {
                columns = $(rows[i]).find('td');
                for (var j = 0; j < 1; j++) {
                    if($(columns[j]).html() == stokkodu){
                        duplicated = true;
                        rows[i].cells[0].innerHTML = stokkodu;
                        rows[i].cells[1].innerHTML = stokadi;
                        rows[i].cells[2].innerHTML = birim;
                        rows[i].cells[3].innerHTML = miktar;
                        rows[i].cells[4].innerHTML = "<img src='image/deleteicon.png' class='btn_deleterow' onclick='deleterow(this)'>";
                        break;
                    }
                }
            }
            if(!duplicated){
                row = table.insertRow(1);
                row.insertCell(0).innerHTML = stokkodu;
                row.insertCell(1).innerHTML = stokadi;
                row.insertCell(2).innerHTML = birim;
                row.insertCell(3).innerHTML = miktar;
                row.insertCell(4).innerHTML = "<img src='image/deleteicon.png' class='btn_deleterow' onclick='deleterow(this)'>";            
            }
            duplicated = false;
            $("#headersrow").css("visibility","visible");
            $("#sendmailbutton").css("visibility","visible");            
            $("#mailgonder").css("width",document.getElementById('datatable').offsetWidth);    
            clearinputs();
        }
    });
    $('#stokkod').keyup(function()	
	{
		var say = $(this).val().length;        
		var stokkod_nesnesi = $('#stokkod').val();
		if(say > 9){
			$.ajax(
			{
				url: "code.php?act=stokkod_sorgula",
				data: "stokkod_sorgusu="+stokkod_nesnesi,
				cache: false,
				success: function(msg)
				{
                	$("#stokad").val(msg);
				}
			});
		}
	});		
	$('#stokad').keyup(function()
	{
		var stokad_nesnesi = $("#stokad").val();
		$.ajax(
		{
			url: "code.php?act=stokad_sorgula",
			data: "stokad_sorgusu="+stokad_nesnesi,
			cache: false,
			success: function(msg)
			{					
				$("#stokkod").val(msg);
			}
		});
	});
    $('#carikod').keyup(function()	
	{
		var say = $(this).val().length;        
		var carikod_nesnesi = $('#carikod').val();
		if(say > 9){
			$.ajax(
			{
				url: "code.php?act=carikod_sorgula",
				data: "carikod_sorgusu="+carikod_nesnesi,
				cache: false,
				success: function(msg)
				{
                	$("#cariad").val(msg);
				}
			});
		}
	});
    $('#cariad').keyup(function()	
	{      
		var cariad_nesnesi = $('#cariad').val();
		$.ajax(
		{
			url: "code.php?act=cariad_sorgula",
			data: "cariad_sorgusu="+cariad_nesnesi,
			cache: false,
			success: function(msg)
			{
               	$("#carikod").val(msg);
			}
		});
		
	});	
});
</script>
</html>