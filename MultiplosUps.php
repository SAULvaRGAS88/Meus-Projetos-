<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Upload de arquivos</title>
</head>
<body>

	<form action="" method="post" enctype="multipart/form-data">
		<div style="margin-top:15px">
			<input type="file" name="arquivo[]" multiple>
		</div>
		<input style="margin-top:15px" type="submit" name="enviar">
	</form>

<?php 
	if ( isset($_POST['enviar']) ) {
		
		$multArquivos = count($_FILES['arquivo']['name']);
		$erros = array();
		$tamanhoMaximo = 1024 * 1024 * 5; 
		$arquivosPermitidos = ["png","jpg","jpeg","pdf"];
		$typesPermitidos = ["application/pdf", "image/png", "image/jpg","image/jpeg"];
		$caminho = "uploads/";
		$hoje = date('d-m-Y_h-i');
		echo "<hr>";

		for($i = 0; $i <$multArquivos; $i++){
	
			$nomeArquivo = $_FILES["arquivo"]["name"][$i];
			$type = $_FILES["arquivo"]["type"][$i];
			$nomeTemporario = $_FILES["arquivo"]["tmp_name"][$i];
			$tamanho = $_FILES["arquivo"]["size"][$i];

			if ($tamanho > $tamanhoMaximo){
				$erros[] = "Seu arquivo excede o tamanho máximo<br>";
			}

			$extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);

			if ( !in_array($type, $typesPermitidos )) {
				$erros[] = "Tipos de arquivos não permetidos!<br>";
			}

			if ( !empty($erros)) {
				foreach ($erros as $erro) {
					echo $erro;
				}
			}else{
				$novoNome = $hoje."-".$nomeArquivo;
				if (move_uploaded_file($nomeTemporario, $caminho . $novoNome)) {
					echo "Upload feito com SUCESSO!>>>>>DEMOROU, MAIS SAIU<<<<<(".$caminho . $novoNome.")". "<br>";
				}else{
					echo "Erro ao enviar o arquivo";
				}
			}

		}	

	}

?>

</body>
</html>