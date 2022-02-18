<!-- INÍCIO DO HEADER ESTATICO -->
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
    <title>
	<?php
		if(!empty(get_the_archive_title())):
			echo get_the_archive_title();
		else:
			echo "Categoria > Produtos";
		endif;
	?>

    </title>
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
<!-- FIM DO HEADER ESTATICO -->
<?php
/**
 * Template Name: Posts-Categoria

 */
//get_header();
// echo get_the_archive_title()."<br>";
$nomeCategoriaAtual = get_the_archive_title();



$term_info = get_term_by('name', $nomeCategoriaAtual,'category');// se for post
if($term_info == ""):
  $term_info = get_term_by('name', $nomeCategoriaAtual,'categorias');// se for produto
endif;

$term_info_id = $term_info->term_id;
$term2 = get_term( $term_info_id );
$taxonomiaAtual = $term2->taxonomy;// taxonomia do termo(categoria) atual


$arrayDaCategoriaAtual = get_term_by('name', $nomeCategoriaAtual, $taxonomiaAtual);

$term_vals = get_term_meta($term_info_id);
// foreach($term_vals as $key=>$val){
//    echo $key . ' : ' . $val[0] . '<br/>';
//     $cor_categoria = $val[1];
// }

$cor_categoria = $term_vals['_category_color'][0];
$imagem_categoria = $term_vals['_category_image'][0];

$out = wpse_172645_get_post_types_by_taxonomy( $taxonomiaAtual);
$postTypeDaTaxonomiaAtual = $out[0];
$pages = get_posts(array(
  'post_type' => $postTypeDaTaxonomiaAtual,
  'numberposts' => -1,
  'tax_query' => array(
    array(
      'taxonomy' => $taxonomiaAtual,
      'field' => 'term_id', 
      'terms' => $term_info_id, /// Where term_id of Term 1 is "1".
      'include_children' => false
    )
  )
));


?>
<div class='cabecalho_categoria' style="background-color:#<?php echo $cor_categoria;?>">
  <img class='imagem_categoria' src="<?php echo $imagem_categoria; ?>">
  <h1 class='titulo_categoria_integra' ><?php echo $nomeCategoriaAtual?></h1>
</div>

<ul class='lista'>
<?php 

for($i = 0;$i<sizeof($pages);$i++):

  // echo $pages[$i]->post_name;
  // echo the_excerpt();
  //echo $pages[$i]->guid;
  echo "
    <li>
      <a href='".$pages[$i]->guid."'>".$pages[$i]->post_name."</a>
    </li>";
    echo "<p>".the_excerpt()."</p>";
endfor;
?>
</ul>
              <div id='kart' class='kart' title='MEU CARRINHO'><a href="<?php $home=home_url();echo $home.'/finalizar-pedido';?>">🛒</a><br>
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