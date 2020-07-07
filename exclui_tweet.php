<?php

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');
	
	$tweet_excluido = $_POST['dados'];
	$id_usuario = $_SESSION['id_usuario'];

	$i = 0;

    while ($tweet_excluido[$i] != '1' && $tweet_excluido[$i] != '2' && $tweet_excluido[$i] != '3' && $tweet_excluido[$i] != '4' && $tweet_excluido[$i] != '5' && $tweet_excluido[$i] != '6' && $tweet_excluido[$i] != '7' && $tweet_excluido[$i] != '8' && $tweet_excluido[$i] != '9'){
        $i++;
    }
    
    //echo $i;

    $palavra = '';
    while ($i < strlen($tweet_excluido)){
        $palavra.=$tweet_excluido[$i];
        $i++;
    }

	if($tweet_excluido == '' || $id_usuario == ''){
		die();
	}

	$objDb = new db();
	$link = $objDb->conecta_mysql();
	
	$sql = " DELETE FROM tweet WHERE id_tweet = $palavra ";

	mysqli_query($link, $sql);

?>