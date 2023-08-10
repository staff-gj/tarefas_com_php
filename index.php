<?php 
$conn = new mysqli("localhost", "root", "", "tarefas");

if($conn->connect_error){
    echo "Error" . $conn->connect_error;
}else{
    echo "Conectado com sucesso";
}

if(isset($_POST["cadastro"])){
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $data_vencimento = $_POST["data_vencimento"];
    $prioridade = $_POST["prioridade"];
    $status = $_POST["status"];

    $sql = "INSERT INTO dados (nome, descricao, data_vencimento, prioridade, status) VALUES ('$nome', '$descricao', '$data_vencimento', '$prioridade', '$status')";
    if($conn->query($sql) === TRUE){
        echo "Cadastrado com sucesso!";
    }else{
        echo "Falha ao Cadastrar";
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAREFAS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="index.php" method="post">
        <label for="">Nome: </label><br>
        <input type="text" name="nome" id=""><br>
        <label for="">Descrição: </label><br>
        <textarea name="descricao" id="" cols="30" rows="10"></textarea><br>
        <label for="">Data de vencimento: </label><br>
        <input type="date" name="data_vencimento" id=""><br>
        <label for="">Prioridade: </label><br>
        <select name="prioridade" id="">
            <option value="nao_importante">Não Importante</option>
            <option value="importante">Importante</option>
            <option value="muito_importante">Muito Importante</option>
        </select><br>
        <label for="">Status: </label><br>
        <select name="status" id="">
            <option value="incompleto">Incompleto</option>
            <option value="em_andamento">Em Andamento</option>
            <option value="concluido">Concluido</option>
        </select>
        <button name="cadastro">ADD NOVA TAREFA </button>
    </form>

    <form action="index.php" method="post">
    <input type="search" name="buscar" id="" placeholder="Buscar...">
    <button name="efetuar_busca">Procurar</button>
    </form>
    
    <div id="result_busca">
    <?php 
    echo "Resultados da Busca abaixo: ";
    if(isset($_POST["efetuar_busca"])){
        $buscar = $_POST["buscar"];

        $sql_procurar = "SELECT * FROM dados WHERE nome LIKE '%$buscar%'";

        $resultado_busca = $conn->query($sql_procurar);

        if ($resultado_busca !== false && $resultado_busca->num_rows > 0) {
            while ($result = $resultado_busca->fetch_assoc()) {
                echo "<div id='muito_importante'>";
                echo "Nome: " . $result["nome"] . "<br>";
                echo "Descrição: " . $result["descricao"] . "<br>";
                echo "Data de Vencimento: " . $result["data_vencimento"] . "<br>";
                echo "Prioridade: " . $result["prioridade"] . "<br>";
                echo "Status: " . $result["status"] . "<br><br><br>";  
                echo "</div>";  
            }
        } else {
            echo "Nenhum dado encontrado.";
        }
    }
    ?>
</div>


    <div id="result">
        <?php
        echo "Tarefas Cadastradas Abaixo: ";
        
        $sql_busca = "SELECT * FROM dados";

        $resultado = $conn->query($sql_busca);
        
        if ($resultado !== false && $resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                if($linha["prioridade"] === "muito_importante"){
                    echo "<div id='muito_importante'>";
                    echo "Nome: " . $linha["nome"] . "<br>";
                    echo "Descrição: " . $linha["descricao"] . "<br>";
                    echo "Data de Vencimento: " . $linha["data_vencimento"] . "<br>";
                    echo "Prioridade: " . $linha["prioridade"] . "<br>";
                    echo "Status: " . $linha["status"] . "<br>" . "<br>" . "<br>";  
                    echo "</div>";  
                }else if($linha["prioridade"] === "importante"){
                echo "<div id='importante'>";
                echo "Nome: " . $linha["nome"] . "<br>";
                echo "Descrição: " . $linha["descricao"] . "<br>";
                echo "Data de Vencimento: " . $linha["data_vencimento"] . "<br>";
                echo "Prioridade: " . $linha["prioridade"] . "<br>";
                echo "Status: " . $linha["status"] . "<br>" . "<br>" . "<br>";
                echo "</div>";
                }else{
                    echo "<div id='nao_importante'>";
                    echo "Nome: " . $linha["nome"] . "<br>";
                    echo "Descrição: " . $linha["descricao"] . "<br>";
                    echo "Data de Vencimento: " . $linha["data_vencimento"] . "<br>";
                    echo "Prioridade: " . $linha["prioridade"] . "<br>";
                    echo "Status: " . $linha["status"] . "<br>" . "<br>" . "<br>";
                    echo "</div>";    
                }
            }
        } else {
            echo "Nenhum dado encontrado.";
        }

        $resultado->close();
        $conn->close();
        ?>
    </div>
</body>
</html>