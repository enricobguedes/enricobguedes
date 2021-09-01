<?php
// informações para serem mandadas
$nome = $_POST['nome'];
$email = $_POST['email'];
$mensagem = $_POST['mensagem'];

if(!empty($nome) || !empty($email) || !empty($mensagem)) { //checar se campos estão vazios.
	$host = "";
	$dbUsername = ""; // prencher com as infos necessárias
	$dbPassword = "";
	$dbName = "";

	// iniciar conexão

	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

	if(mysql_connect_error()) {
		die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error()):
	} else {
		$SELECT = "SELECT email FROM tabela WHERE email = ? LIMIT 1"; // checar se email é unico
		$INSERT = "INSERT INTO tabela (nome, email, mensagem) VALUES (?,?,?)";

		//preparando envio

		$stmt = $conn -> prepare($SELECT);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum = $stmt->num_rows;

		//envio
		
		if ($rnum == 0) {
			$stmt->close();
			$stmt->bind_param("sss", $nome, $email, $mensagem);
			$stmt->execute();
			echo "Informações enviadas com sucesso!";

		} else {
			echo 'Alguém já usou este e-mail, tente novamente.'
		}
		$stmt->close();
		$conn->close();
	}

}else{
	echo "Preencher todos os campos, por favor.";
	die();
}


?>
