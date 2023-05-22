<?php 
include('conecta.php');
$id = $_GET['id'];

$lancamento = $conn->query("SELECT * FROM tb_lancamento WHERE id=$id");
$lancamento->execute();
$lanca = $lancamento->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>

	<title></title>
</head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@500&display=swap" rel="stylesheet">
<?php include_once "header.php";?>
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<body>

<script src="/GFI/js/jquery-3.6.0.min.js"></script>
        <script>
$(document).ready(function(){
  $("#submit").click(function(){
    $.ajax({
    url: "./php/script/ed_lancamento.php",
    type: "POST",
    data: "ds_lancamento="+$("#ds_lancamento").val()+"&id_categoria="+$("#id_categoria").val()+"&id_status="+$("#id_status").val()+"&vl_lancamento="+$("#vl_lancamento").val()+"&id_forma_pagto="+$("#id_forma_pagto").val()+"&dt_lancamento="+$("#dt_lancamento").val()+"&dt_lancamento_final="+$("#dt_lancamento_final").val()+"&nr_parcela_final="+$("#nr_parcela_final").val()+"&nr_parcela_atual="+$("#nr_parcela_atual").val()+"&nm_credor="+$("#nm_credor").val()+"&nm_devedor="+$("#nm_devedor").val(),
    dataType: "html"

    }).done(function(resposta) {
        $("span").html(resposta);

    }).fail(function(jqXHR, textStatus ) {
        console.log("Request failed: " + textStatus);

    }).always(function() {
        console.log("completou");
    });
  });
});

var btn = $("#submit");
btn.click(function() {
  $('html, body').animate({scrollTop:0}, 'slow');
});
        </script>

  <div class="wrapper">
    <section class="form login">
    	<span></span>
      <header><i class="fa fa-chevron-left menu-icon" onclick="history.go(-1)"></i> Novo Lançamento</header>
        
        <div class="field input">
          <label>Descrição</label>
         <textarea id="ds_lancamento" placeholder="Descrição" required></textarea>
        <div class="field input">
          <label>Categoria</label>
          <select class="custom-select" id="id_categoria">
<?php
          $categoria = $conn->prepare("SELECT * FROM tb_categoria");
          $categoria->execute();
          while ($lanca = $categoria->fetch(PDO::FETCH_ASSOC)) { 
?>
            <option value="<?php echo $lanca['id'];?>"><?php echo $lanca['nm_categoria'];?></option>
<?php } ?>
          </select>
          <button type="submit" id="new_categoria" value="Login">Adcionar nova categoria</button>
        </div>
        <div class="field input">
          <label>Status</label>
          <select class="custom-select" id="id_status">
<?php
          $status = $conn->prepare("SELECT * FROM tb_status");
          $status->execute();
          while ($st = $status->fetch(PDO::FETCH_ASSOC)) { 
?>
            <option value="<?php echo $st['id'];?>"><?php echo $st['nm_status'];?></option>
<?php } ?>
          </select>
        </div>
        <div class="field input">
          <label>Valor</label>
          <input type="number" id="vl_lancamento" placeholder="Valor do Lançamento" required>
        </div>
        <div class="field input">
          <label>Forma de Pagamento</label>
          <select class="custom-select" id="id_forma_pagto">
<?php
          $forma_pagto = $conn->prepare("SELECT * FROM tb_forma_pagto");
          $forma_pagto->execute();
          while ($pagto = $forma_pagto->fetch(PDO::FETCH_ASSOC)) { 
?>
            <option value="<?php echo $pagto['id'];?>"><?php echo $pagto['nm_forma_pagto'];?></option>
<?php } ?>
          </select>        
        </div>
        <div class="field input">
          <label>Data Lançada</label>
          <input id="dt_lancamento" type="date">
        </div>
        <div class="field input">
          <label>Data Final</label>
          <input id="dt_lancamento_final" type="date">
        </div>
        <div class="field input">
          <label>Valor de Parcelas Total</label>
          <input id="nr_parcela_atual" type="number" placeholder="Valor" required>
        </div>
        <div class="field input">
          <label>Valor de Parcelas Paga</label>
          <input id="nr_parcela_final" type="number" placeholder="Valor" required>
        </div>
        <div class="field input">
          <label>Credor</label>
          <input id="nm_credor" type="text" placeholder="Quem irá receber" required>
        </div>
        <div class="field input">
          <label>Devedor</label>
          <input id="nm_devedor" type="text" placeholder="Quem irá pagar" value="teste" required>
        </div>
        <div class="field button">
          <button type="submit" id="submit" value="Adiconar">Adiconar</button>
        </div>
    </section>
  </div>
  
</body>
</html>