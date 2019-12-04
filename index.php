<?php
session_start(); #list: key, msisdn, otp, secret_token
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショット</title>
    <link rel="shortcut icon" href="https://resources.1337route.cf/favicon.ico" type="image/x-icon" />
    <meta charset="UTF-8">
    <body bgcolor="brown">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v10/css/util.css">
    <center>
    </head>
<?php
    date_default_timezone_set('Asia/Jakarta');
    
    require_once('config.php');
    require('class.php');
    
    $err    = NULL;
    $ress   = NULL;
    
    if (isset($_POST) and isset($_POST['do'])){
        
        switch($_POST['do']){
            
            default: die(); exit(); break;

            case "CHANGE":{
                $key    = $_SESSION['key'];
                $msisdn = $_SESSION['msisdn'];
                $tipe   = $_SESSION['tipe'];
                
                unset($_SESSION['key']);
                unset($_SESSION['tipe']);
                unset($_SESSION['msisdn']);
                unset($_SESSION['otp']);
                unset($_SESSION['secret_token']);
                session_destroy();
            }
            break;
            
            case "LOGOUT":{
                
                $key            = $_SESSION['key'];
                $msisdn         = $_SESSION['msisdn'];
                $tipe           = $_SESSION['tipe'];
                $otp            = $_SESSION['otp'];
                $secret_token   = $_SESSION['secret_token'];
                
                
                $tsel = new MyTsel();
                $tsel->logout($secret_token, $tipe);
                
                unset($_SESSION['key']);
                unset($_SESSION['tipe']);
                unset($_SESSION['msisdn']);
                unset($_SESSION['otp']);
                unset($_SESSION['secret_token']);
                session_destroy();
            }
            break;
            
            
            case "GETOTP":{
                $key    = $_POST['key'];
                $msisdn = $_POST['msisdn'];
                
                
                if ($key != privatekey){die("Error: wrong key");}
                $tsel = new MyTsel();
                if ($tsel->get_otp($msisdn) == "SUKSES"){
                    
                    session_regenerate_id();
                    $_SESSION['key'] = $key;
                    $_SESSION['msisdn'] = $msisdn;                    
                    session_write_close();

                }
                else
                {
                    $err = "Error: msisdn salah";
                }
            }
            break;
            
            case "LOGIN":{
                $key    = $_SESSION['key'];
                $msisdn = $_SESSION['msisdn'];
                $tipe   = $_POST['tipe'];
                $otp    = $_POST['otp'];
                
                //if ($key != privatekey){die("Error: wrong key");}
                $tsel = new MyTsel();
                $login = $tsel->login($msisdn, $otp, $tipe);
                
                
                if (strlen($login) > 0){

                    $secret_token               = trim(preg_replace('/\s+/', ' ', $login));
                    $_SESSION['otp']            = $otp;
                    $_SESSION['secret_token']   = $secret_token;
                    $_SESSION['tipe']           = $tipe;
                    
                    
                } else {
                    //echo $login;
                    $err = $login;
                }

                
            }
            break;
            
            case "BUY_PKG":{
                $key            = $_SESSION['key'];
                $msisdn         = $_SESSION['msisdn'];
                $tipe           = $_SESSION['tipe'];
                $secret_token   = $_SESSION['secret_token'];
                $pkgid          = $_POST['pkgid'];
                $transactionid  = $_POST['transactionid'];
                
                switch($_POST['pkgid']){
                case '1':
                    $pkgidman = $_POST['pkgidman'];
                    $tsel = new MyTsel();
                    $ress = "PKGID: <b>".$pkgidman."</b><br>Result: ".$tsel->buy_pkg($secret_token, $pkgidman, $transactionid, $tipe);
                break;
                default:
                    $tsel = new MyTsel();
                    $ress = "PKGID: <b>".$pkgid."</b><br>Result: ".$tsel->buy_pkg($secret_token, $pkgid, $transactionid, $tipe);
                }
                
            }
            break;
            
        }
        
    }
?>

<!-- ################################ 1 ################################ -->
<?php if (!isset($_SESSION['key']) and !isset($_SESSION['msisdn']) and !isset($_SESSION['otp']) and !isset($_SESSION['secret_token']) ){ ?>
<body>
<div class="container-contact100">
<div class="wrap-contact100">
<form class="contact100-form validate-form" method="POST">
<span class="contact100-form-title">
<marquee><font color="red">これはテセールショットあなたは使う下さい私はFumitoshi-taro :)</font></marquee>
<h1>
<br>
<br>
<font color="red">ショット</font>
<p>
</h1>
</span>
<!--     <form method="POST">
    <pre> -->
<br>
<input type="button" value="あまたは使う６２しかし使う０ダメよ" style="font-size:1em;background:green;color:white"><br></input>
<p>
<font color="white">６２＊＊＊＊＊＊＊＊＊＊＊👇</font>
<div class="wrap-input100 validate-input" data-validate="Please enter your msisdn">
<input class="input100" type="text" name="msisdn" placeholder="６２＊＊＊＊＊＊＊＊＊＊＊x">
<br>
<br>
<br>
<span class="focus-input100"></span>
</div>
<div class="wrap-input100 validate-input" data-validate="Please enter your key">
<input type="hidden" type="text" value="tppgaming" name="key" placeholder="Key">
<span class="focus-input100"></span>
</div>
<div class="container-contact100-form-btn">
<button class="contact100-form-btn" name="do" value="GETOTP" type="submit">
    <span>
<i class="fa fa-paper-plane-o m-r-6" aria-hidden="true"></i>
<p>
<h5>
<input type="button" value="KEYレクエースト" style="font-size:1em;background:green;color:white"><br></input>
</h5>
</span></button>
</div>
<!-- <input type="submit" name="do" value="GETOTP"></input> -->
<?php if(!empty($err)) echo $err ?> 
<!--     </pre> -->
</form>
</div>
</div>
</body>

<!-- ################################ 2 ################################ -->
<?php }else if (isset($_SESSION['key']) and isset($_SESSION['msisdn']) and !isset($_SESSION['otp']) and !isset($_SESSION['tipe']) and !isset($_SESSION['secret_token'])){ ?>
<body>
<div class="container-contact100">
<div class="wrap-contact100">
<form class="contact100-form validate-form" method="POST">
<span class="contact100-form-title">
<h1>
<br>
<center>
    
<label class="radio-container m-r-45">
<input type="radio" checked="checked" name="tipe" value="vmp.telkomsel.com">
<span class="checkmark"></span>
</label>

        </center>
<font color="red">Dor Tsel</font>
<p>
</h1>
</span>
    
<fieldset>
<hr>
<div class="wrap-input100 validate-input" data-validate="Please enter your phone">
<input class="input100" type="text" value="<?= $_SESSION['msisdn']; ?>" name="phone" disabled>
<span class="focus-input100"></span>
</div>
<div class="wrap-input100 validate-input" data-validate="Please enter your key">
<p>
<marquee><font color="white">１０時間</font></marquee>
<font color="white">if OTP not send try this number</font>
<input type="button" value="*323*10#" style="font-size:1em;background:green;color:white"><br></input>
<font color="white">置くOTP👇</font>
<p>
<input class="input100" type="number" name="otp">
<span class="focus-input100"></span>
</div>
<div class="container-contact100-form-btn">
<button class="contact100-form-btn" name="do" value="CHANGE" type="submit">
    <i class="fa fa-paper-plane-o m-r-6" aria-hidden="true"></i>
<input type="button" value="BACK" style="font-size:1em;background:red;color:white"><br></input>
</span></button>&nbsp;&nbsp;
    <button class="contact100-form-btn" name="do" value="LOGIN" type="submit">
    <i class="fa fa-paper-plane-o m-r-6" aria-hidden="true"></i>
<input type="button" value="LOGIN" style="font-size:1em;background:green;color:white"><br></input>

</span></button>
</div>
<hr>
</fieldset>
<!-- <input type="submit" name="do" value="LOGIN"></input> -->
<?php if(!empty($err)) echo $err ?>
<!--     </pre> -->
    </form>
</div>
</div>
</body>

<!-- ################################ 3 ################################ -->
<?php }else if (isset($_SESSION['key']) and isset($_SESSION['msisdn']) and isset($_SESSION['otp']) and isset($_SESSION['tipe']) and isset($_SESSION['secret_token'])){ ?>
<body>
<form method="POST">
<p><br><br>
<fieldset>
<hr>
<br>
<font color="red">PAKET:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="pkgid" onchange="if (this.value=='1'){this.form['pkgidman'].style.visibility='visible'}else {this.form['pkgidman'].style.visibility='hidden'};" style="width: 50%;">
</font>
  <option value="000"> 買うたこのパケット</option>
  <option value="00016038"> 5Gb 30 Days OMG Rp.10rb,-</option>
  <option value="00016036"> Klik Film Rp.5Gb 10rb,- </option>
  <option value="00009382"> 1Gb 2 Hari OMG Rp.10,-</option>
  <option value="00007333"> Maxtream 30Gb 30 Days Rp.30rb,-</option>
  <option value="00016030"> Maxtream 10Gb 30 Days Rp.10rb,- </option>
  <option value="00016038"> Maxtream 5Gb  30 Days Rp.10rb,-</option>
　<option value="0016199"> Add On Max 30GB 30 Days Rp 30rb,-<option>
　<option value="
　<option value="
</select><br><br><br>
<input type="submit" name="do" value="BUY_PKG" style="font-size:1em;background:green;color:white"> </input><br><br>
<input type="submit" name="do" value="LOGOUT" style="font-size:1em;background:red;color:white"><br></input>
<br>
<hr>
</fieldset>
</form>
</body>
<?php } ?>
