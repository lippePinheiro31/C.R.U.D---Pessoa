<?php 

require_once 'classe-pessoa.php';

$p = new Pessoa('crudpdo','localhost','root','');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title></title>
</head>
    <body>
    <h1>C.R.U.D - Cadastro de Pessoas</h1>
<?php 

//Clicou no botão cadastrar ou editar
if(isset($_POST['nome'])){ 

    //-------------------EDITAR-------------------//
    if(isset($_GET['id_up']) && !empty($_GET['id_up'])){ 
       
       // addlashes(str)-> função que bloqueia códigos maliciosos
        $id_upd = addslashes($_GET['id_up']);
       $nome = addslashes($_POST['nome']);
       $telefone = addslashes($_POST['telefone']);
       $email = addslashes($_POST['email']);

       if(!empty($nome) && !empty($telefone) && !empty($email)){
           $p->atualizarDados($id_upd,$nome, $telefone, $email);
           header("location:index.php");
       }
       else{
        ?>
             <div class="alert alert-danger" role="alert">
        Preencha todos os campos!
</div>
        <?
           }
       }
    //-----------------------CADASTRAR----------------------//
    else{
            // addlashes(str)-> função que bloqueia códigos maliciosos

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    if(!empty($nome) && !empty($telefone) && !empty($email)){
        if(!$p->cadastrarPessoa($nome, $telefone, $email)) {
            ?>
             <div class="alert alert-danger" role="alert">
        Email já está cadastrado!
</div>
        <?       
        }
    }
    else{
        ?>
      <div class="alert alert-danger" role="alert">
        Preencha todos os campos!
</div>
        <?
        }
    }
    
}
?>
    <div class="container">
<?php 

    if(isset($_GET['id_up'])){ // verifica se o usuário clicou no botão editar
        $id_update = addslashes($_GET['id_up']);
        $res = $p->buscarDadosPessoa($id_update);
   
    }

?>
    <section id="esquerda">
<h3>Cadastrar Pessoa</h3>
    <form method="post">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nome</label>
    <input type="text" class="form-control" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];}?>">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Telefone</label>
    <input type="text" class="form-control" name="telefone" id="telefone" value="<?php if(isset($res)){echo $res['telefone'];}?>">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Email</label>
    <input type="email" class="form-control" name="email" id="email" value="<?php if(isset($res)){echo $res['email'];}?>">
  </div>
  <input type="submit" class="btn btn-success" value="<?php if(isset($res)){echo "Atualizar" ;}else{echo "Cadastrar";}?>">
</form>
    </section>
    <section id="direita">
    <table class="table table-dark table-sm">
  <tr>
        <td>Nome</td>
        <td>Telefone</td>
        <td colspan="4">Email</td>
    </tr>
    <?php
       $dados = $p->buscarDados();
       
       if(count($dados) > 0){
            for($i=0; $i < count($dados); $i++){
                echo"<tr>";
                foreach($dados[$i] as $k => $v){
                    if($k != "id"){
                        echo"<td>".$v."</td>";
                    }
                }?>
                <td><a href="index.php?id_up=<?php echo $dados[$i]['id'];?>"class="btn btn-primary">Editar</a></td>
                <td><a href="index.php?id=<?php echo $dados[$i]['id'];?>" class="btn btn-danger">Excluir</a></td>
                <?php
                echo"</tr>";
            }
       }
       else{
           ?>
           <div class="msg">
           <td colspan="4"><strong>Ainda não há pessoas cadastradas!</strong></td>
           </div>
           <?php
       }
     ?>
</table>

    </section>
    </div>
    </body>
</html>
<?php 
if(isset($_GET['id'])){
   
        $id_pessoa = addslashes($_GET['id']);
        $p->excluirPessoa($id_pessoa);
        header("location:index.php");
}

?>
<style>

*{
    padding:0px;
    margin:0px;
    font-family:arial;
}
body{
   
    align-items:center;
    justify-content:center;
    background-color: #fff;
    text-align:center;
}
h1{
    margin-top:20px;
}
 #esquerda{
    width:330px;
    margin-left:0px;
    margin-top:30px;
    border: 1px solid #000;
    border-radius:15px;
    padding:20px;
    margin-right:90px;
    background-color:  	#383838;
    color:#fff;
}
.form-control{
    width:290px;
    height:30px;
}
#direita{
    width:600px;
    margin-top:-40px;
}
.table-sucess {
    width:280px;
    margin-left:15px;
    float:right;

}
.container{

    display:flex;
    align-items:center;
    justify-content:center;
    margin-top:40px;
    padding:20px;
    padding-top:40px;
    padding-bottom:80px;
    background-color:#d6f5f5;
    border:1px solid #000;
    border-radius:5px;
}
.aviso{
    color:red;
}
</style>