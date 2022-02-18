<?php
/**
 * Template Name: cadastro-ou-login

 */
session_start();


  

?>

<!DOCTYPE HTML>
<html>
  <head>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/home.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/header.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/front_page.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/recuperar-senha.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/singular.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/single_post.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/scrollbar.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/dashboard.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/blog.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/redefinir-senha.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/integra_categorias.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/carrinho.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/finalizar-pedido.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/boleto.css' ?>">
    <title>HOME</title>
  </head>
<body>

<div class="wavy-frame"></div>
<div class='container-menu'>
  <a href='<?php echo home_url()?>'>
    <img src="<?php echo get_stylesheet_directory_uri(). '/assets/images/logo.png' ?>" width="300px">
  </a>
  <div class='nav'>
      <div class="dropdown">
 	<a style='color:white;text-decoration:none;' href='<?php echo home_url()."/"?>'>
        	<button class="dropbtn">CARDÁPIO</button>
	</a>
        <div class="dropdown-content">
        <?php
                $terms = get_terms( array(
                  'taxonomy' => 'categorias',
                  'hide_empty' => false,
                ) );

                foreach($terms as $term):
                  $id = $term->term_id;

                  echo "<a href='";
                  echo  get_term_link(  $id,'categorias');
                  echo "'>$term->name</a>";
                endforeach;

          ?>
        </div>
      </div>

      <div class="dropdown">
        <!-- <button class="dropbtn">
          <a style='color:white;text-decoration:none;' href='<?php echo home_url()."/pagamentos"?>'>PAGAMENTOS</a>
        </button> -->

        <div class="dropdown-content">
              <?php
              $terms = get_terms( array(
                'taxonomy' => 'categorias',
                'hide_empty' => false,
              ) );

              foreach($terms as $term):
             // echo "<a href='#'>$term->name</a>";;
              endforeach;

              ?>
        </div>
      </div>

      <div class="dropdown">
      <a style='color:white;text-decoration:none;' href='<?php echo home_url()."/blog"?>'>
        <button class="dropbtn">
        BLOG
        </button>
        </a>
        <div class="dropdown-content">
        <?php
                $terms = get_terms( array(
                  'taxonomy' => 'category',
                  'hide_empty' => false,
                ) );

                foreach($terms as $term):
                  $id = $term->term_id;

                  echo "<a href='";
                  echo  get_term_link(  $id,'category');
                  echo "'>$term->name</a>";
                endforeach;

          ?>
        </div>
      </div>

     

  </div>
</div>


<?php
function tirarCaracteresEspeciais($string){
  //Usa a função para padronizar a codificação da página
      $string = utf8_encode($string);
  //Trim retira os espaços vazios no começo e fim da variável
      $string = trim($string);
  //str_replace substitui um carácter por outro, nesse caso espaço por nada
      $string = str_replace(' ', '', $string);
  //Aqui substitui o underline por nada
      $string = str_replace('_', '', $string);
  //Aqui retira a barra
      $string = str_replace('/', '', $string);
  //Nessa linha o traço
      $string = str_replace('-', '', $string);
  //A abertura de parenteses
      $string = str_replace('(', '', $string);
  //O fechamento de parenteses
      $string = str_replace(')', '', $string);
  //O ponto
      $string = str_replace('.', '', $string);
  //No fim é retornado a variável com todas as alterações
      return $string;
  }

  if(isset($_POST['submit_entrar'])):
    global $wpdb;
    $email = $_POST['email_entrar'];
    if(empty($_POST['email_entrar'])):
      $_SESSION['validation_error_message']='Preencha o campo *email*';
      echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
    elseif(empty($_POST['senha_entrar'])):
      $_SESSION['validation_error_message']='Preencha o campo *senha*';
      echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)):
      $_SESSION['validation_error_message']='Formato de email inválido';
      echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
    else:
      $email = $_POST['email_entrar'];
      $senha = $_POST['senha_entrar'];
  
      $sql = 'SELECT * FROM `wp_users` WHERE `user_email` = %s';
      $sql = $wpdb->prepare($sql, array($email));
      $hash = $wpdb->get_results($sql);
      foreach($hash as $item):
        $senhaBanco = $item->user_pass;
      endforeach;
  
      $sql = 'SELECT * FROM `wp_users` WHERE `user_email` = %s';
      $sql = $wpdb->prepare($sql, array($email));
      $res = $wpdb->get_results($sql);
      foreach($res as $item):
        $user_id = $item->ID;
      endforeach;
      
      if(empty($senhaBanco)):
        $_SESSION['validation_error_message']='Usuário inexistente';
        echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
      else:
          if(wp_check_password($senha,$senhaBanco,$user_id)):
           
           // wp_mail( 'luiz.antonio.contato@outlook.com', 'assunto', 'oi oi oi');

            //LOGIN
            $_SESSION['loggedin'] = array(
              "ID"=>$user_id,
              "email"=>$email_entrar

            );
            //header('Location:http://ambiente-desenvolvimento15.provisorio.ws/gomes/wordpress/dashboard/');
echo "

<script type='text/javascript'>
	window.location.href = 'http://ambiente-desenvolvimento15.provisorio.ws/gomes/wordpress/dashboard/';
</script>


";

          else:
              $_SESSION['validation_error_message']='Credenciais Inválidas';
              echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
          endif;
      endif;
    endif;   
  endif;

  if(isset($_POST['submit_cadastrar'])):
    
    $cep_cadastrar = $_POST['cep_cadastrar'];
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
    elseif(empty($_POST['cep_cadastrar'])):
        $_SESSION['validation_error_message']='Preencha o campo CEP.';
        echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>"; 
    elseif(empty($_POST['senha_cadastrar'])):
      $_SESSION['validation_error_message']='Preencha o campo senha.';
      echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>"; 
    elseif(empty($_POST['confirmar_senha_cadastrar'])):
      $_SESSION['validation_error_message']='Preencha o campo confirmar senha.';
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
    elseif(email_exists(  $email_cadastrar )):
      $_SESSION['validation_error_message']='Este email já está em uso';
      echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
    else:
      $userdata = array(
        'user_login'  =>  $nome_cadastrar,
        'user_email'   =>  $email_cadastrar,
        'user_pass'   =>  $senha_cadastrar
    );
    
    $user_id = wp_insert_user( $userdata );
    add_user_meta( $user_id, 'cep_meta_key', $cep_cadastrar );
    add_user_meta( $user_id, 'nome_meta_key', $nome_cadastrar );
    add_user_meta( $user_id, 'telefone_meta_key', $telefone_cadastrar );
    add_user_meta( $user_id, 'estado_meta_key', $estado_cadastrar );
    add_user_meta( $user_id, 'cidade_meta_key', $cidade_cadastrar );
    add_user_meta( $user_id, 'bairro_meta_key', $bairro_cadastrar );
    add_user_meta( $user_id, 'rua_meta_key', $rua_cadastrar );
    add_user_meta( $user_id, 'numero_meta_key', $numero_cadastrar );
    add_user_meta( $user_id, 'complemento_meta_key', $complemento_cadastrar );
    add_user_meta( $user_id, 'cpf_meta_key', tirarCaracteresEspeciais($cpf_cadastrar));
    add_user_meta( $user_id, 'nascimento_meta_key', $nascimento_cadastrar );

    //LOGIN
    $_SESSION['loggedin'] = array(
      "ID"=>$user_id,
      "email"=>$email_entrar

    );
     //header('Location:http://ambiente-desenvolvimento15.provisorio.ws/gomes/wordpress/dashboard/');
echo "

<script type='text/javascript'>
	window.location.href = 'http://ambiente-desenvolvimento15.provisorio.ws/gomes/wordpress/dashboard/';
</script>


";
    endif;
   endif;// fim submit cadastro
?>


<div class='front_container'>


  <div class='forms' >
    <h2 class='entrarOuCadastrar'>Entre ou cadastre-se 🌴</h2>
    <div class='login'>
<form action='' method='POST'>
      <input placeholder='email' name='email_entrar' value='<?php echo (isset($_POST['email_entrar'])) ? $_POST['email_entrar'] : ""; ?>'></input>
      
      <input placeholder='senha' type='password' name='senha_entrar' ></input>
      
      <button id='submit_entrar' name='submit_entrar'>ENTRAR</button><br>
      <a href='<?php echo home_url( $wp->request )."/recuperar-senha"?>'>Esqueceu?</a>
</form>
    </div><br>
    <div class='register' >
      <form action='' method='post'>
          
          <input placeholder='nome' size='25' name='nome_cadastrar' value='<?php echo (isset($_POST['nome_cadastrar'])) ? $_POST['nome_cadastrar'] : ""; ?>'></input>
          <input placeholder='email' size='25' name='email_cadastrar' value='<?php echo (isset($_POST['email_cadastrar'])) ? $_POST['email_cadastrar'] : ""; ?>'></input><br>
          <input placeholder='senha' type='password' size='59' name='senha_cadastrar'></input><br>
          <input placeholder='confirmar senha' type='password' size='59' name='confirmar_senha_cadastrar'></input><br>
          <input placeholder='telefone' size='14' name="telefone_cadastrar" value='<?php echo (isset($_POST['telefone_cadastrar'])) ? $_POST['telefone_cadastrar'] : ""; ?>' onkeypress="mask(this, mphone);" onblur="mask(this, mphone);"></input>
          <input placeholder="CEP" name="cep_cadastrar" type="text" id="cep" value="" size="10" maxlength="9"
               onblur="pesquisacep(this.value);" /></label><br />
          <input placeholder='estado' id="uf" size='14' name='estado_cadastrar' value='<?php echo (isset($_POST['estado_cadastrar'])) ? $_POST['estado_cadastrar'] : ""; ?>'></input>
          <input placeholder='cidade' id="cidade" size='13' name='cidade_cadastrar' value='<?php echo (isset($_POST['cidade_cadastrar'])) ? $_POST['cidade_cadastrar'] : ""; ?>'></input><br>
          <input placeholder='bairro' id="bairro" size='25' name='bairro_cadastrar' value='<?php echo (isset($_POST['bairro_cadastrar'])) ? $_POST['bairro_cadastrar'] : ""; ?>'></input>
          <input placeholder='rua' size='25' id="rua" name='rua_cadastrar' value='<?php echo (isset($_POST['rua_cadastrar'])) ? $_POST['rua_cadastrar'] : ""; ?>'></input><br>
          <input placeholder='número' size='14' name='numero_cadastrar' value='<?php echo (isset($_POST['numero_cadastrar'])) ? $_POST['numero_cadastrar'] : ""; ?>'></input>
          <input placeholder='complemento' size='14' name='complemento_cadastrar' value='<?php echo (isset($_POST['complemento_cadastrar'])) ? $_POST['complemento_cadastrar'] : ""; ?>'></input>
          <input  maxlength="14" onblur="checar(this.value)" placeholder='cpf' id="CPF"  size='13' name='cpf_cadastrar' value='<?php echo (isset($_POST['cpf_cadastrar'])) ? $_POST['cpf_cadastrar'] : ""; ?>'></input><br>
          <!-- <input  placeholder='data de nascimento' size='59' maxlength="10" name='nascimento_cadastrar' value='<?php echo (isset($_POST['nascimento_cadastrar'])) ? $_POST['nascimento_cadastrar'] : ""; ?>' onkeypress="mascaraData(this)"></input><br> -->
          <input placeholder="data de nascimento" type="text" id="datepicker"  maxlength="10" name="nascimento_cadastrar" value="<?php  echo (isset($_POST['nascimento_cadastrar'])) ? $_POST['nascimento_cadastrar'] :"";?>">
          <button id='submit_cadastrar' name='submit_cadastrar'>CADASTRAR</button>
      </form>
    </div>
    <img src="<?php echo get_stylesheet_directory_uri(). '/assets/images/combo.png' ?>" width="200px" height="200">
  </div>
</div>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->

<script>
    // $(document).ready(function () { 
    //     var $seuCampoCpf = $("#CPF");
    //     $seuCampoCpf.mask('000.000.000-00', {reverse: true});
    // });
</script>
<script>
function mascaraData(val) {
  var pass = val.value;
  var expr = /[0123456789]/;

  for (i = 0; i < pass.length; i++) {
    // charAt -> retorna o caractere posicionado no índice especificado
    var lchar = val.value.charAt(i);
    var nchar = val.value.charAt(i + 1);

    if (i == 0) {
      // search -> retorna um valor inteiro, indicando a posição do inicio da primeira
      // ocorrência de expReg dentro de instStr. Se nenhuma ocorrencia for encontrada o método retornara -1
      // instStr.search(expReg);
      if ((lchar.search(expr) != 0) || (lchar > 3)) {
        val.value = "";
      }

    } else if (i == 1) {

      if (lchar.search(expr) != 0) {
        // substring(indice1,indice2)
        // indice1, indice2 -> será usado para delimitar a string
        var tst1 = val.value.substring(0, (i));
        val.value = tst1;
        continue;
      }

      if ((nchar != '/') && (nchar != '')) {
        var tst1 = val.value.substring(0, (i) + 1);

        if (nchar.search(expr) != 0)
          var tst2 = val.value.substring(i + 2, pass.length);
        else
          var tst2 = val.value.substring(i + 1, pass.length);

        val.value = tst1 + '/' + tst2;
      }

    } else if (i == 4) {

      if (lchar.search(expr) != 0) {
        var tst1 = val.value.substring(0, (i));
        val.value = tst1;
        continue;
      }

      if ((nchar != '/') && (nchar != '')) {
        var tst1 = val.value.substring(0, (i) + 1);

        if (nchar.search(expr) != 0)
          var tst2 = val.value.substring(i + 2, pass.length);
        else
          var tst2 = val.value.substring(i + 1, pass.length);

        val.value = tst1 + '/' + tst2;
      }
    }

    if (i >= 6) {
      if (lchar.search(expr) != 0) {
        var tst1 = val.value.substring(0, (i));
        val.value = tst1;
      }
    }
  }

  if (pass.length > 10)
    val.value = val.value.substring(0, 10);
  return true;
}
</script>
<script>
function mask(o, f) {
  setTimeout(function() {
    var v = mphone(o.value);
    if (v != o.value) {
      o.value = v;
    }
  }, 1);
}

function mphone(v) {
  var r = v.replace(/\D/g, "");
  r = r.replace(/^0/, "");
  if (r.length > 10) {
    r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
  } else if (r.length > 5) {
    r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
  } else if (r.length > 2) {
    r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
  } else {
    r = r.replace(/^(\d*)/, "($1");
  }
  return r;
}
</script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
  <script src="http://ambiente-desenvolvimento15.provisorio.ws/gomes/codeigniter/assets/js/datepicker-pt-BR.js"></script> 
  <script>
  $( function() {
    $("#datepicker").datepicker({ dateFormat: 'dd/mm/yy' });
    $('#datepicker').datepicker( $.datepicker.regional[ "hi" ] );
    $( "#datepicker" ).datepicker();
    var $seuCampoCpf = $("#CPF");
    $seuCampoCpf.mask('000.000.000-00', {reverse: true});
    
  } );
  </script>
  <script>
    function checar(cpf){
    	  if(!validarCPF(cpf)){
            //document.getElementById("resposta").style.display="inline-block";
            document.getElementById("CPF").value="INVALIDO";
        }
        
    
    }
   function validarCPF(cpf) {	
	cpf = cpf.replace(/[^\d]+/g,'');	
	if(cpf == '') return false;	
	// Elimina CPFs invalidos conhecidos	
	if (cpf.length != 11 || 
		cpf == "00000000000" || 
		cpf == "11111111111" || 
		cpf == "22222222222" || 
		cpf == "33333333333" || 
		cpf == "44444444444" || 
		cpf == "55555555555" || 
		cpf == "66666666666" || 
		cpf == "77777777777" || 
		cpf == "88888888888" || 
		cpf == "99999999999")
			return false;		
	// Valida 1o digito	
	add = 0;	
	for (i=0; i < 9; i ++)		
		add += parseInt(cpf.charAt(i)) * (10 - i);	
		rev = 11 - (add % 11);	
		if (rev == 10 || rev == 11)		
			rev = 0;	
		if (rev != parseInt(cpf.charAt(9)))		
			return false;		
	// Valida 2o digito	
	add = 0;	
	for (i = 0; i < 10; i ++)		
		add += parseInt(cpf.charAt(i)) * (11 - i);	
	rev = 11 - (add % 11);	
	if (rev == 10 || rev == 11)	
		rev = 0;	
	if (rev != parseInt(cpf.charAt(10)))
		return false;		
	return true;   
}
    </script>
    <!-- Adicionando Javascript -->
    <script>
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
            //document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
            //document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";
                //document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>
              <div id='kart' class='kart' title='MEU CARRINHO'><a href='$home/finalizar-pedido'>🛒</a><br>
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