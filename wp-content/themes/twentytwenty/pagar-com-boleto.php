<?php

get_header();

session_start();
$home = home_url();
// echo $_SESSION['valor_boleto'];
// echo $_SESSION['carrinho'];

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
$cep = get_user_meta( $user_id, 'cep_meta_key', true);
?>

<div class='container_boleto'>
<?php
if(isset($_POST['pagar_boleto'])):
  if(empty($_POST['email']) || empty($_POST['first_name']) || empty($_POST['cpf']) || empty($_POST['cep']) || empty($_POST['rua']) || empty($_POST['bairro']) || empty($_POST['cidade']) || empty($_POST['estado'])):
    $_SESSION['validation_error_message']='Você deve preencher todos os campos antes de enviar o formulário';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
 
    
  elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)):
    $_SESSION['validation_error_message']='Formato de email inválido';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
  elseif(strlen($_POST['email']) > 50):
    $_SESSION['validation_error_message']='Email maior que 50 caracteres';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
  elseif(strlen($_POST['first_name']) > 50):
    $_SESSION['validation_error_message']='Primeiro Nome maior que 50 caracteres';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
  elseif(strlen($_POST['last_name']) > 50):
    $_SESSION['validation_error_message']='Ultimo Nome maior que 50 caracteres';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
  elseif(strlen($_POST['cpf']) > 50):
    $_SESSION['validation_error_message']='Digite apenas 12 digitos no CPF';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
  elseif(strlen($_POST['cep']) > 9):
    $_SESSION['validation_error_message']='CEP muito grande';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";
  elseif(strlen($_POST['rua']) > 50):
    $_SESSION['validation_error_message']='Rua maior que 50 caracteres';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";    
  elseif(strlen($_POST['bairro']) > 50):
    $_SESSION['validation_error_message']='Bairro maior que 50 caracteres';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";   
  elseif(strlen($_POST['cidade']) > 50):
    $_SESSION['validation_error_message']='Cidade maior que 50 caracteres';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>"; 
  elseif(strlen($_POST['estado']) > 50):
    $_SESSION['validation_error_message']='Estado maior que 50 caracteres';
    echo "<div class='validation_error'>".$_SESSION['validation_error_message']."</div>";       
  else:



 require_once 'vendor/autoload.php';

 MercadoPago\SDK::setAccessToken("XXXXXXXx");
  

    $payment = new MercadoPago\Payment();
    $payment->transaction_amount = $_POST['total_carrinho'];
    $payment->description = "Título do produto";
    $payment->payment_method_id = "bolbradesco";
    $payment->payer = array(
        "email" => "test_user_7831422@testuser.com",
        "first_name" => "User",
        "last_name" => "User",
        "identification" => array(
            "type" => "CPF",
            "number" => "19119119100"
          ),
        "address"=>  array(
            "zip_code" => "06233200",
            "street_name" => "Av. das Nações Unidas",
            "street_number" => "3003",
            "neighborhood" => "Bonfim",
            "city" => "Osasco",
            "federal_unit" => "SP"
          )
      );

      $payment->save();
      $link = json_encode($payment->transaction_details->external_resource_url);
            // salva
            global $wpdb;
     
            $sql = 'INSERT INTO `wp_pagamentos`(email_cliente,cep_cliente,rua_cliente,bairro_cliente,cpf_cliente,complemento_cliente,cidade_cliente,estado_cliente,status,tipo,carrinho,total_carrinho,id_cliente) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)';
            $resp = $wpdb->query($wpdb->prepare($sql, array($_POST['email'],$_POST['cep'],$_POST['rua'],$_POST['bairro'],$_POST['cpf'],$_POST['complemento'],$_POST['cidade'],$_POST['estado'],'PENDENTE','BOLETO',$_POST['carrinho'],$_POST['total_carrinho'],$_POST['id_cliente'])));

      //echo "<h3>LINK:".$link."</h3>";
      echo "<a href=$link target='blank'>PAGAR</a>";
      //setcookie("LIMPARTELA",true);
     
     // echo "<script>window.open($link,'_blank')</script>";
$_SESSION['LIMPARTELA'] = true;
//print_r($_COOKIE);

        endif;
      endif;



?>
<?php if(!isset($_SESSION['LIMPARTELA'])): ?>
  <form method='post' action='' id="formulario">
        <input type="hidden" name='id_cliente' value='<?php echo $_SESSION['loggedin']['ID'];?>'></input>
        <input type='hidden' name='carrinho' value='<?php echo $_SESSION['carrinho']?>'>
        <input type='hidden' name='total_carrinho' value='<?php echo $_SESSION['valor_boleto']?>'>
        <label>Email<br>
        <input type='text' name='email' value='<?php echo (isset($_POST['email'])) ? $_POST['email'] : $user_email; ?>'></input><br>
        <label>Primeiro Nome<br>
        <input type='text' name='first_name' value='<?php echo (isset($_POST['first_name'])) ? $_POST['first_name'] : $nomeUsuario; ?>'></input><br>
        <!-- <label>Ultimo Nome<br>-->
        <input type='hidden' name='last_name' value='user'></input><br> 
        <label>CPF<br>
        <input maxlength="14" onblur="checar(this.value)" type='text' name='cpf' id='CPF' value='<?php echo (isset($_POST['cpf'])) ? $_POST['cpf'] : $cpf; ?>'></input><br>



        <label>Cep:<br>
        <input name="cep" type="text" id="cep"  maxlength="9"
               onblur="pesquisacep(this.value);" value='<?php echo (isset($_POST['cep'])) ? $_POST['cep'] : $cep; ?>' /></label><br />
        <label>Rua:<br>
        <input name="rua" type="text" id="rua" value='<?php echo (isset($_POST['rua'])) ? $_POST['rua'] : $rua; ?>' /></label><br />
        <label>Bairro:<br>
        <input name="bairro" type="text" id="bairro"  value='<?php echo (isset($_POST['bairro'])) ? $_POST['bairro'] : $bairro; ?>'/></label><br />
        <label>Cidade:<br>
        <input name="cidade" type="text" id="cidade" value='<?php echo (isset($_POST['cidade'])) ? $_POST['cidade'] : $cidade; ?>' /></label><br />
        <label>Estado:<br>
        <input name="estado" type="text" id="uf" value='<?php echo (isset($_POST['estado'])) ? $_POST['estado'] : $estado; ?>'/></label><br />
        <label>Número</label><br>
        <input type='text' name='numero' value='<?php echo (isset($_POST['numero'])) ? $_POST['numero'] : $numero; ?>'><br>
        <label>Complemento</label><br>
        <input type='text' name='complemento' value='<?php echo (isset($_POST['complemento'])) ? $_POST['complemento'] : $complemento; ?>'><br>
        <!-- <label>IBGE:
        <input name="ibge" type="text" id="ibge" size="8" /></label><br /> -->
        <button type='submit' name='pagar_boleto'>PAGAR</button>
  </form>
</div>
<?php endif; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
<script>
    $(document).ready(function () { 
if (!<?php echo $_SESSION['LIMPARTELA']; ?>) {
  alert("session");
} else {
<?php unset($_SESSION['LIMPARTELA']);?>
var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
    localStorage.clear();
}
        var $seuCampoCpf = $("#CPF");
        $seuCampoCpf.mask('000.000.000-00', {reverse: true});

 
    });
</script>

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