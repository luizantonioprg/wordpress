<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
  <head>




 
  

    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/jquery-ui.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/header.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/front_page.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/recuperar-senha.css' ?>">
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/singular.css' ?>"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/single_post.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/scrollbar.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/dashboard.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/blog.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/redefinir-senha.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/integra_categorias.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/carrinho.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/finalizar-pedido.css' ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/assets/css/boleto.css' ?>">

    <title><?php echo get_the_title(); ?></title>


  </head>
<body>

<div class="wavy-frame"></div>
<div class='container-menu'>
  <a href='<?php echo home_url()?>'>
    <img src="<?php echo get_stylesheet_directory_uri(). '/assets/images/logo.png' ?>" width="300px">
  </a>
  <div class='nav'>
      <div class="dropdown">
        <button class="dropbtn">CARDÁPIO</button>
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
              echo "<a href='#'>$term->name</a>";;
              endforeach;

              ?>
        </div>
      </div>
<?php
    if(!isset($_SESSION['loggedin'])):
        echo "
          <div class='dropdown'>
            <button class='dropbtn'>
              <a style='color:white;text-decoration:none;' href='";
              echo home_url().'/blog';
              echo "'>BLOG</a>
            </button>
            <div class='dropdown-content'>";
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
            echo "</div>
          </div>


        ";
        

    endif;
     
?>
<?php 
  if(isset($_SESSION['loggedin'])):
    echo "
    <div class='dropdown'>
        <button class='dropbtn'>
          <a style='color:white;text-decoration:none;' href='<?php echo home_url().'/blog'?>OPÇÕES</a>
        </button>
          <div class='dropdown-content'>
            <a href='";
             echo home_url()."/editar-dados'>EDITAR DADOS</a>
            <form method='post' action=''>
              <a href='#'><button style='background:none;border:none;font-family:Arial;' type='submit' name='sair'>LOGOUT</button></a>
            </form>
    
    ";

    $home = home_url();
    if(isset($_POST['sair'])):
      
      unset($_SESSION['loggedin']);
      session_destroy();
      echo "<script>window.location='".$home."'</script>";
      //header("Location:$home");
echo "
?>
<script type='text/javascript'>
window.location.href = '".$home."';
</script>
<?php
";
    endif;
  endif;

  echo "
          
  </div>
  </div>
  

</div>
</div>

  ";
?>
      
            



