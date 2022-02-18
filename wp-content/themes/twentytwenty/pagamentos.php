<?php
/**
 * Template Name: Pagamentos

 */
get_header();
session_start();
$home = home_url();


?>
<style>
#tabelaPagamentos table td,th{
  border: 1px black solid;
padding: 10px;
text-align: center;
font-family: Arial, Helvetica, sans-serif;
}

</style>
<?php
global $wpbd;
$sql = 'SELECT * FROM `wp_pagamentos` WHERE `id_cliente` = %s';
$sql = $wpdb->prepare($sql, array($_SESSION['loggedin']['ID']));
$res = $wpdb->get_results($sql);



?>
<h1>Meus Pagamentos Recentes</h1>
<table id='tabelaPagamentos'>
    <thead>
      <tr>
        <th>TIPO</th>
        <th>VALOR</th>
        <th>ITEMS</th>
        <th>STATUS</th>
        <th>REFAZER</th>
      </tr>
    </thead>
    <tbody>
      <?php
          foreach($res as $item):
      ?>
      <tr>
        <td><?php echo $item->tipo?></td>
        <td>R$ <?php echo number_format((float)$item->total_carrinho, 2, '.', '');?></td>
        <td><?php echo $item->carrinho?></td>
        <td><?php echo $item->status?></td>
        <td>
            <form action='' method='post'>
              <input type='hidden' name='valor' value='<?php echo number_format((float)$item->total_carrinho, 2, '.', '');?>'>
              <input type='hidden' name='metodo' value='<?php echo $item->tipo;?>'>

              <input type='hidden' name='carrinho' value='<?php echo $item->carrinho;?>'>
             

              <button type='submit' name='submit_refazer'>PAGAR NOVAMENTE</button>
            </form>

        </td>
      </tr>
      <?php
          endforeach;
      ?>
             
</table>
<?php
 $home = home_url();
  if(isset($_POST['submit_refazer'])):
    if($_POST['metodo'] == "BOLETO"):

      $_SESSION['valor_boleto'] = $_POST['valor'];
      $_SESSION['carrinho'] = $_POST['carrinho'];
      echo "
      <script type='text/javascript'>
      window.location.href = '".$home.'/boleto'."';
      </script>

      ";
    elseif($_POST['metodo'] == "CRÉDITO"):
      echo "
      <script type='text/javascript'>
      window.location.href = '".$home.'/credito'."';
      </script>

      ";
    else:
      echo "
      <script type='text/javascript'>
      window.location.href = '".$home.'/pix'."';
      </script>

      ";
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
