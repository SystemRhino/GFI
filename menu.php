<?php
session_start();
$id_original = $_SESSION['id_original'];
$id_user = $_SESSION['id'];
include('conecta.php'); 

      //tb_user
  $sql = $conn->prepare('SELECT * FROM tb_user WHERE id= :id');
  $sql->bindValue("id", $_SESSION['id_original']); 
  $sql->execute();
  $dado = $sql->fetch();

    //Validação de responsável
if (isset($dado['id_responsa'])) {
  $link = "menu.php";
  $id_kid = $dado['id_responsa'];
}else{
  $link = "new_kid.php";
}

    //Validação de sessão
if (!isset($_SESSION['id'])) {
  header('location:login.php');
}else{
  $id_user = $_SESSION['id'];

        //Function para inverter a data do banco
    function inverteData($data){
        if(count(explode("/",$data)) > 1){
            return implode("-",array_reverse(explode("/",$data)));
        }elseif(count(explode("-",$data)) > 1){
            return implode("/",array_reverse(explode("-",$data)));
        }
    }

        //Kid
    $kid_id = $conn->prepare("SELECT * FROM tb_user WHERE id_responsa=$id_original");
    $kid_id->execute();
    
        //Total de notificação
    $nr_not = $conn->query("SELECT count(*) as total_registros From tb_not");
    $nr_not->execute();
    $row = $nr_not->fetch(PDO::FETCH_ASSOC);
    $total = $row['total_registros'];

        //Dados da notificação
    $notifica = $conn->prepare("SELECT * FROM tb_not");
    $notifica->execute();

        //Cálculo saída & entrada 
    $saida_dado = $conn->prepare("SELECT SUM(vl_lancamento) as soma FROM tb_lancamento WHERE id_user='$id_user' AND id_status=1");
    $saida_dado->execute();
    $row_saida = $saida_dado->fetch();

    $entrada_dado = $conn->prepare("SELECT SUM(vl_lancamento) as soma FROM tb_lancamento WHERE id_user ='$id_user' AND id_status =2");
    $entrada_dado->execute();
    $row_entrada = $entrada_dado->fetch();

        //tb_lancamento
    $lancamento = $conn->prepare("SELECT * FROM tb_lancamento WHERE id_user=$id_user");
    $lancamento->execute();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>GFI</title>
  <meta charset="utf-8">
  <link rel="website icon" type="png" href="./img/icon-gfi.png">
	<link rel="stylesheet" type="text/css" href="./css/dashboard.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<style>
  body{
    transform: scale(1);
    transform-origin: 0 0;
  }
</style>
<div class="sidebar">
	<h1 class="logo">GFI<span>-Finanças</span></h1>
	<i class="fa fa-chevron-left menu-icon"></i>
	<ul class="sidenav">
		<li class="active"><i class="fa fa-home"></i><a> Dashboard
			<span class="span1"><i class="fa fa-angle-right" ></i></span>
		</a>
		</li>

		<ul class="dropdown">
      <p class="app" id="grupo"><i class="fa fa-users"></i>&nbsp;&nbsp;Grupo</p>
<?php
    if ($id_user == $id_original) {
?>
      <a class="botzin"><li><i class="fa fa-user"></i> <?php echo strstr($_SESSION['nm_user'], ' ', true);?></li></a>
<?php 
    }else{
?>
      <a href="./php/swap_acc.php?id=<?php echo $id_original;?>&st=return_acc" class="botzin"><li><i class="fa fa-user"></i> <?php echo strstr($_SESSION['nm_user'], ' ', true);?></li></a>
<?php
    }
    while($kid = $kid_id->fetch(PDO::FETCH_ASSOC)){
?>
    <a href="./php/swap_acc.php?id=<?php echo $kid['id'];?>&st=swap_acc" class="botzin"><li><i class="fa fa-user"></i> <?php echo strstr($kid['nm_user'], ' ', true);?></li></a>
<?php }?>
			</ul>

		<p class="app">Outros</p>
		<li><i class="fa fa-calendar"></i><a href="calendario.php"> Calendário</a></li>
		<li><i class="fa fa-user"></i><a href="#"> User</a></li>
		
	</ul>
</div>

<div class="main">
	<div class="main-top">
		<input type="text" name="" class="input" placeholder="Pesquisar um registro">
		<div class="top-right">
			<i class="fa fa-bell-o topicon bell" data-count="<?php echo $total;?>"></i>
			<div class="notification-div">
<?php while ($not = $notifica->fetch(PDO::FETCH_ASSOC)) { ?>
			<p><?php echo $not['ds_not'];?></p>	
<?php } ?>
		</div>


			<a class="user1"><img src="./img/user.png" class="user">
				<div class="profile-div">
					<p onclick="window.location.href = 'user.php'"><i class="fa fa-user"></i> &nbsp;&nbsp;Profile</p>
					<p><i class="fa fa-cog"></i> &nbsp;&nbsp;Settings</p>
					<p onclick="window.location.href = './php/logout.php'"><i class="fa fa-power-off"></i> &nbsp;&nbsp;Log Out</p>
				</div>
			</a>
		</div>
		<div class="clearfix"></div>
	</div>


	<div class="cong-box">
		<div class="content">
		<p class="head">GFI Kids</p><br>
		<p>Adicione seu filho(a) para que eles controlem as próprias despezas.</p>
		<button class="btn"><a href="<?php echo $link;?>">Adicionar Kids</a></button>
	</div>
	</div>

	<div class="com-box">
		<div class="com-inner">
		<i class="fa fa-arrow-down"></i>
		<p>Saídas</p>
		<p>R$
<?php  
      $soma_saida = $row_saida['soma'];
      $soma_saida_final = str_replace('.', ',', $soma_saida);
      if ($soma_saida_final =="") {             
        echo "0,00";
      }else{
        echo $soma_saida_final;
      }
?>
    </p>
		<p><i class="fa fa-long-arrow-down downar"></i> -14.25%</p>
		</div>
	</div>
	<div class="com-box">
		<div class="com-inner">
		<i class="fa fa-arrow-up"></i>
		<p>Entradas</p>
		<p>R$
<?php 
      $soma_entrada = $row_entrada['soma'];
      $soma_entrada_final = str_replace('.', ',', $soma_entrada);
      if ($soma_entrada_final =="") {
        echo "0,00";
      }else{
        echo $soma_entrada_final;
      }
?>
    </p>
		<p style="color: green;"><i class="fa fa-long-arrow-up upnar"></i> +28.25%</p>
		</div>
	</div>


	<div class="table-box">
     &nbsp; <button class="btn"><a href="new_lancamento.php">Adicionar</a></button>
		<table>
  <thead>
    <tr>
      <th scope="col" width="70px">Ação</th>
      <th scope="col" width="50px">ID</th>
      <th scope="col" width="50px">Categoria</th>
      <th scope="col" width="100px">Forma</th>
      <th scope="col">Data</th>
      <th scope="col">Valor</th>
      <th scope="col">Parcelas</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
<?php
    while($lanca = $lancamento->fetch(PDO::FETCH_ASSOC)){
    $id_pagto = $lanca['id_forma_pagto'];
    $id_status = $lanca['id_status'];
    $id_categoria = $lanca['id_categoria'];

        //tb_forma_pagto
    $forma_pagto = $conn->prepare("SELECT * FROM tb_forma_pagto WHERE id='$id_pagto'");
    $forma_pagto->execute();
    $pagto = $forma_pagto->fetch(PDO::FETCH_ASSOC);

        //tb_categoria
    $categoria = $conn->prepare("SELECT * FROM tb_categoria WHERE id=$id_categoria");
    $categoria->execute();
    $cate = $categoria->fetch(PDO::FETCH_ASSOC);

        //Invertendo a data
    $data = substr($lanca['dt_lancamento'], 5, 5);
    $data = inverteData($data);
?>
    <tr onclick="window.location.href = 'view_lancamento.php?id=<?php echo $lanca['id'];?>'">
      <td data-label="Period">
            <a href="php/editar.php?id=<?php echo $lanca['id'];?>" class="edit"><i class="fa fa-pencil-square-o"></i></a>
           <a href="php/deletar.php?id=<?php echo $lanca['id'];?>" class="trash"><i class="fa fa-trash"></i></a>
      </td>

      <td label="Account">#<?php echo $lanca['id'];?> </td>
      <td data-label="Account"><?php echo $cate['nm_categoria'];?> </td>
      <td data-label="Due Date"><i class="<?php echo $pagto['img_pagto'];?>"></i></td>
      <td data-label="Period"><?php echo $data;?></td>
      <td data-label="Due Date">R$<?php echo $vl_final = str_replace('.', ',', $lanca['vl_lancamento']);?></td>
      <td data-label="Due Date"><?php echo $lanca['nr_parcela_atual'];?>/<?php echo $lanca['nr_parcela_final'];?></td>
<?php 
        //tb_status
    $status = $conn->prepare("SELECT * FROM tb_status WHERE id=$id_status");
    $status->execute();
    $st = $status->fetch(PDO::FETCH_ASSOC);
?>
      <td data-label="Amount" style="position: relative;"><span class="<?php echo $st['class']?>"></span><?php echo $st['nm_status']?></td>
    </tr>
<?php } ?>
  </tbody>
</table>
	</div>
	<div class="t-sale">
			<div class="content-box-1">
			<br>
			<p class="head-1">Despesas Brutas</p>
			<div class="circle-wrap">

    <div class="circle">
      <div class="mask full">
        <div class="fill"></div>
      </div>
      <div class="mask half">
        <div class="fill"></div>
      </div>
      <div class="inside-circle" maxlength="4">
<?php
      if ($soma_entrada=="" && $soma_saida=="") {
          echo "0";
          $deg = 0;
          }elseif ($soma_entrada=="") {
            echo "100";
            $deg = 180;
      }else{
        try {
           $div = $soma_saida/$soma_entrada*100;
           $div = intval($div);
           $deg = 180/100*$div;
           if ($deg > 180) {
             $deg = 180;
           }
           echo $result = substr($div, 0, 3);
            } catch (DivisionByZeroError $e) {
              echo "0";
                } catch (ErrorException $e) {
                  echo "got exception by zero";
                  }
                }
?>% </div>
    </div>
  </div>
		</div>
		<div style="text-align: center;"><button class="btn">Ver Tudo</button></div>
  </div>
	</div>
    <div class="head-2"></div>
</div>



<style>
.circle-wrap .circle .mask.full,
.circle-wrap .circle .fill {
  animation: fill ease-in-out 1s;
  transform: rotate(<?php echo $deg;?>deg);
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $(".span1").click(function(){
    $(".dropdown").slideToggle(500);
    var toggle = 1;
    console.log(toggle);
  });
});

	$('.sidenav li').click(function(){
    $('.sidenav li').removeClass("active");
    $(this).addClass("active");
});
</script>

<script type="text/javascript">
	$(".menu-icon").click(function(e) {
        e.preventDefault();
        $(".menu-icon").toggleClass("menuicon");
        $(".main").toggleClass("main-width");
        $(".sidebar").toggleClass("active1");
        $(".sidenav li a").toggleClass("anchor");
        $(".sidenav li").toggleClass("lislide");
        $(".sidenav p").toggleClass("apphide");
        $(".logo span").toggleClass("headspan");
        $(".logo").toggleClass("lm");
        $(".botzin").toggleClass("anchor");
        $("#grupo").toggleClass("anchor");
        
        

});
</script>
<script>
$(document).ready(function(){
  $(".user").click(function(){
    $(".profile-div").toggle(1000);
    $(".notification-div").hide();
  });
  $(".bell").click(function(){
    $(".notification-div").toggle(1000);
    $(".profile-div").hide();
  });
});

</script>
</body>
</html>
<?php }?>