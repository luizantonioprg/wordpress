<?php
/**
 * Template Name: Dashboard

 */
$home = home_url();
get_header();
session_start();
if(!isset($_SESSION['loggedin'])):
  header("Location:$home");
endif;

// puxar dados do usuario;
$user_id = $_SESSION['loggedin']['ID'];
$user_data = get_userdata($user_id);

$user_nicename = $user_data->user_nicename;
$user_email = $user_data->user_email;
$user_pwd = $user_data->user_pass;
$telefone = get_user_meta( $user_id, 'telefone_meta_key', true);
$estado = get_user_meta( $user_id, 'estado_meta_key', true);
$cidade = get_user_meta( $user_id, 'cidade_meta_key', true);
$bairro = get_user_meta( $user_id, 'bairro_meta_key', true);
$rua = get_user_meta( $user_id, 'rua_meta_key', true);
$numero = get_user_meta( $user_id, 'numero_meta_key', true);
$complemento = get_user_meta( $user_id, 'complemento_meta_key', true);
$cpf = get_user_meta( $user_id, 'cpf_meta_key', true);
$nascimento = get_user_meta( $user_id, 'nascimento_meta_key', true);
$nomeUsuario = get_user_meta( $user_id, 'nome_meta_key', true);

?>
<h1 class='titulo'>Olá <?php echo $nomeUsuario?></h1>
<div class='container_alterar_dados'>
  <a href='<?php echo home_url()."/pagamentos"?>'>MEUS PAGAMENTOS</a>



<?php




if(isset($_POST['submit_atualizar'])):
    
  $nome_cadastrar = $_POST['nome_cadastrar'];
  $email_cadastrar = $_POST['email_cadastrar'];
  $senha_cadastrar = $_POST['senha_cadastrar'];
  $confirmar_senha_cadastrar = $_POST['confirmar_senha_cadastrar'];
  $telefone_cadastrar = $_POST['telefone_cadastrar'];
  $estado_cadastrar = $_POST['estado_cadastrar'];
  $cidade_cadastrar = $_POST['cidade_cadastrar'];
  $bairro_cadastrar = $_POST['bairro_cadastrar'];
  $rua_cadastrar = $_POST['rua_cadastrar'];
  $numero_cadastrar = $_POST['numero_cadastrar'];
  $complemento_cadastrar = $_POST['complemento_cadastrar'];
  $cpf_cadastrar = $_POST['cpf_cadastrar'];
  $nascimento_cadastrar = $_POST['nascimento_cadastrar'];



  if(empty($_POST['nome_cadastrar'])):
    $_SESSION['validation_error_message']='Preencha o campo nome.';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>"; 
  elseif(empty($_POST['email_cadastrar'])):
    $_SESSION['validation_error_message']='Preencha o campo email.';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";    
  elseif(empty($_POST['telefone_cadastrar'])):
    $_SESSION['validation_error_message']='Preencha o campo telefone.';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
  elseif(empty($_POST['estado_cadastrar'])):
    $_SESSION['validation_error_message']='Preencha o campo estado.';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
  elseif(empty($_POST['cidade_cadastrar'])):
    $_SESSION['validation_error_message']='Preencha o campo cidade.';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
  elseif(empty($_POST['bairro_cadastrar'])):
    $_SESSION['validation_error_message']='Preencha o campo bairro.';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>"; 
  elseif(empty($_POST['rua_cadastrar'])):
    $_SESSION['validation_error_message']='Preencha o campo rua.';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>"; 
  elseif(empty($_POST['numero_cadastrar'])):
    $_SESSION['validation_error_message']='Preencha o campo numero.';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";  
  elseif(empty($_POST['complemento_cadastrar'])):
    $_SESSION['validation_error_message']='Preencha o campo complememento.';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>"; 
  elseif(empty($_POST['cpf_cadastrar'])):
    $_SESSION['validation_error_message']='Preencha o campo cpf.';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";   
  elseif(empty($_POST['nascimento_cadastrar'])):
    $_SESSION['validation_error_message']='Preencha o campo data de nascimento.';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";   
  elseif($senha_cadastrar !== $confirmar_senha_cadastrar):
    $_SESSION['validation_error_message']='As senhas não coincidem.';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
  elseif(email_exists(  $email_cadastrar ) && $email_cadastrar !== $user_email):
      $_SESSION['validation_error_message']='Este email já está em uso';
      echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
  else:
    if(empty($senha_cadastrar)):
        $senha_cadastrar = $user_pwd;
    endif;

    wp_update_user( array(
      'ID' => $user_id,
      'user_email' => $email_cadastrar,
      'user_nicename' => $nome_cadastrar,
      'user_pass' => $senha_cadastrar,
 ) );  // correct email address
  
  update_user_meta( $user_id, 'nome_meta_key', $nome_cadastrar );
  update_user_meta( $user_id, 'telefone_meta_key', $telefone_cadastrar );
  update_user_meta( $user_id, 'estado_meta_key', $estado_cadastrar );
  update_user_meta( $user_id, 'cidade_meta_key', $cidade_cadastrar );
  update_user_meta( $user_id, 'bairro_meta_key', $bairro_cadastrar );
  update_user_meta( $user_id, 'rua_meta_key', $rua_cadastrar );
  update_user_meta( $user_id, 'numero_meta_key', $numero_cadastrar );
  update_user_meta( $user_id, 'complemento_meta_key', $complemento_cadastrar );
  update_user_meta( $user_id, 'cpf_meta_key', $cpf_cadastrar );
  update_user_meta( $user_id, 'nascimento_meta_key', $nascimento_cadastrar );
  endif;
endif;

?>
   <div id='kart' class='kart' title='MEU CARRINHO'><a href='<?php echo "$home/finalizar-pedido"?>'>🛒</a><br>
                <span id='s_len'></span>
              </div>
<script>
function tamanho(){
  $localStoragelenght = 0;
        // ACHA TODOS OS LOCALSTORAGE COM PREFIXO
        for (var i = 0; i < localStorage.length; i++){
            if (localStorage.key(i).substring(0,5) == 'PROD_') {
                $localStoragelenght++;  
              
            }
          }
          return $localStoragelenght;
}


  function existe_session_storage(){
   
    if(tamanho()=="0"){
     
      document.getElementById('s_len').innerHTML = "0";
    }else{
      document.getElementById('s_len').innerHTML = tamanho();
    }
    
    $titulo_produto = "PROD_"+document.getElementById("o_titulo").innerHTML;
    $arr = document.querySelectorAll('.add_carrinho');
    for($i = 0;$i < $arr.length; $i++){
     $id_botao = $arr[$i].id;
    }




// se ja ta, remove
    if(document.getElementById($id_botao).innerHTML=='adicionado ao carrinho ☑️'){
      console.log('esse ja taa');
      document.getElementById($id_botao).innerHTML = 'Adicionar ao carrinho 🛒';
      localStorage.removeItem($titulo_produto);
      document.getElementById('s_len').innerHTML = tamanho();
      console.log($localStoragelenght);
    }




    const name = localStorage.getItem($titulo_produto);
      if(name){
          //console.log('Name exists');
          document.getElementById("kart").style.display='block';
          document.getElementById($id_botao).innerHTML = 'adicionado ao carrinho ☑️';
          document.getElementById('s_len').innerHTML = tamanho();
          console.log($localStoragelenght);
      }else{
          //console.log('Name is not found');
      }
  }



  function adicionar_ao_carrinho(id){

    $titulo_produto = "PROD_"+document.getElementById("o_titulo").innerHTML;
    $quantidade = "QNT_"+document.getElementById("o_titulo").innerHTML;
    $id_produto = document.getElementById("post_id").value;
    $preco_produto = document.getElementById("preco").value;
    $original = "ORIG_"+document.getElementById("o_titulo").innerHTML;
    $qnt = document.getElementById("qty").value;
  
    localStorage.setItem($titulo_produto,  $preco_produto);
    localStorage.setItem($original,  $preco_produto);
    localStorage.setItem($quantidade,  $qnt);
    //document.getElementById(id).innerHTML = 'adicionado';
    existe_session_storage();
 
  }

  document.addEventListener('onload', existe_session_storage());
</script>
