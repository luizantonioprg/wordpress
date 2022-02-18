<?php
  session_start();
  //get_header();
  $home = home_url();

  $post_id = get_the_ID();
  //$post_title = the_title();
  $post_type = get_post_type(get_the_ID());
  $post_content = get_post_field('post_content', $post_id);
  

  if($post_type == 'produtos'):
    echo "  <input id='post_id' type='hidden' value='$post_id'></input>";
		$arrayDaCategoria = get_the_terms( get_the_ID() , 'categorias' );
		foreach($arrayDaCategoria as $items):
			$categoriaAtual =  $items->name;
		endforeach;

		
    $term = get_term_by( 'name', $categoriaAtual, 'categorias');
    $term_image = get_term_meta( $term->term_id, '_category_image', true);
    //echo "<img src='$term_image'>"; 
   




  else:
    // a taxonomia vai ser outra, vai ser a dos posts do blog. Codigo igual o de cima, só mudar nome.
    $category_detail=get_the_category($post_id);//$post->ID
   
    foreach($category_detail as $cd){
      $link = get_term_link(  $cd->cat_ID,'category');
      $category =  $cd->cat_name;
     
    }
  endif;

?>
<!-- INÍCIO HEADER ESTÁTICO -->

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
    <title>Integra</title>
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
                  // just get IDs rather than whole post object - more efficient
                  // as you only require the title
                  // $post_ids = new WP_Query(array(
                  //     'post_type' => 'produtos', // replace with CPT name
                  //     'fields' => 'ids',
                  //     'orderby' => 'ID',
                  //     'order' => 'desc'
                  //     //'meta_key' => 'surname_field_name' // replace with custom field name
                  // ));

                  // $post_titles = array();

                  // // go through each of the retrieved ids and get the title
                  // if ($post_ids->have_posts()):
                  //     foreach( $post_ids->posts as $id ):
                  //         $post_titles += array(apply_filters('the_title', get_the_title($id))=>$id);
                  //     endforeach;
                  // endif;

                  // foreach($post_titles as $title => $id):
                  //     echo "<a href='".get_permalink($id)."'>$title</a>";
                  // endforeach;
              ?>

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

      <div class="dropdown">
 	<a style='color:white;text-decoration:none;' href='<?php echo home_url()."/cadastro-ou-login"?>'>
        	<button class="dropbtn">LOGIN</button>
	</a>
        <!-- <div class="dropdown-content">
          <a href="#">Link 1</a>
          <a href="#">Link 2</a>
          <a href="#">Link 3</a>
        </div> -->
      </div>

  </div>
</div>
<!-- FIM HEADER ESTÁTICO -->
<h5 class='titulo_categoria'>      
  <?php 
  if($post_type !== 'produtos'):
     echo "<a href='$link'>$category</a>";;
  else:
    the_category_colors($categoriaAtual);
  endif;
  ?>
</h5>
  <h1 class='titulo_post' id='o_titulo'><?php the_title()?></h1>

<div class='container_post'>
    <?php 
        echo get_the_post_thumbnail( $post_id);  
        $content = apply_filters('the_content',$post_content);
        echo $content;

        if(isset($_SESSION['loggedin'])):
          if($post_type =='produtos'):
            $preço =  get_post_meta( $post_id, '_valor_meta_key')[0];
            $desconto = get_post_meta( $post_id, '_desconto_meta_key')[0];
            
           
            if($desconto !== ""):
              $valor_final = number_format($preço - $desconto, 2);
              echo "<h4>De <span style='text-decoration: line-through;'>R$$preço</span> por $valor_final</h4>";
            else:
              echo "<h4>$preço</h4>";
            endif;
$hash = md5(uniqid(rand(), true));
echo "<input id='preco' type='hidden' value='$valor_final'></input>
<label>*Para ajustar novamente a quantidade, remova do carrinho, ajuste e adicione novamente.</label><br>
";
 
            
echo "
            <label for='qty'>Quantidade:</label>
            <button class='qtyminus' aria-hidden='true'>&minus;</button>
            <input type='number' name='qty' id='qty' min='1' max='10' step='1' value='1'>
            <button class='qtyplus' aria-hidden='true'>&plus;</button>
          
            ";
 echo "<button id='$hash' class='add_carrinho' onclick='adicionar_ao_carrinho(this.id)'>Adicionar ao carrinho 🛒</button>";
//tirei aqui
             
            
           
            
          
          endif;
        endif;
    ?>
    
</div>
              <div id='kart' class='kart' title='MEU CARRINHO'><a href='<?php $home = home_url();echo "$home/finalizar-pedido"?>'>🛒</a><br>
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
<script>
/*
* @Adilade Input Quantity Increment
* 
* Free to use - No warranty
*/

var input = document.querySelector('#qty');
var btnminus = document.querySelector('.qtyminus');
var btnplus = document.querySelector('.qtyplus');

if (input !== undefined && btnminus !== undefined && btnplus !== undefined && input !== null && btnminus !== null && btnplus !== null) {
	
	var min = Number(input.getAttribute('min'));
	var max = Number(input.getAttribute('max'));
	var step = Number(input.getAttribute('step'));

	function qtyminus(e) {
		var current = Number(input.value);
		var newval = (current - step);
		if(newval < min) {
			newval = min;
		} else if(newval > max) {
			newval = max;
		} 
		input.value = Number(newval);
		e.preventDefault();
    $titulo_produto = "PROD_"+document.getElementById("o_titulo").innerHTML;
    $preco_produto = document.getElementById("preco").value;
    $subtraido = localStorage.getItem($titulo_produto) - $preco_produto;
    console.log($subtraido);


  
    localStorage.setItem($titulo_produto,  $subtraido);

    $qnt = document.getElementById("qty").value;
    localStorage.setItem($quantidade,  $qnt);
	}

	function qtyplus(e) {

		var current = Number(input.value);
		var newval = (current + step);
		if(newval > max) newval = max;
		input.value = Number(newval);
		e.preventDefault();
    $preco_produto = document.getElementById("preco").value;
    $multiplicado = $preco_produto * newval;
    console.log($multiplicado);

    $titulo_produto = "PROD_"+document.getElementById("o_titulo").innerHTML;
    localStorage.setItem($titulo_produto,  $multiplicado);

    $qnt = document.getElementById("qty").value;
    localStorage.setItem($quantidade,  $qnt);
	}
		
	btnminus.addEventListener('click', qtyminus);
	btnplus.addEventListener('click', qtyplus);
  
} // End if test


</script>