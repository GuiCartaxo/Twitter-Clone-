<?php

	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');

	$id_usuario = $_SESSION['id_usuario'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();
	
	$sql = " SELECT DATE_FORMAT(t.data_inclusao, '%d %b %Y %T') AS data_inclusao_formatada, t.tweet, t.id_tweet AS tweet_id, u.usuario, u.id ";
	$sql.= " FROM tweet AS t JOIN usuarios AS u ON (t.id_usuario = u.id) ";
	$sql.= " WHERE id_usuario = $id_usuario ";
	$sql.= " OR id_usuario IN (select seguindo_id_usuario from usuarios_seguidores where id_usuario = $id_usuario) ";
	$sql.= " ORDER BY data_inclusao DESC ";

	$resultado_id = mysqli_query($link, $sql);

	if($resultado_id){

		while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
			echo '<span href="#" class="list-group-item">';
				echo '<h4 class="list-group-item-heading">'.$registro['usuario'].' <small> - '.$registro['data_inclusao_formatada'].'</small></h4>';
				
				echo '<p class="list-group-item-text pull-right">';

					$e_do_usuario = $id_usuario == $registro['id'] ? 'block' : 'none';

					echo '<button type="button" id="btn_excluir_tweet_'.$registro['tweet_id'].'" style="display: '.$e_do_usuario.'" class="btn btn-default btn_excluir" data-id_usuario="'.$registro['id'].'">Excluir tweet</button>';
					
				echo '</p>';
				echo '<p class="list-group-item-text">'.$registro['tweet'].'</p>';
				echo '<div class="clearfix"></div>';
			echo '</span>';
		}

	} else {
		echo 'Erro na consulta de tweets no banco de dados!';
	}

?>