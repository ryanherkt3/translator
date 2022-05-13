<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>English - Spanish Dictionary</title>
	
	<!-- CSS/stylesheet code !-->
	<?php
		echo '<link rel = "stylesheet" href = "style.css" type = "text/css">';
	?>
</head>

<h1>English - Spanish Dictionary</h1>

<body>
	<p>Type the English phrase, then select the language (only Spanish is available), and then type the phrase in the other language</p>
	
	<form action="index.php" method="POST">
		<label for="english">English phrase:</label>
		<textarea placeholder="Phrase goes here..." name="english" id = "english" ></textarea>
		
		<!-- dropdown menu for languages !-->
		<!-- NOTE: only spanish has been added by me, but the system can support other languages !-->
		<label for="language">Language to translate to:</label>
		<select name="language">
			<option value="">Select...</option>
			<option value="spanish">Spanish</option>
		</select>
		
		<label for="otherphrase">Phrase in other language:</label>
		<textarea placeholder="Phrase goes here..." name="otherphrase" id = "otherphrase" ></textarea>
		
		<div id = "button">
			<input type="submit" id="submit" name="submit">
		</div>
	</form>
	
	<div id="suggestions">
		<h3>Suggested Phrases:</h3>
	</div>

</body>
</html>

<!-- 
Code to create database is below. 
Note that a new database and table will not be created each time 
the page is reloaded (due to use of the 'IF NOT EXISTS' clause)
!-->
<?php
	//Step One - connect to MySQL and create database:
	$conn = mysqli_connect('localhost', 'root', '');
	mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS languagedb;");
	
	//Step Two - create the table:
	$db = mysqli_select_db($conn, 'languagedb');
	mysqli_query($conn, "CREATE TABLE IF NOT EXISTS phrases
	(
	enphrase varchar(255),
	language varchar(20),
	olphrase varchar(255),
	CONSTRAINT PK_Phrases PRIMARY KEY (enphrase, language, olphrase)
	);");
	
	//preload database with common phrases (if they don't exist):
	$conn = mysqli_connect('localhost', 'root', '', 'languagedb');
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('and', 'spanish', 'y');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('how', 'spanish', 'cómo');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('who', 'spanish', 'quién');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('when', 'spanish', 'cuándo');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('where', 'spanish', 'donde');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('why', 'spanish', 'por qué');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('what', 'spanish', 'qué');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('I am', 'spanish', 'soy');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('you are', 'spanish', 'eres');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('he is', 'spanish', 'el es');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('she is', 'spanish', 'ella es');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('they are', 'spanish', 'ellas son');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('they are', 'spanish', 'ellos son');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('I like', 'spanish', 'me gusta');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('you like', 'spanish', 'te gusta');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('he likes', 'spanish', 'le gusta');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('she likes', 'spanish', 'a ella le gusta');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('they like', 'spanish', 'a ellas les gusta');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('they like', 'spanish', 'a ellos les gusta');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('I have', 'spanish', 'tengo');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('you have', 'spanish', 'tienes');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('he has', 'spanish', 'él tiene');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('she has', 'spanish', 'ella tiene');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('they have', 'spanish', 'ellas tienen');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('they have', 'spanish', 'ellos tienen');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('I play', 'spanish', 'juego');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('you play', 'spanish', 'juegas');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('he plays', 'spanish', 'juega');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('she plays', 'spanish', 'ella juega');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('they play', 'spanish', 'ellas juegan');");
	mysqli_query($conn, "INSERT IGNORE INTO phrases (enphrase, language, olphrase) VALUES ('they play', 'spanish', 'ellos juegan');");
	
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']))
	{
		//check if user entered all the values
		if ((($_POST['english']) === '') or (($_POST['language']) === '') or (($_POST['otherphrase']) === ''))
		{
			echo 'One of the values is missing!';
		}
		else
		{
			$english = $_POST['english'];
			$language = $_POST['language'];
			$otherphrase = $_POST['otherphrase'];
			
			//check if phrase exists in database, if so don't enter it into database
			$checkforduplicateentries = "SELECT * FROM phrases 
			WHERE enphrase = '{$english}'
			AND olphrase = '{$otherphrase}'
			AND language = '{$language}';";			
			$duplicateRows = mysqli_num_rows(mysqli_query($conn, $checkforduplicateentries));
			
			if ($duplicateRows !== 0)
			{
				echo 'That phrase has already been translated!';
			}
			else	//put user inputs into database
			{
				$english = $_POST['english'];
				$language = $_POST['language'];
				$otherphrase = $_POST['otherphrase'];
			
				$sql = "INSERT INTO phrases (enphrase, language, olphrase) VALUES ('$english', '$language', '$otherphrase');";
				$query = mysqli_query($conn, $sql);
				if($query)
				{
					//array to store recommended phrases
					$recommended = array();
					
					$sql = "SELECT enphrase, olphrase 
					FROM phrases 
					WHERE language = '{$language}';";
					$result = mysqli_query($conn, $sql);
					$numRows = mysqli_num_rows($result);
					
					if ($numRows > 0)
					{
						while ($row = mysqli_fetch_assoc($result))
						{
							//strip fullstops, commas etc from phrase entered and one in database
							//and make the phrases lowercase so the comparison for recommendations
							//is fair
							$punct = array("?","!",",",";",".", " ");
							$english = strtolower(str_replace($punct, "", $english));
							$dbphrase = strtolower(str_replace($punct, "", $row['enphrase']));
							
							//check if there's an english phrase from the text (except the one entered) 
							//already in the database (or vice versa depending on the length), 
							//and if so, add it to the recommended phrases array:
							if(strlen($english) > strlen($dbphrase))
							{
								$pos = strpos($english, $dbphrase);
								if (($pos !== false) and ($english !== $dbphrase))
								{
									array_push($recommended, $row['enphrase'] . ' = ' . $row['olphrase']);
								}
							}
							else
							{
								$pos = strpos($dbphrase, $english);
								if (($pos !== false) and ($english !== $dbphrase))
								{
									array_push($recommended, $row['enphrase'] . ' = ' . $row['olphrase']);
								}
							}
						}
					}
					
					//output all the recommended phrases (if any exist)
					if (count($recommended) > 0)
					{
						echo 'Your phrase: ' . $_POST['english'] . '<br>';
						foreach($recommended as $value)
						{
							echo $value . '<br>';
						}
					}
					else echo 'No recommended phrases';
					
				}
				else
				{
					echo 'Error!';
				}
			}
		}
	}