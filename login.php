<?php
session_start();
if (isset($_SESSION['id'])) {
  header('location:/GFI/menu.php');
}else{
?> 

<?php include_once "header.php";?>
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="website icon" type="png" href="./img/icon-gfi.png">
<body>

<script src="/GFI/js/jquery-3.6.0.min.js"></script>
        <script>
$(document).ready(function(){
  $("#submit").click(function(){
    $.ajax({
    url: "./php/check.php",
    type: "POST",
    data: "login="+$("#email").val()+"&senha="+$("#password").val(),
    dataType: "html"

    }).done(function(resposta) {
        $("#resp").html(resposta);

    }).fail(function(jqXHR, textStatus ) {
        console.log("Request failed: " + textStatus);

    }).always(function() {
        console.log("completou");
    });
  });
});
        </script>

  <div class="wrapper">
    <section class="form login">
      <header>Login</header>
        <div id="resp"></div>
        <div class="field input">
          <label>Endereço de email</label>
          <input type="text" id="email" placeholder="Email" required>
        </div>
        <div class="field input">
          <label>Senha</label>
          <input type="password" id="password" placeholder="Senha" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
          <button type="submit" id="submit" value="Login">Login</button>
        </div>
      <div class="link">Ainda não se inscreveu? <a href="index.php">Inscreva-se agora</a></div>
    </section>
  </div>
  
  <script src="js/pass-show-hide.js"></script>

</body>
</html>
<?php
}
?>