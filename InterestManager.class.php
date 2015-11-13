<?php
class InterestManager{
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function addInterest($new_interest){
		$response = new StdClass();
				
		//kas selline email on olemas juba?
		$stmt = $this->connection->prepare("SELECT name FROM interests WHERE name = ?");
		$stmt->bind_param("s", $new_interest);
		$stmt->execute();
		
		//kas oli 1 rida andmeid
		if($stmt->fetch()){
			
			//saadan tagasi errori
			$error = new StdClass();
			$error->id=0;
			$error->message = "Selline huviala on juba olemas!";
			
			//panen errori responsile kylge
			$response->error = $error;
			//p2rast returni enam koodi edasi ei vaadata funktsioonis
			return $response;
			
		}
		$stmt->close();
		$stmt = $this->connection->prepare("INSERT INTO interests (name) VALUES (?)");
		$stmt->bind_param("s", $new_interest);
		if($stmt->execute()){
			//edukalt salvestatud
			$success = new StdClass();
			$success->message = "Huviala edukalt lisatud.";
			
			$response->success = $success;
			
		}else{
			
			// midagi l? katki
			$error = new StdClass();
			$error->id =1;
			$error->message = "Midagi l‰ks viltu!";
			
			//panen errori responsile k??
			$response->error = $error;
			
		}
		$stmt->close();
			
			//saada tagasi vastuse, kas success v??rror
			return $response;
	}
		
	function createDropdown(){
		
		$html = '';
		$html .= '<select name="dropdownselect">';
		$stmt = $this->connection->prepare('SELECT name FROM interests');
		$stmt->bind_result($name);
		$stmt->execute();
		
		while($stmt->fetch()){
			$html .= '<option>'.$name.'</option>';
		}
		$stmt->close();
		//$html .= '<option value="2">Teisip√§ev</option>';
		$html .= '</select>';
		
		return $html;
	}
}?>