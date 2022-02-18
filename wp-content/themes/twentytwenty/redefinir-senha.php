<?php
/**
 * Template Name: redefinir-senha

 */

get_header();

?>
<?php 
//echo $_GET['email'];
  if(isset($_POST['submit_redefinir'])):
    if(empty($_POST['nova_senha'])):
      echo "<div class='validation_error'>Preencha o campo nova senha</div>";
    elseif(empty($_POST['confirmar_nova_senha'])):
      echo "<div class='validation_error'>Confirme a nova senha escolhida</div>";
    elseif($_POST['nova_senha'] !== $_POST['confirmar_nova_senha']):
    echo "<div class='validation_error'>As senhas não correspondem</div>";
    elseif(!filter_var($_POST['email_hidden'], FILTER_VALIDATE_EMAIL)):
      echo "<div class='validation_error'>Formato de email inválido</div>";
    else:
      global $wpdb;
      $sql = 'SELECT * FROM `wp_pwd_reset` WHERE `email` = %s';
      $sql = $wpdb->prepare($sql, array($_POST['email_hidden']));
      $res = $wpdb->get_results($sql);
      foreach($res as $item):
        $emailBanco = $item->email;
      endforeach;


      $user_id = get_user_by( 'email', $emailBanco )->id;
      if($wpdb->num_rows >= 1):  
          if($_POST['email_hidden'] !== $emailBanco):
            echo "<div class='validation_error'>Tenho que admitir que essa foi uma bela tentativa.</div>";
          else:
            
            wp_update_user( array(
              'ID' => $user_id,
              'user_pass' => $_POST['nova_senha'],
             ) );  
             echo "<div class='validation_error'>Senha alterada com sucesso</div>";

          endif;
      endif;
  endif;
endif;

?>
<div class='recuperar_senha'>
  <h2 class='recuperar_senha_titulo'>Redefinir senha 🤔</h2>
  <form action='' method='post'>
      <input type='hidden' name='email_hidden' value='<?php echo $_GET['email'];?>'>
      <input name='nova_senha' type='password' size=30 placeholder='nova senha' value='<?php echo (isset($_POST['nova_senha'])) ? $_POST['nova_senha'] : ""; ?>'></input><br>
      <input name='confirmar_nova_senha' type='password' size=30 placeholder='confirmar nova senha' value='<?php echo (isset($_POST['confirmar_nova_senha'])) ? $_POST['confirmar_nova_senha'] : ""; ?>'></input><br>
      <button type='submit' id='submit_recuperar' name='submit_redefinir'>ATUALIZAR SENHA</button>
  </form>
</div>