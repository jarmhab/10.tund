 <?php
	//laeme funktsiooni faili
	require_once("function.php");
	require_once("InterestManager.class.php");
	
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		//suunan login lehele
		header("Location: login_sample.php");
		exit();		
	}
	//login välja
	if (isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: login_sample.php");		
	}
	
	//teen uue instantsi class interestmanagerist
	$InterestManager = new InterestManager($mysqli);
	
	if(isset($_GET["new_interest"])){
		
		$added_interest_response = $InterestManager->addInterest($_GET["new_interest"]);
		
	}
	
?> 
<p>
	Tere, <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h2>Lisa uus huviala</h2>
<?php if(isset($added_interest_response->error)):?>
  
  <p><p style="color:red;"><?=$added_interest_response->error->message?></p>
  
  <?php elseif(isset($added_interest_response->success)): ?>
 
 <p style="color:green;"><?=$added_interest_response->success->message;?>
	</p>
  <?php endif; ?>
<form>
	<input name="new interest">
	<input type="submit">
</form>

<h2>Minu huvialad</h2>
<form>
	<!--Siia tuleb rippmenüü-->
	<?php echo $InterestManager->createDropdown();?>
	<input type="submit">
</form>