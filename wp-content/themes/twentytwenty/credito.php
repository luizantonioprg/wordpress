<?php
/**
 * Template Name: Credito

 */
$home = home_url();
get_header();
session_start();
if(!isset($_SESSION['loggedin'])):
  header("Location:$home");
endif;

//echo $_SESSION['valor_credito'];
//echo $_SESSION['valor_credito'];
//echo  $_SESSION['carrinho'];

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



<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php

  require_once 'vendor/autoload.php';

  MercadoPago\SDK::setAccessToken("XXXXXXXXXx");


  $payment = new MercadoPago\Payment();
  $payment->transaction_amount = (float)$_POST['transactionAmount'];
  $payment->token = $_POST['token'];
  $payment->description = $_POST['description'];
  $payment->installments = (int)$_POST['installments'];
  $payment->payment_method_id = $_POST['paymentMethodId'];
  $payment->issuer_id = 18;

  $payer = new MercadoPago\Payer();
  $payer->email = $_POST['email'];
  $payer->identification = array(
      "type" => $_POST['docType'],
      "number" => $_POST['docNumber']
  );
  $payment->payer = $payer;

  $payment->save();

  $response = array(
      'status' => $payment->status,
      'status_detail' => $payment->status_detail,
      'id' => $payment->id
  );

  if($response['status'] == "approved"):
    //setcookie("LIMPARTELA",true);
	$_SESSION['LIMPARTELA'] = true;
    global $wpdb;
      
    $sql = 'INSERT INTO `wp_pagamentos`(email_cliente,cep_cliente,rua_cliente,bairro_cliente,cpf_cliente,complemento_cliente,cidade_cliente,estado_cliente,status,tipo,carrinho,total_carrinho,id_cliente) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)';
    $resp = $wpdb->query($wpdb->prepare($sql, array($_POST['email'],$_POST['cep'],$_POST['rua'],$_POST['bairro'],$_POST['docNumber'],$_POST['complemento'],$_POST['cidade'],$_POST['estado'],'APROVADO','CRÉDITO',$_POST['carrinho'],$_POST['total_carrinho'],$_POST['id_cliente'])));

    echo '<h1>Pagamento Aprovado</h1>';
  endif;
  //echo json_encode($response);
  //echo $response->status;
  


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
        echo $string;
    }

    



?>
<?php if(!isset($_SESSION['LIMPARTELA'])): ?>
	<form action="" method="post" id="paymentForm">
        <input type="hidden" name='id_cliente' value='<?php echo $_SESSION['loggedin']['ID'];?>'></input>
        <input type='hidden' name='carrinho' value='<?php echo $_SESSION['carrinho']?>'>
        <input type='hidden' name='total_carrinho' value='<?php echo $_SESSION['valor_credito']?>'>
        
    <div style='border:solid 1px black;'>
        <h3>Dados Essenciais</h3>
        <label>Primeiro Nome<br>
        <input required type='text' name='first_name' value='<?php echo (isset($_POST['first_name'])) ? $_POST['first_name'] : $nomeUsuario; ?>'></input><br>
        <!-- <label>Ultimo Nome<br> -->
        <input  type='hidden' name='last_name' value='<?php echo (isset($_POST['last_name'])) ? $_POST['last_name'] : "user"; ?>'></input><br>
        <label>Cep:<br>
        <input required name="cep" type="text" id="cep"  maxlength="9"
               onblur="pesquisacep(this.value);" value='<?php echo (isset($_POST['cep'])) ? $_POST['cep'] : $cep; ?>' /></label><br />
        <label>Rua:<br>
        <input required name="rua" type="text" id="rua" value='<?php echo (isset($_POST['rua'])) ? $_POST['rua'] : $rua; ?>' /></label><br />
        <label>Bairro:<br>
        <input required name="bairro" type="text" id="bairro"  value='<?php echo (isset($_POST['bairro'])) ? $_POST['bairro'] : $bairro; ?>'/></label><br />
        <label>Cidade:<br>
        <input required name="cidade" type="text" id="cidade" value='<?php echo (isset($_POST['cidade'])) ? $_POST['cidade'] : $cidade; ?>' /></label><br />
        <label>Estado:<br>
        <input required name="estado" type="text" id="uf" value='<?php echo (isset($_POST['estado'])) ? $_POST['estado'] : $estado; ?>'/></label><br />
        <label>Número</label><br>
        <input type='text' name='numero' value='<?php echo (isset($_POST['numero'])) ? $_POST['numero'] : $numero; ?>'><br>
        <label>Complemento</label><br>
        <input type='text' name='complemento' value='<?php echo (isset($_POST['complemento'])) ? $_POST['complemento'] : $complemento; ?>'>
    </div>
   <h3>Detalhe do comprador</h3>
     <div>
       <div>
         <label for="email" maxlength="50">E-mail</label>
         <input required id="email" name="email" type="text" maxlength="50"/>
       </div>
       <div>
         <label for="docType">Tipo de documento</label>
         <select id="docType" name="docType" data-checkout="docType" type="text"></select>
       </div>
       <div>
         <label for="docNumber">Número do documento</label>
         <input required id="docNumber" maxlength="14" onblur="checar(this.value)" name="docNumber" data-checkout="docNumber" type="text" value='<?php echo (isset($_POST['docNumber'])) ? $_POST['docNumber'] : $cpf ?>' />
         <!-- <input type='text' name="docNumber" value='<?php tirarCaracteresEspeciais($cpf) ?>'> -->
       </div>
     </div>
   <h3>Detalhes do cartão</h3>
     <div>
       <div>
         <label for="cardholderName">Titular do cartão</label>
         <input required id="cardholderName" data-checkout="cardholderName" type="text" maxlength="30">
       </div>
       <div>
         <label for="">Data de vencimento</label>
         <div>
           <input required type="text" placeholder="MM" id="cardExpirationMonth" data-checkout="cardExpirationMonth"
             onselectstart="return false" onpaste="return false"
             oncopy="return false" oncut="return false"
             ondrag="return false" ondrop="return false" autocomplete=off>
           <span class="date-separator">/</span>
           <input required type="text" placeholder="YY" id="cardExpirationYear" data-checkout="cardExpirationYear"
             onselectstart="return false" onpaste="return false"
             oncopy="return false" oncut="return false"
             ondrag="return false" ondrop="return false" autocomplete=off>
         </div>
       </div>
       <div>
         <label for="cardNumber">Número do cartão</label>
         <input required maxlength="30" type="text" id="cardNumber" data-checkout="cardNumber"
           onselectstart="return false" onpaste="return false"
           oncopy="return false" oncut="return false"
           ondrag="return false" ondrop="return false" autocomplete=off>
       </div>
       <div>
         <label for="securityCode">Código de segurança</label>
         <input required maxlength="4" id="securityCode" data-checkout="securityCode" type="text"
           onselectstart="return false" onpaste="return false"
           oncopy="return false" oncut="return false"
           ondrag="return false" ondrop="return false" autocomplete=off>
       </div>
       <div id="issuerInput">
         <label for="issuer">Banco emissor</label>
         <select id="issuer" name="issuer" data-checkout="issuer"></select>
       </div>
       <div>
         <label for="installments">Parcelas</label>
         <select type="text" id="installments" name="installments"></select>
       </div>
       <div>
         <input type="hidden" name="transactionAmount" id="transactionAmount" value="100" />
         <input type="hidden" name="paymentMethodId" id="paymentMethodId" />
         <input type="hidden" name="description" id="description" />
         <br>
         <button type="submit" name='submit_pagar_credito'>Pagar</button>
         <br>
       </div>
   </div>
 </form>
<?php endif; ?>
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
<script>
	
	window.Mercadopago.setPublishableKey("TEST-d03d0e78-fa4a-4066-8bff-fd8f7cca84b4");
	window.Mercadopago.getIdentificationTypes();
	document.getElementById('cardNumber').addEventListener('change', guessPaymentMethod);

	function guessPaymentMethod(event) {
	   let cardnumber = document.getElementById("cardNumber").value;
	   if (cardnumber.length >= 6) {
	       let bin = cardnumber.substring(0,6);
	       window.Mercadopago.getPaymentMethod({
	           "bin": bin
	       }, setPaymentMethod);
	   }
	};

	function setPaymentMethod(status, response) {
	   if (status == 200) {
	       let paymentMethod = response[0];
	       document.getElementById('paymentMethodId').value = paymentMethod.id;

	       getIssuers(paymentMethod.id);
	   } else {
	       alert(`payment method info error: ${response}`);
	   }
	}

	function getIssuers(paymentMethodId) {
   	window.Mercadopago.getIssuers(
       paymentMethodId,
       setIssuers
	   );
	}

	function setIssuers(status, response) {
	   if (status == 200) {
	       let issuerSelect = document.getElementById('issuer');
	       response.forEach( issuer => {
	           let opt = document.createElement('option');
	           opt.text = issuer.name;
	           opt.value = issuer.id;
	           issuerSelect.appendChild(opt);
	       });

	       getInstallments(
	           document.getElementById('paymentMethodId').value,
	           document.getElementById('transactionAmount').value,
	           issuerSelect.value
	       );
	   } else {
	       alert(`issuers method info error: ${response}`);
	   }
	}

	function getInstallments(paymentMethodId, transactionAmount, issuerId){
   	window.Mercadopago.getInstallments({
       "payment_method_id": paymentMethodId,
       "amount": parseFloat(transactionAmount),
       "issuer_id": parseInt(issuerId)
	   }, setInstallments);
	}

	function setInstallments(status, response){
	   if (status == 200) {
	       document.getElementById('installments').options.length = 0;
	       response[0].payer_costs.forEach( payerCost => {
	           let opt = document.createElement('option');
	           opt.text = payerCost.recommended_message;
	           opt.value = payerCost.installments;
	           document.getElementById('installments').appendChild(opt);
	       });
	   } else {
	       alert(`installments method info error: ${response}`);
	   }
	}
	doSubmit = false;
	document.getElementById('paymentForm').addEventListener('submit', getCardToken);
	function getCardToken(event){
	   //event.preventDefault();
	   if(!doSubmit){
	       let $form = document.getElementById('paymentForm');
	       window.Mercadopago.createToken($form, setCardTokenAndPay);
	       return false;
	   }
	};

	function setCardTokenAndPay(status, response) {
	   if (status == 200 || status == 201) {
	       let form = document.getElementById('paymentForm');
	       let card = document.createElement('input');
	       card.setAttribute('name', 'token');
	       card.setAttribute('type', 'hidden');
	       card.setAttribute('value', response.id);
	       form.appendChild(card);
	       doSubmit=true;
	       form.submit();
	   } else {
	       alert("Verify filled data!\n"+JSON.stringify(response, null, 4));
	   }
	};
</script>
</body>
</html>







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
       // var $seuCampoCpf = $("#docNumber");
        //$seuCampoCpf.mask('000.000.000-00', {reverse: true});
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
<script>
    $(document).ready(function () { 
        var $seuCampoCpf = $("#docNumber");
        $seuCampoCpf.mask('000.000.000-00', {reverse: true});


        
        if (
		(value_or_null = (document.cookie.match(
			/^(?:.*;)?\s*LIMPARTELA\s*=\s*([^;]+)(?:.*)?$/
		) || [, null])[1])
	) {
		document.getElementById("paymentForm").style.display="none";

        var cookies = document.cookie.split(";");

            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i];
                var eqPos = cookie.indexOf("=");
                var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
                document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
            }
            localStorage.clear();
	}
    });
</script>
<script>
    function checar(cpf){
    	  if(!validarCPF(cpf)){
            //document.getElementById("resposta").style.display="inline-block";
            document.getElementById("docNumber").value="INVALIDO";
        }else{
          let cpf_com_ponto_e_traco = cpf;
          let cpf_sem_ponto_e_traco = cpf_com_ponto_e_traco.replace(".", "").replace(".", "").replace("-", "");

          document.getElementById("docNumber").value=cpf_sem_ponto_e_traco;
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