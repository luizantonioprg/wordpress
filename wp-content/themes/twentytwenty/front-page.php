
<?php 
  session_start();
  if(isset($_SESSION['loggedin'])):
    header("Location:$home.'/dashboard'");
  endif;
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
<h3 class='titulo_home'>PRODUTOS 😋</h3>
<div class='container_p'>

  <?php
$args = array(
  'post_type'=> 'produtos',
  'orderby'    => 'ID',
  'post_status' => 'publish',
  'order'    => 'DESC',
  'posts_per_page' => -1 // this will retrive all the post that is published 
  );
  $result = new WP_Query( $args );
  if ( $result-> have_posts() ) : ?>
  <?php while ( $result->have_posts() ) : $result->the_post(); ?>
  <?php 
  
    echo "
    

      <div class='card'>";
      echo get_the_post_thumbnail(get_the_id());
    
    echo "<div class='container'>
      <h4><a href='".get_permalink()."'><b>".get_the_title()."</b></a></h4> 
      <p>".get_the_excerpt()."</p> 
    </div>
  </div>
    
    
    
    ";
    
   // the_excerpt();
    //$id = the_id();
     
    // echo  get_permalink();
  ?>   
  
  <?php endwhile; ?>
  <?php endif; wp_reset_postdata(); 

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

