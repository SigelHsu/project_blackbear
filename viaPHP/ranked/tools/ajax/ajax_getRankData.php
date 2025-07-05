<?php
	$data["event"] = array(
		"No" => "E000001",
		"Title" => "盧實戰技",
	);
	$data["rules"] = array(
		0 => array(
			"Tag" 	=> "Score",
			"Image" => "./img/blood.png",
			"Asc" 	=> 1
		),
		1 => array(
			"Tag" 	=> "Star",
			"Image" => "./img/star.png",
			"Asc" 	=> 1
		),
		2 => array(
			"Tag" 	=> "Cards",
			"Image" => "./img/card-game.png",
			"Asc" 	=> 1
		),
	);
	$data["players"] = array(
		0 => array(
			"ID" 			=> "P01",
			"Name" 		=> "Rat",
			"Image" 	=> "./img/rat.png",
			"ForRank" => array(
				"Score" => 30,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
		1 => array(
			"ID" 			=> "P02",
			"Name" 		=> "Cow",
			"Image" 	=> "./img/cow.png",
			"ForRank" => array(
				"Score" => 25,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
		2 => array(
			"ID" 			=> "P03",
			"Name" 		=> "Tiger",
			"Image" 	=> "./img/tiger.png",
			"ForRank" => array(
				"Score" => 20,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
		3 => array(
			"ID" 			=> "P04",
			"Name" 		=> "Rabbit",
			"Image" 	=> "./img/rabbit.png",
			"ForRank" => array(
				"Score" => 15,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
		4 => array(
			"ID" 			=> "P05",
			"Name" 		=> "Dragon",
			"Image" 	=> "./img/dragon.png",
			"ForRank" => array(
				"Score" => 10,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
		5 => array(
			"ID" 			=> "P06",
			"Name" 		=> "Snake",
			"Image" 	=> "./img/snake.png",
			"ForRank" => array(
				"Score" => 5,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
		6 => array(
			"ID" 			=> "P07",
			"Name" 		=> "Hoses",
			"Image" 	=> "./img/horse.png",
			"ForRank" => array(
				"Score" => 0,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
	);
?>
function ajax_getRankData () {
	return $.parseJSON('<?=json_encode($data); ?>');
}


<?php
	$data["event"] = array(
		"No" => "E000001",
		"Title" => "盧實戰技",
	);
	$data["rules"] = array(
		0 => array(
			"Tag" 	=> "Score",
			"Image" => "./img/blood.png",
			"Asc" 	=> 1
		),
		1 => array(
			"Tag" 	=> "Star",
			"Image" => "./img/star.png",
			"Asc" 	=> 1
		),
		2 => array(
			"Tag" 	=> "Cards",
			"Image" => "./img/card-game.png",
			"Asc" 	=> 1
		),
	);
	$data["players"] = array(
		0 => array(
			"ID" 			=> "P01",
			"Name" 		=> "Rat",
			"Image" 	=> "./img/rat.png",
			"ForRank" => array(
				"Score" => 30,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
		1 => array(
			"ID" 			=> "P02",
			"Name" 		=> "Cow",
			"Image" 	=> "./img/cow.png",
			"ForRank" => array(
				"Score" => 15,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
		2 => array(
			"ID" 			=> "P03",
			"Name" 		=> "Tiger",
			"Image" 	=> "./img/tiger.png",
			"ForRank" => array(
				"Score" => 20,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
		3 => array(
			"ID" 			=> "P04",
			"Name" 		=> "Rabbit",
			"Image" 	=> "./img/rabbit.png",
			"ForRank" => array(
				"Score" => 15,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
		4 => array(
			"ID" 			=> "P05",
			"Name" 		=> "Dragon",
			"Image" 	=> "./img/dragon.png",
			"ForRank" => array(
				"Score" => 40,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
		5 => array(
			"ID" 			=> "P06",
			"Name" 		=> "Snake",
			"Image" 	=> "./img/snake.png",
			"ForRank" => array(
				"Score" => 5,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
		6 => array(
			"ID" 			=> "P07",
			"Name" 		=> "Hoses",
			"Image" 	=> "./img/horse.png",
			"ForRank" => array(
				"Score" => 60,
				"Star" 	=> 3,
				"Cards" => 2,
			),
		),
	);
?>
function ajax_getRankDataNew () {
	return $.parseJSON('<?=json_encode($data); ?>');
}