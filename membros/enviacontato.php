<?php 
$nome = $_POST[["nome"];
$email = $_POST["email"];
$assunto = $_POST["assunto"];
$mensagem = $_POST["mensagem"];
$destinatario = "philipecoutinho1@gmail.com.br";
if ($email != "")
{
$cabecalho = "From: $email\nReply-To: $email";
$corpo .= "Nome = $nome .\n";
$corpo .= "Email = $email .\n";
$corpo .= "Assunto = $assunto .\n";
$corpo .= "Mensagem = $mensagem .\n\n";
mail($destinatario, $assunto, $corpo, $cabecalho);
echo ("&statusx=enviado com sucesso&");
}
?>