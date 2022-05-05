<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
    }
	/* Connect To Database*/
	include("../config/db.php");
	include("../config/conexion.php");
	$id_factura= intval($_GET['id_factura']);
	$email = $_GET['email'];

	$sql_count=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('Factura no encontrada')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
	$sql_factura=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
	$rw_factura=mysqli_fetch_array($sql_factura);
	$numero_factura=$rw_factura['numero_factura'];
	$id_cliente=$rw_factura['id_cliente'];
	$id_vendedor=$rw_factura['id_vendedor'];
	$fecha_factura=$rw_factura['fecha_factura'];
	$condiciones=$rw_factura['condiciones'];
	require_once("../pdf/html2pdf.class.php"); //dirname(__FILE__).

    // get the HTML
     ob_start();
    //require_once('../pdf/res/ver_factura_html.php');
    include(dirname(__FILE__).'/res/ver_factura_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        //$html2pdf->Output('Factura.pdf','D');
        $carpeta = '/pdf';
        
        if(!file_exists($carpeta)){
        	mkdir($carpeta,0777,true);
        }

        $html2pdf->Output('/pdf/Factura.pdf', 'F');
        $content_pdf = '/pdf/Factura.pdf';
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    require '../PHPMailer/PHPMailerAutoload.php';

	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	//Set who the message is to be sent from
	$mail->setFrom(EMAILFROM, NOMBRE_EMAIL);
	//Set an alternative reply-to address
	//$mail->addReplyTo('replyto@example.com', 'First Last');
	//Set who the message is to be sent to
	$mail->addAddress($email, '');
	//Set the subject line
	$mail->Subject = 'Factura Celumobil';
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail->msgHTML(file_get_contents('content.html'), dirname(__FILE__));
	//Replace the plain text body with one created manually
	$mail->AltBody = 'Guarda tu factura';
	//Attach an image file
	$mail->addAttachment($content_pdf);

	//send the message, check for errors
	if (!$mail->send()) {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	    echo '
	    <style>
		    @media(min-width: 1200px){
		    	.container{
		    		with: 1170px;
		    	}
		    }

		    @media(min-width: 992px){
		    	.container{
		    		with: 970px;
		    	}
		    }

		    @media(min-width: 768px){
		    	.container{
		    		with: 750px;
		    	}
		    }

		    .container{
		    	padding-rigth:15px;
		    	padding-left:15px;
		    	margin-right:auto;
		    	margin-left:auto;
		    }

		    .btn-primary:hover{
		    	color:#fff;
		    	background-color:#286090;
		    	border-color:#204d74;
		    }

		    .btn.focus, btn:focus, .btn:hover{
		    	color: #333;
		    	text-decoration:none;
		    }
		    button, html[type:button], [type:reset],
		    [type=submit]{
		    	color:#fff;
		    	background-color:#337ab7;
		    	border-color:#2e6da4;
		    }

		    .btn{
		    	display:inline-block;
		    	padding:6px 12px;
		    	margin-botton:6px;
		    	font-size:14px;
		    	font-weight:400;
		    	line-height:1.42857143;
		    	tex-align: center;
		    	white-space:nowrap;
		    	vertical-align:middle;
		    	touch-action:manipulation;
		    	cursor:pointer;
		    	user-select:none;
		    	background-image:none;
		    	border:1px solid transparent;
		    	border-radius:4px;
		    }

		    .btn-primary{
		    	color:#fff;
		    	background-color:#337ab7;
		    	border-color:#2e6da4;
				width: 100%;
		    }
		    h1{
		    	text-align: center;
		    }
	    </style>
	    <div class="container">
	    	<div class="centrado">
			    <h1>Mensaje Enviado</h1>
			    <button type="button" onclick="cerrar()" class="btn btn-primary">Aceptar</button>
		    </div>
	    </div>
	    <script>
	     	function cerrar(){
	     		window.close()
	     	}
	    </script>
	    ';
	}
