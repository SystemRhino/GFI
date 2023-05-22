<?php
session_start();
if (!isset($_SESSION['id'])) {
  header('location:/GFI/login.php');
}else{
  $id = $_GET['id'];
?> 
<?php
    include('conecta.php');

        //tb_lancamento
    $lancamento = $conn->prepare("SELECT * FROM tb_lancamento WHERE id=$id");
    $lancamento->execute();
    $lanca = $lancamento->fetch(PDO::FETCH_ASSOC);

    $id_categoria = $lanca['id_categoria'];
    $id_forma_pagto = $lanca['id_forma_pagto'];
    $id_status = $lanca['id_status'];

        //tb_categoria
    $categoria = $conn->prepare("SELECT * FROM tb_categoria WHERE id=$id_categoria");
    $categoria->execute();
    $cate = $categoria->fetch(PDO::FETCH_ASSOC);

        //tb_forma_pagto
    $forma_pagto = $conn->prepare("SELECT * FROM tb_forma_pagto WHERE id=$id_forma_pagto");
    $forma_pagto->execute();
    $forma = $forma_pagto->fetch(PDO::FETCH_ASSOC);

        //tb_status
    $status = $conn->prepare("SELECT * FROM tb_status WHERE id=$id_status");
    $status->execute();
    $st = $status->fetch(PDO::FETCH_ASSOC);

    if ($id_status == 1) {
      $color = "#ff5016";
    }else{
      $color = "#90ee90";
    }
?>
<?php include_once "header.php";?>
<!DOCTYPE html>
<html lang="pt-br">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<body>
  <div class="wrapper">
    <section class="form login">
      <header><i class="fa fa-chevron-left menu-icon" onclick="history.go(-1)"></i> &nbsp;Registro #<?php echo $id;?></header>
        <span id="resp"></span>
        <div class="field input">
          <label>Categoria</label>
          <h4><i class="<?php echo $cate['img_categoria'];?>"></i><?php echo $cate['nm_categoria'];?></h4>
        </div>
        <div class="field input">
          <label>Status</label>
          <h4 style="color: <?php echo $color;?>"><?php echo $st['nm_status'];?></h4s>
        </div>
        <div class="field input">
          <label>Descrição</label>
          <h4><?php echo $lanca['ds_lancamento'];?></h4>
        </div>
        <div class="field button">
          <button type="submit" id="submit" value="Login">Editar</button>
        </div>
    </section>
  </div>
  
  <script src="js/pass-show-hide.js"></script>

</body>
</html>
<?php
}
?>