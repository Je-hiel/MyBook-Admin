<?php 

	$host = 'localhost';
	$db_name = 'mybook_test'; // 'id13616728_mybook';
	$username = 'root'; // 'id13616728_mybookadmin';
	$password = ''; // 'izV#mC[?@5ZM~MM(';

    // Set DSN
    $dsn = 'mysql:host='. $host . ';dbname=' . $db_name;

	// Create a PDO instance
	try {
	    
		$db = new PDO($dsn, $username, $password);

		// Setting the default fetch method
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

		// Disabling emulate mode
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
	} catch (PDOException $e) {
		echo $error;
	}

?>