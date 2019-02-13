<?php
    require_once('../inc/userClass.php');
	require_once('../inc/secIP.php');

	session_start();

	use PHPMailer\PHPMailer\PHPMailer;
    require_once ('../php/mailer/src/PHPMailer.php');
    require_once ('../php/mailer/src/SMTP.php');

	$ipset = new secIP();
	//$realip = "https://".$ipset->getLocal().":".$ipset->getPort().$ipset->getFile();
	$realip = $ipset->getLocal().$ipset->getFile();

	
	if(isset($_SESSION['loggedin']))
    {
    	if($_SESSION['loggedin'] == 1)
        {
			if(isset($_SESSION['user']))
			{
				header("Refresh: 0; url=".$realip."/");
			}else
			{
				session_destroy();
				header("Refresh: 3; url=".$realip."/login/login.php");
				return;
			}
        }
    }else
    {
		if(isset($_POST['reg']))
		{
			$uname = $_POST['email'];
			$pass = $_POST['password'];
			$ad = $_POST['ad'];
			$soyad = $_POST['soyad'];
			if(empty ($uname) || empty($pass) || empty($ad) || empty($soyad))
			{
				echo 'You can not register with empty fields';
				header("Refresh: 3; url=".$realip."/login/login.php?register=true");
			}
			else
			{

                $newuser = user::userCreator();

                $u_adress = $ipset->findUserIp();

                $uname = $newuser->security($uname, "mail");



                //Set The Hash For Security
                $info=''.$_SERVER['HTTP_USER_AGENT'].''.$u_adress.''.date('d-m-Y').''.$uname;
                $hash = hash("sha256",$info);



                $mailer = new PHPMailer;
                $mailer->IsSMTP();
                $mailer->CharSet = 'UTF-8';

                $mailer->Host       = "smtp.".substr($realip, 8); // SMTP server example
                $mailer->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                $mailer->SMTPAuth   = true;                  // enable SMTP authentication
                //$mailer->SMTPSecure = "tls";
                $mailer->Port       = 587;                    // set the SMTP port for the GMAIL server
                $mailer->Username   = "noreply@".substr($realip, 8); // SMTP account username example
                $mailer->Password   = "21211986Muffin";


                //E Mail Set

                //ini_set('sendmail_from', "noreply@optimumilac.com");

                $to      = $uname; // Send email to our user
                $subject = 'Kayit Olma | Onay'; // Give the email a subject
                $message = '
 
                Kayıt olup bizi tercih ettiginiz icin tesekkür ederiz.
                Hesabiniz olusturuldu, asagidaki linke tiklayarak hesabinizi aktif edebilir firsatlardan faydalanmaya baslayabilirsiniz.
                 

                Hesabinizi aktiflestirmek icin lütfen asagidaki linke tiklayin:
                '.$realip.'/verificate.php?mail='.$uname.'&act='.$hash.'
                 
                '; // Our message above including the link

                $headers = 'From:noreply@'.substr($realip, 8) . "\r\n"; // Set from headers


                //$mailer->setLanguage("tr");

                $mailer->From = 'noreply@'.substr($realip, 8);
                $mailer->FromName = "No-Reply | ".substr($realip, 8);
                $mailer->Subject = $subject;

                $mailer->Body = $message;

                $mailer->addAddress($to, "");


                $result = $newuser->registerNewUser($ad, $soyad, $hash, $u_adress, $uname, $pass);
                if($result == true)
                {

                    if (!$mailer->send()) {
                        print_r(error_get_last());

                    }else
                        {

                            echo 'Kayıt Başarılı, Hesabınızı Aktive Etmeniz İçin Gerekli Aktivasyon Linki E-Posta Adresinize Gönderildi.';
                            //header("Refresh: 1; url=".$realip."/index.php");
                        }

                }else
                {
                    echo ' Şuan da Kayıt Yapılamamakta.';
                    header("Refresh: 3; url=".$realip."/login/index.php?register=false");
                }
					
			}
		}
		if(isset($_POST['login']))
		{
			if(isset($_POST['username']) && isset($_POST['password']))
			{
				
				
				$user = user::userCreator();
				//create cookie username -> username
				setcookie("username",$_POST["username"],time() +(30*60*60*24));//30 days
				$user->createUser($_POST['username'], $_POST['password']);
				
				
				if($user->isLogged())
				{
					
					$_SESSION['user'] = base64_encode(serialize($user));
					$_SESSION['loggedin'] = $user->statue;
					
					
					$user->setSecurity();
					 
                    header("Refresh: 0; url=".$realip."/index.php");
					
				}else
				{
					echo 'Username or Password Wrong!';
					header("Refresh: 2;");
				}
				
			}
		}

        if(isset($_GET['register']))
        {
            if($_GET['register'] == "true")
            {
                echo "Hesabınız Başarılı Bir Şekilde Aktive Edildi. Giriş Yapabilirsiniz.";
            }
            if($_GET['register'] == "false")
            {
                echo "Hesabınız Aktive Edilemedi veya Kayıt Yapılamadı. Lütfen Bir süre Sonra Tekrar Deneyin.";
            }
        }
	
?>
<!DOCTYPE HTML>
<html>
<head>
<title>OPTİMİUM ilac Login</title>
<!-- Meta-Tags -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Custom Theme files -->
<link href="css/popup-box.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome-icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome-icons -->

<!--fonts--> 
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
<!--//fonts--> 
</head>
<body>
<div class="agileinfo-dot">
<!--background-->
<!-- login -->
<h1></h1>
	<div class="login-section">
	    <div class="login-w3l">
		
		<h2 class="sub-head-w3-agileits">Giriş Yap</h2>	
			<div class="login-form">			
				<form action="#" method="post">
					<div class="input">
						<i class="fa fa-user" aria-hidden="true"></i> <input type="text" class="user" name="username" 
							placeholder="<?php echo  (isset($_COOKIE["username"])) ? htmlspecialchars($_COOKIE["username"]) : 'Kullanıcı Adı' ;?>" required="" />
					</div>
					<div class="input">
						<i class="fa fa-unlock-alt" aria-hidden="true"></i> <input type="password" class="lock" name="password" placeholder="Şifre" required="" />
					</div>
					<div class="signin-rit">
						<span class="checkbox1">
							<label class="checkbox"><input type="checkbox" name="checkbox" checked="">Beni hatırla</label>
						</span>
						<!--<a class="forgot" href="#">Şifremi Unuttum??</a>-->
						<div class="clear"> </div>
					</div>
					<input type="submit" name="login" value="Giriş Yap">
				</form>	
				<p>Hesabınız yok mu ?<a class="book popup-with-zoom-anim button-isi zoomIn animated" data-wow-delay=".5s" href="#small-dialog"> Üye Ol</a></p>
			</div>
			<!-- //login -->
			
		</div> 
		<div class="profile-agileits bg-color-agile">
			<h3></h3>
			</h4>
		</div> 
		<div class="clear"></div>
	</div>	
			<p class="footer">  <a href=""></a></p>
			<!--//login-->
			<div class="pop-up"> 
	<div id="small-dialog" class="mfp-hide book-form">
		<h3 class="sub-head-w3-agileits">Kayıt Ol</h3>	
		<div class="login-form">			
			<form action="#" method="post">
				<div class="input">
					<i class="fa fa-user" aria-hidden="true"></i> <input type="text" class="user" name="ad" placeholder="Adınız" required="" />
				</div>
				<div class="input">
					<i class="fa fa-user" aria-hidden="true"></i> <input type="text" class="user" name="soyad" placeholder="Soy Adınız" required="" />
				</div>
				<div class="input">
					<i class="fa fa-envelope" aria-hidden="true"></i> <input type="email" name="email" class="email" placeholder="Email" required=""/>
				</div>
				<div class="input">
					<i class="fa fa-unlock-alt" aria-hidden="true"></i> <input type="password" name="password" class="password" placeholder="Şifre" required=""/>
				</div>
				<div class="input">
					<i class="fa fa-unlock-alt" aria-hidden="true"></i> <input type="password" name="password" class="password" placeholder="Şifre Tekrar" required=""/>
				</div>				
				<input type="submit" name="reg" value="Kayıt Ol">
			</form>
		</div>
	</div>
</div>	
</div>

<!--js-->
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<!--//js-->
<!--popup-js-->
<script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
 <script>
						$(document).ready(function() {
						$('.popup-with-zoom-anim').magnificPopup({
							type: 'inline',
							fixedContentPos: false,
							fixedBgPos: true,
							overflowY: 'auto',
							closeBtnInside: true,
							preloader: false,
							midClick: true,
							removalDelay: 300,
							mainClass: 'my-mfp-zoom-in'
						});
																						
						});
</script>
<!--//popup-js-->

</body>
</html>

	<?php } ?>