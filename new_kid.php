<?php 
session_start();
if (!isset($_SESSION['id'])) {
  header('location:/GFI/login.php');
}else{
include('conecta.php');
    $sql = $conn->prepare('SELECT * FROM tb_user WHERE id= :id');
    $sql->bindValue("id", $_SESSION['id']); 
    $sql->execute();
    $dado = $sql->fetch();
if (isset($dado['id_responsa'])) {
  header('location:/GFI/login.php');
}
include_once "header.php";
?>
<html lang="pt-br">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<body>

<script src="/GFI/js/jquery-3.6.0.min.js"></script>
        <script>
$(document).ready(function(){
  $("#submit").click(function(){
    $.ajax({
    url: "./php/script/script_cadastro_kid.php",
    type: "POST",
    data: "ds_login="+$("#email").val()+"&ds_senha="+$("#password").val()+"&nm_user="+$("#fname").val()+" "+$("#lname").val(),
    dataType: "html"

    }).done(function(resposta) {
        $("span").html(resposta);
        console.log(resposta);

    }).fail(function(jqXHR, textStatus ) {
        console.log("Request failed: " + textStatus);

    }).always(function() {
        console.log("completou");
    });
  });
});
        </script>
  <div class="wrapper">
    <section class="form signup">
      <header><i class="fa fa-chevron-left menu-icon" onclick="history.go(-1)"></i> &nbsp;Cadastro Kids</header>
      <span></span><br>
        <div class="name-details">
          <div class="field input">
            <label>Primeiro nome</label>
            <input type="text" id="fname" placeholder="Primeiro nome" required>
          </div>
          <div class="field input">
            <label>Sobrenome</label>
            <input type="text" id="lname" placeholder="Sobrenome" required>
          </div>
        </div>
        <div class="field input">
          <label>E-mail</label>
          <input type="text" id="email" placeholder="Endereço de email" required>
        </div>
        <div class="field input">
          <label>Senha</label>
          <input type="password" id="password" placeholder="Crie uma Senha" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
          <button type="submit" id="submit" value="Criar">Criar Kid</button>
        </div>
    </section>
  </div>

  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/signup.js"></script>

</body>
</html>
<?php }?>