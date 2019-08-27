<?php
    require 'dbconnection.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer\src\PHPMailer.php';
    require 'PHPMailer\src\Exception.php';
    require 'PHPMailer\src\SMTP.php';

	if(@$_GET['act'] == 'stokkod_sorgula'){//Stok Kodu textine yazılınca stok adı getiren yer.
		$stokkod = $_GET['stokkod_sorgusu'];
		$sql = "SELECT stok_ad from stok WHERE stok_kod = '$stokkod'";
		$result=$con->query($sql);		
		if($result->num_rows>0)		
		    if($row=$result->fetch_assoc())			
			    echo $row['stok_ad'];		
    }
	else if(@$_GET['act'] == 'stokad_sorgula'){//Stok Adı textine yazılınca stok kodu getiren yer.
		$stokad = $_GET['stokad_sorgusu'];
		$sql = "SELECT stok_kod from stok WHERE stok_ad = \"$stokad\"";
		$result=$con->query($sql);		
		if($result->num_rows>0)		
			if($row=$result->fetch_assoc())			
				echo $row['stok_kod'];		
    }
    else if(@$_GET['act'] == 'carikod_sorgula'){//Cari Kod textine yazılınca cari ad getiren yer.
        $carikod = $_GET['carikod_sorgusu'];
        $sql = "SELECT cari_ad from cari WHERE cari_kod = '$carikod'";
        $result=$con->query($sql);
        if($result->num_rows>0)        
            if($row=$result->fetch_assoc())
                echo $row['cari_ad'];        
    }
    else if(@$_GET['act'] == 'cariad_sorgula'){//Cari Ad textine yazılınca cari kod getiren yer.
        $cariad = $_GET['cariad_sorgusu'];
        $sql = "SELECT cari_kod from cari WHERE cari_ad = \"$cariad\"";
        $result=$con->query($sql);
        if($result->num_rows>0)        
            if($row=$result->fetch_assoc())
                echo $row['cari_kod'];        
    }
    if(@$_POST['mail']){
        require_once('tcpdf/tcpdf.php');
        // // PDF HEADER
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        
        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Biget Stok Siparis", "Deneme deneme deneme\ndeneme", array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // 

        $pdf->SetFont('dejavusans', '', 10);
        $pdf->AddPage();
        // $pdf->write(5,"Cari Kod:".$_POST['carikod']."                          Tarih:".$_POST['tarih']."\nCari Ad:".$_POST['cariad']."             Şube:".$_POST['sube']."\nEvrak No:".$_POST['evrakno']."\n\n\n\n");
        $pdf->write(5,"Cari Kod:".$_POST['carikod']."\nTarih:".$_POST['tarih']."\nCari Ad:".$_POST['cariad']."\nŞube:".$_POST['sube']."\nEvrak No:".$_POST['evrakno']."\n\n\n\n");
        $html = $_POST['datatablehtml'];
        $html = str_replace('<img src="image/deleteicon.png" class="btn_deleterow" onclick="deleterow(this)">',"",$html);
        $html = str_replace(substr($html,strpos($html,"<button"),87),"",$html);//datatable son hazır hali
        $pdf->writeHTML($html, true, false, true, false, '');

         $pdfdoc = $pdf->Output('','S');
         $mail = new PHPMailer(true);
         try{            
             $mail->isSMTP();
             $mail->SMTKeepAlive = true;
             $mail->SMTPAuth = true;
             $mail->SMTPSecure = 'ssl';
             $mail->Port = 465;
             $mail->Host = "smtp.gmail.com";
             $mail->Username = "";//User informations for who is sending this mail
             $mail->Password = "";
             $mail->setFrom("Gmail_Address","Name");//From this email address
             $mail->addAddress("Gmail_Address","Name");//To this email address
             $mail->isHTML(true);
             $mail->Subject = "";//Subject
             $mail->Body = "";//Message Content
		 	$mail->addStringAttachment($pdfdoc, 'my-doc.pdf');
             $mail->send();
             echo true;
         }catch(phpmailerException $e){
             echo $e->errorMessage();
         }catch(Exception $e){
             echo $e->getMessage();
         }
    }
?>