
<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
<?php
  if(!isset($_SESSION['loggedin'])){
    redirect('/');
  }
  foreach($estacionamento as $item):
    $datas = explode(',',$item->datas);
  
    if(isset($data_escolhida)):
      echo "<input type='hidden' id='data_escolhida' value='$data_escolhida'></input>";
    endif;

?>

<div class="containerGeralIntegra">
<input type='hidden' value='<?php echo $_SESSION['loggedin']['id']?>'></input>
  <div class="containerDados">

    <div class="containerEstacionamento">
      <div class="containerImagemEstacionamento">
          <h3><?php echo $item->titulo;?></h3>
          <img src="<?php echo base_url().'uploads/'.$item->imagem?>">
      </div>
      <div class="containerInfoEstacionamento">
        <h4>Vagas diárias: <?php echo $item->numero_vagas;?></h4>
        <h4>Email: <?php echo $item->email;?></h4>
        <h4>CEP: <?php echo $item->cep;?></h4>
        <h4>Endereço: <?php echo $item->rua.", ".$item->numero." - ".$item->bairro."( ".$item->cidade." / ".$item->uf." )";?></h4>
      </div>
    </div>

  </div>
  <div class="containerReserva">
    <div class='headerContainerReserva'>
        <h4>Selecione uma data para verificar a disponibilidade</h4>
        <div class='containerDatas' id='containerDatas'>
          <?php
            for($i=0;$i<sizeof($datas);$i++):
              echo "<div class='data' id='data$i'onclick='disponivel(this.innerText,this.id)'><h4>".$datas[$i]."<h4></div>";
            endfor;
          ?>
          
        </div>
    </div>
    <div class='containerReservaForm' id='containerReservaForm'>
          <div>
              <form class='formulario_reserva' id='formulario_reserva' method="post" action="<?php echo base_url(); ?>reservas/reservar">
                    <div class='erroRe'>
                    <?php echo validation_errors("<h4 style='color:red'>","</h4>")?>
                    </div>
                    
                    <input value='<?php echo set_value('cpf'); ?>' type='text' name='cpf' id='cpf' placeholder='CPF'></input>
                    <input value='<?php echo set_value('cep'); ?>' type='text' name='cep' placeholder='CEP' onblur="pesquisacep(this.value);"></input><br>
                    <input value='<?php echo set_value('estado'); ?>' type='text' id='uf' name='estado' placeholder='ESTADO'></input>
                    <input value='<?php echo set_value('cidade'); ?>' type='text' id="cidade"  name='cidade' placeholder='CIDADE'></input><br>
                    <input value='<?php echo set_value('rua'); ?>' type='text' id="rua"  name='rua' class='cem' placeholder='RUA'></input><br>
                    <input value='<?php echo set_value('bairro'); ?>' type='text' id="bairro"  name='bairro' placeholder='BAIRRO'></input>
                    <input value='<?php echo set_value('numero'); ?>' type='text' name='numero' placeholder='NÚMERO'></input><br>
                    <input value='<?php echo set_value('marcaemodelo'); ?>' type='text' name='marcaemodelo' placeholder='MARCA+MODELO'></input>
                    <input value='<?php echo set_value('placa'); ?>' type='text' name='placa' placeholder='PLACA'></input><br>
                    <input type='text' name='data' id='input_data' class='cem' placeholder='DATA'  readonly="readonly"></input>
                    <input type="hidden" name='id_estacionamento' id='id_estacionamento' value='<?php echo $item->id;?>'></input>
                    <input type="hidden" name='id_usuario' id='id_usuario' value='<?php echo $_SESSION['loggedin']['id'];?>'></input>
                    <button id='sub_form' type='submit'>RESERVAR</button>
                    <?php
                          if(isset($reserva_realizada)){
                            echo "<h4 class='realizou' style='color:#C2C249'>$reserva_realizada<h4>";
                          }

                    ?>
              </form>
              <form method="post" action="<?php echo base_url(); ?>user/selecao_multipla_view">
                                            <input type='hidden' name='titulo_estacionamento' value='<?php 
                      if(isset($_GET['titulo'])){
                        $_SESSION['titulo'] = $_GET['titulo'];
                        echo $_GET['titulo'];
                      }else{
                        echo $_SESSION['titulo'];
                      }
                      
                      ?>'></input>
                      <button type='selecao_multipla_submit'>SELEÇÃO MULTIPLA</button>
              </form>
          </div>
    </div>
  </div>
 
 
 

  </div>
 
<?php
  endforeach;
?>

<script src="<?php echo base_url(); ?>assets/js/integra.js" type="text/javascript"></script>
