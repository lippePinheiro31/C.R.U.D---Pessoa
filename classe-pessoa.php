<?php 

class Pessoa{

    private $pdo;
  
    // Realizando conexão com o Banco de Dados 

    public function __construct($dbname, $host, $user, $password){
        try{
        $this->pdo = new PDO("mysql:dbname=".$dbname.";host=" . $host, $user, $password);
    }
    catch(PDOExcepton $e){
        echo 'Erro com o banco de dados:' . $e->getMessage();
        }
        catch(Excepton $e){
            echo 'Erro:' . $e->getMessage();
            exit();
            }
        }

            //Função para buscar os dados e colocar no canto direito da tela;

    public  function buscarDados(){
        $res = array();
        $cmd = $this->pdo->query("SELECT* FROM pessoa ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
  
  
        }
        // Função para cadastrar uma pessoa no banco de dados
        public function cadastrarPessoa($nome, $telefone, $email){
          $cmd =$this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            if($cmd->rowCount() > 0) // O email já existe no banco de dados
            {
                return false;
        
            }
            else // não foi encontrado o email
            {
                $cmd = $this->pdo->prepare("INSERT INTO pessoa (nome,telefone,email) values (:n,:t,:e)");
                $cmd->bindValue(":n",  $nome);
                $cmd->bindValue(":t",  $telefone);
                $cmd->bindValue(":e",  $email);
                $cmd->execute();
                
                return true;
                
            }
        }
        public function excluirPessoa($id){
            $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();

        }

        public function buscarDadosPessoa($id){
            $res = array();
            $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            $res = $cmd->fetch(PDO::FETCH_ASSOC);
            return $res;
        }
        public function atualizarDados($id,$nome, $telefone, $email){
            // Verificando se o email já existe no banco de dados, antes de atualizar 
            $cmd =$this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            if($cmd->rowCount() > 0) // O email já existe no banco de dados
            {
                return false;
        
            }
            else // não foi encontrado o email
            {

            $cmd =  $this->pdo->prepare("UPDATE pessoa SET nome =:n, telefone =:t, email= :e WHERE id= :id");
            $cmd->bindValue(":n",  $nome);
            $cmd->bindValue(":t",  $telefone);
            $cmd->bindValue(":e",  $email);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            return true;
        }
    }
}

        

?>