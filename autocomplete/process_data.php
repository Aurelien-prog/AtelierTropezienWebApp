<?php

//process_data.php

$connect = new PDO("mysql:host=localhost;dbname=bdd_ean", "akost", "1234567");

if(isset($_POST["query"]))
{	

	$data = array();

	$condition = preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]);

	$query = "
	SELECT reference FROM produit 
		WHERE reference LIKE '%".$condition."%' 
		ORDER BY id DESC 
		LIMIT 10
	";

	$result = $connect->query($query);

	$replace_string = '<b>'.$condition.'</b>';

	foreach($result as $row)
	{
		$data[] = array(
			'reference' => str_ireplace($condition, $replace_string, $row["reference"])
		);
	}
	echo json_encode($data);
}

$post_data = json_decode(file_get_contents('php://input'), true);

if(isset($post_data['search_query']))
{
	$data = array(
		':search_query'		=>	$post_data['search_query']
	);

	$query = "
	SELECT search_id FROM recent_search 
	WHERE search_query = :search_query
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	if($statement->rowCount() == 0)
	{
		$query = "
		INSERT INTO recent_search 
		(search_query) VALUES (:search_query)
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);
	}

	$output = array(
		'success'	=>	true
	);

	echo json_encode($output);

}

if(isset($post_data['action']))
{
	if($post_data['action'] == 'fetch')
	{
		$query = "SELECT * FROM recent_search ORDER BY search_id DESC LIMIT 10";

		$result = $connect->query($query);

		$data = array();

		foreach($result as $row)
		{
			$data[] = array(
				'id'				=>	$row['search_id'],
				'search_query'		=>	$row["search_query"]
			);
		}

		echo json_encode($data);
	}

	if($post_data['action'] == 'delete')
	{
		$query = "DELETE FROM recent_search WHERE search_id = '".$post_data["id"]."'";

		$connect->query($query);

		$output = array(
			'success'	=>	true
		);

		echo json_encode($output);
	}

}
?>