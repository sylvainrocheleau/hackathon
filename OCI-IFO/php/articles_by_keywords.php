<?php

try {
// connection to MongoDB on the IFO server
	$conn = new Mongo('mongodb://hackathon_reader:To0305@www.oci-ifo.org:27017/scrapy?authMechanism=MONGODB-CR');
	$db = $conn->scrapy;
	$collection = $db->articles;
    
//Query to MongoDB
//This query looks for a particular keyword in articles. "$search" may be replaced by any keywords.
	$search = "Trudeau";
	$json = array();
	$articles = array(
	'full_article' => array('$regex' => new MongoRegex("/$search/i"))
		);	
    $articles = $collection->find($articles)->limit(100);
    foreach ($articles as $obj => $value) {
        $x = (array(
        $obj => $value
        )
        );
        $json[] = $x;
        }
        echo json_encode($json);

// disconnect from server
  $conn->close();
} catch (MongoConnectionException $e) {
  die('Error connecting to MongoDB server');
} catch (MongoException $e) {
  die('Error: ' . $e->getMessage());
}
?>
