<?php
/**
 * Template Name: recuperar-senha

 */

get_header();

?>
<?php
  if(isset($_POST['submit_recuperar'])):
    if(empty($_POST['email_recuperar'])):
      echo "<div class='validation_error'>Preencha o campo email</div>";
    elseif(!filter_var($_POST['email_recuperar'], FILTER_VALIDATE_EMAIL)):
      echo "<div class='validation_error'>Formato de email inválido</div>";
    elseif(!email_exists($_POST['email_recuperar'])):
        echo "<div class='validation_error'>Nenhum usuário com este email foi encontrado</div>";
    else:

    $to = $_POST['email_recuperar'];
    $subject = 'REDEFINIÇÃO DE SENHA';
    $message = "
      <h1>Olá !</h1><br>
      <p>Você está recebendo essa mensagem porque solicitou um link de redefinição de senha para sua conta da Kidoçura.<br>
      Se não foi você, relaxa.Mas se foi, clica no link.</p>
      <a href='".home_url()."/redefinir-senha?email=".$_POST['email_recuperar']."'>LINK</a>
    
    ";              

    wp_mail( $to, $subject, $message );
    echo "<div class='validation_error'>Mensagem enviada.</div>";
    global $wpdb;
    $sql = 'INSERT INTO `wp_pwd_reset`(email) VALUES (%s)';
    $sql = $wpdb->prepare($sql, array($_POST['email_recuperar']));
    $wpdb->query($sql);
  endif;
endif;


?>
<div class='recuperar_senha'>
  <h2 class='recuperar_senha_titulo'>Recuperar senha 🤔</h2>
  <form action='' method='post'>
      <input name='email_recuperar' type='text' size=30 placeholder='Seu e-mail'></input><br>
      <button type='submit' id='submit_recuperar' name='submit_recuperar'>ENVIAR LINK DE REDEFINIÇÃO</button>
  </form>
</div>

