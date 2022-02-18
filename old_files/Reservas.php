<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservas extends CI_Controller {
  public function isDisponivel(){
    $data = $_GET['data'];
    $id_estacionamento = $_GET['id_estacionamento'];
    $this->load->model('reservas_model');
    $this->load->model('parking_model');
    $select = "SELECT * FROM `reservas` WHERE data like '%$data%' and id_estacionamento=$id_estacionamento";
    $vagas_ja_reservadas = intval($this->reservas_model->disponibilidade($select));
    $total_vagas = intval($this->parking_model->vagas($id_estacionamento));
    $disponibilidade =  $total_vagas-$vagas_ja_reservadas;

    if($disponibilidade > 0){
      echo $disponibilidade;
    }else{
      echo '0';
    }
  }
 public function reservar(){
    $this->load->library('form_validation');
		$this->form_validation->set_rules('cpf', 'cpf', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('cep', 'cep', 'trim|required|max_length[8]');
    $this->form_validation->set_rules('estado', 'estado', 'trim|required|max_length[2]');
    $this->form_validation->set_rules('cidade', 'cidade', 'trim|required|max_length[50]');
    $this->form_validation->set_rules('bairro', 'bairro', 'trim|required|max_length[50]');
    $this->form_validation->set_rules('rua', 'rua', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('numero', 'numero', 'trim|required|integer|max_length[8]');
    $this->form_validation->set_rules('marcaemodelo', 'marca e modelo', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('placa', 'placa', 'trim|required|max_length[20]');

            if ($this->form_validation->run() == FALSE)
            {
                $this->load->helper('cookie');
                setcookie('KJDa990',true);

                $this->load->model("parking_model");
                $data = ['estacionamento'=>$this->parking_model->dataparking($_SESSION['estac_titulo']),'data_escolhida'=>$_POST['data']];
              
                $this->load->view('templates/header');
                $this->load->view('site/integra',$data);
            
            }
            else
            {
              // print_r($_POST);
              $this->load->model("reservas_model");
              $reserva = array(
                "id_usuario" => $_POST['id_usuario'],
                "id_estacionamento" =>  $_POST['id_estacionamento'],
                "cpf" =>  $_POST['cpf'],
                "cep" => $_POST['cep'],
                "estado" =>  $_POST['estado'],
                "cidade" =>  $_POST['cidade'],
                "bairro" =>  $_POST['bairro'],
                "rua" => $_POST['rua'],
                "complemento" =>  $_POST['numero'],
                "marcamodelo" =>  $_POST['marcaemodelo'],
                "placa" =>  $_POST['placa'],
                "data"=>$_POST['data'],
              );
              $this->reservas_model->store($reserva);
                                // --- email
                                $this->load->model("user_model");
                                $this->load->model("parking_model");
                                $estacionamento = $this->parking_model->getEstacionamentoTitulo($_POST['id_estacionamento']);
                                $usuario = $this->user_model->getEmail($_POST['id_usuario']);
                               
                                foreach($this->user_model->allAdmins() as $item):
$this->db->initialize();
                                  $this->load->config('email');
                                  $this->load->library('email');
                
                                  $from = $this->config->item('smtp_user');
                                  $to =  $item->email;
                                  $subject = "NOVA RESERVA CADASTRADA";
                                  $message = "
                                  <p>Você está recebendo esse e-mail porque uma nova reserva acaba de ser cadastrada para o estacionamento ".$estacionamento."pelo usuario ".$usuario."</p>";
                
                                  $this->email->set_newline("\r\n");
                                  $this->email->from($from);
                                  $this->email->to($to);
                                  $this->email->subject($subject);
                                  $this->email->message($message);
                                  $this->email->send();
$this->db->close();
                                endforeach;
                              // --- email

              //$this->load->model("user_model");
$this->db->initialize();
              $creditoAtual = intval($this->user_model->retornaCreditos($_POST['id_usuario']));
              $novoValorDosCreditos = $creditoAtual - 1;

              $data = array(
                "credito" => $novoValorDosCreditos,
              );
              $this->user_model->atualizar_creditos($_POST['id_usuario'],$data);

              $this->load->helper('cookie');
              setcookie('KJDa990',true);

             // $this->load->model("parking_model");
              $data = ['estacionamento'=>$this->parking_model->dataparking($_SESSION['estac_titulo']),'data_escolhida'=>$_POST['data'],'reserva_realizada'=>'SUA RESERVA FOI REALIZADA'];
            
              $this->load->view('templates/header');
              $this->load->view('site/integra',$data);
            }
  }
  public function taSemCredito(){
    $id = $_GET['id'];
    $this->load->model("user_model");
    $creditos = intval($this->user_model->retornaCreditos($id));
    echo $creditos;
  }




  public function reservarNova(){
    $this->load->library('form_validation');
		$this->form_validation->set_rules('cpf', 'cpf', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('cep', 'cep', 'trim|required|max_length[8]');
    $this->form_validation->set_rules('estado', 'estado', 'trim|required|max_length[2]');
    $this->form_validation->set_rules('cidade', 'cidade', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('bairro', 'bairro', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('rua', 'rua', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('numero', 'numero', 'trim|required|integer|max_length[8]');
    $this->form_validation->set_rules('marcaemodelo', 'marca e modelo', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('placa', 'placa', 'trim|required|max_length[20]');

            if ($this->form_validation->run() == FALSE)
            {


                $this->load->model('parking_model');
                
                $data = ['estacionamento'=> $this->parking_model->getDatas( $_POST['titulo']),'titulo'=>  $_POST['titulo'],'info'=>  $this->parking_model->dataparking( $_POST['titulo']),'vagas'=>$_POST['datas_banco']];
                $this->load->view('templates/header');
                $this->load->view('dashboard/selecao_multipla',$data);
            
            }
            else
            {
              $array =explode(",",$_POST['datas_escolhidas']) ;
        
              for($i = 0;$i < sizeof($array);$i++){
                        $this->load->model("reservas_model");
                        $reserva = array(
                          "id_usuario" => $_POST['id_usuario'],
                          "id_estacionamento" =>  $_POST['id_estacionamento'],
                          "cpf" =>  $_POST['cpf'],
                          "cep" => $_POST['cep'],
                          "estado" =>  $_POST['estado'],
                          "cidade" =>  $_POST['cidade'],
                          "bairro" =>  $_POST['bairro'],
                          "rua" => $_POST['rua'],
                          "complemento" =>  $_POST['numero'],
                          "marcamodelo" =>  $_POST['marcaemodelo'],
                          "placa" =>  $_POST['placa'],
                          "data"=>$array[$i],
                        );
                        $this->reservas_model->store($reserva);
                                          // --- email
                                          $this->load->model("user_model");
                                          $this->load->model("parking_model");
                                          $estacionamento = $this->parking_model->getEstacionamentoTitulo($_POST['id_estacionamento']);
                                          $usuario = $this->user_model->getEmail($_POST['id_usuario']);
                                        
//foreach ficava aqui
                                        // --- email

                  
                        $creditoAtual = intval($this->user_model->retornaCreditos($_POST['id_usuario']));
                        $novoValorDosCreditos = $creditoAtual - 1;

                        $data = array(
                          "credito" => $novoValorDosCreditos,
                        );
                        $this->user_model->atualizar_creditos($_POST['id_usuario'],$data);

                        // $this->load->helper('cookie');
                        // setcookie('KJDa990',true);

                        // $data = ['estacionamento'=>$this->parking_model->dataparking($_SESSION['estac_titulo']),'data_escolhida'=>$_POST['data'],'reserva_realizada'=>'SUA RESERVA FOI REALIZADA'];
                      
                        // $this->load->view('templates/header');
                        // $this->load->view('site/integra',$data);
              }

              $data = ['estacionamento'=> $this->parking_model->getDatas( $_POST['titulo']),'titulo'=>  $_POST['titulo'],'info'=>  $this->parking_model->dataparking( $_POST['titulo']),'reserva_realizada'=>'SUA RESERVA FOI REALIZADA'];
              $this->load->view('templates/header');
              $this->load->view('dashboard/selecao_multipla',$data);
            }
  }

























  
}
?>