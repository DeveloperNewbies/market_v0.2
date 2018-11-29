



<?php
	include('../inc/userClass.php');
	require_once('../inc/secIP.php');
	session_start();
	
	$ipset = new secIP();
	$realip = "".$ipset->getLocal().":".$ipset->getPort();
	
	if(isset($_SESSION['loggedin']))
    {
    	if($_SESSION['loggedin'] == 1)
        {
			if(isset($_SESSION['user']))
			{
				header("Refresh: 0; url=http://".$realip."/");
			}else
			{
				session_destroy();
				header("Refresh: 3; url=http://".$realip."/login/login.php");
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
			if(empty ($uname) || empty($pass))
			{
				echo 'You can not register with empty fields';
				header("Refresh: 3; url=http://".$realip."/login/login.php?register=true");
			}
			else
			{
				$newuser = user::userCreator();
				$result = $newuser->registerNewUser($ad, $soyad, $uname, $pass);
				if($result)
				{
					$newuser->createUser($uname, $pass);
					if($newuser->isLogged())
					{
						$_SESSION['user'] = base64_encode(serialize($newuser));
						$_SESSION['loggedin'] = $newuser->statue;
						
						
						$newuser->setSecurity();
						header("Refresh: 5; url=http://".$realip."/index.php");
					}
					else
					{
						echo 'Cant logged in after register.';
						header("Refresh: 3; url=http://".$realip."/login/login.php");
					}
				}else
				{
					echo 'Cant registered at moment.';
					header("Refresh: 3; url=http://".$realip."/login/login.php?register=false");
				}
					
			}
		}
		if(isset($_POST['login']))
		{
			if(isset($_POST['username']) && isset($_POST['password']))
			{
				
				
				$user = user::userCreator();
				$user->createUser($_POST['username'], $_POST['password']);
				
				
				if($user->isLogged())
				{
					
					$_SESSION['user'] = base64_encode(serialize($user));
					$_SESSION['loggedin'] = $user->statue;
					
					
					$user->setSecurity();
					header("Refresh: 2; url=http://".$realip."/index.php");
				}else
				{
					echo 'Username or Password Wrong!';
					header("Refresh: 1;");
				}
				
			}
		}
	
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Market Login</title>
<!-- Meta-Tags -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="Instant Sign In Form Widget Responsive, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //Meta-Tags -->

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
						<i class="fa fa-user" aria-hidden="true"></i> <input type="text" class="user" name="username" placeholder="Kullanıcı Adı" required="" />
					</div>
					<div class="input">
						<i class="fa fa-unlock-alt" aria-hidden="true"></i> <input type="password" class="lock" name="password" placeholder="Şifre" required="" />
					</div>
					<div class="signin-rit">
						<span class="checkbox1">
							<label class="checkbox"><input type="checkbox" name="checkbox" checked="">Beni hatırla</label>
						</span>
						<a class="forgot" href="#">Şifremi Unuttum??</a>
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