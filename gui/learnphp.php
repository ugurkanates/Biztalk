<html>
	<head>
	</head>

	<body>
		<?php
			// Dosyadan xml'i parse eder.
			// $xml = simplexml_load_file("filename") or die("Error: Cannot create object");  
			
			// String'ten xml'i parse eder.
			$xml = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?>
											<note>
											  <to>192.168.1.1</to> 
											  <from>127.0.0.1</from>
											  <job>job</job>
											  <body>Falan filan?</body>
											</note>');

			$xml->job = 'Job2'; // xml'in tag'inin içeriğini değiştirir.
			var_dump($xml);	// xml objesini tag'lerle birlikte print eder.
			
			//echo $xml->asXML() . "\n"; // Tag'siz tüm xml'i print eder.
			
			
			// Sirasiyla xml'in token'lerini print eder.
			echo "to: " . $xml->to . "\n";
			echo "from: " . $xml->from . "\n";
			echo "job: " . $xml->job . "\n";
			echo "body: " . $xml->body . "\n";
			
			
			/* //XML objesi'ni string ile oluşturma formatı
			$string = <<<XML
			<a>
		  	  <c>text</c>
		  	  <c>stuff</c>
			</a>
			XML;

			$xml = new SimpleXMLElement($string);
			*/

		   // Döngü ile istenen XML tokenine ulaşıp değişiklik yapma.
		   foreach($xml as $item => $value)
		   {
		      if($item == "job") // -> <job> tokeni bulunup değeri değiştirilir.
		      {
		         $xml->$item = "job3";
		      }
		   }

		   var_dump($xml);

		   //$xml->asXML("text.xml"); // text.xml dosyasına xml formatında objeyi kaydeder.
		?>

	</body>
</html>