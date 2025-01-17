<!DOCTYPE html>

<html lang="pt-PT" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Registo de Utilizador</title>
    <link rel="stylesheet" href="styles.css">    
</head>
<body>
    <?php
    //definir variaveis e atribuir valor em branco
    $nomeErr = $emailErr = $generoErr = $moradaErr = $websiteErr = $data_nascErr = $telefoneErr = $fotoErr = $doc_IDErr = $passwordErr = "";
    $nome = $email = $genero = $morada = $website = $data_nasc = $telefone = $foto = $doc_ID = $password = $prefixo = "";
    $data_nasc = new DateTime(datetime: 'now');
    $upperLimit = new DateInterval('P18Y');
    $lowerLimit = new DateInterval('P120Y');
    $minData_NascLimit = (new DateTime()) ->sub(interval: $upperLimit);
    $maxData_NascLimit = (new DateTime()) ->sub(interval: $lowerLimit);  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["nome"])) {
            $nomeErr = "Campo Obrigatório!";
        }
        else {
            $nome = test_input($_POST["nome"]);
            //verificação se o campo de nome contem apenas letras
            // e espaços em branco
            if (!preg_match("/^[a-zA-Z-']*$/",$nome)){
                $nomeErr = "Apenas permite letras e espaço em branco";
            }
        }
        if (empty($_POST["email"])){
            $emailErr = "Campo Obrigatório";
        }
        else {
            $email = test_input($_POST["email"]);
            // verificação se o endereço de e-mail é válido
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $emailErr = "Formato de email inválido";
            }
        }
        if (empty($_POST["website"])){
            $website = "Campo Obrigatório";
        }
        else{
            $website = test_input($_POST["website"]);
            // verificação da sintaxe do endereço URL é válida
            //(esta expressão regular permite hífens no endereço URL)
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)){
                $websiteErr = "Endereço URL inválido";
            }
        }
        if (empty($_POST["morada"])){
            $morada = "Campo Obrigatório";
        }
        else{
            $morada = test_input($_POST["morada"]);
            //verificação se o campo de morada contem apenas letras, números
            // e espaços em branco
            if (!preg_match("/^[a-zA-Z-'0-9]*$/",$morada)){
                $moradaErr = "Apenas permite letras, números e espaço em branco";
            }
        }
        if (empty($_POST["genero"])){
            $generoErr = "Campo Obrigatório";
        }
        else{
            $genero = test_input($_POST["genero"]);
        }
        if (empty($_POST["data_nasc"])){
            $data_nascErr = "Campo Obrigatório";
        }
        else{
            if ($data_nasc <= $maxData_NascLimit){
                echo "Idade encontra-se fora do limite!";
            }
            elseif( $data_nasc <= $minData_NascLimit){
                echo "Idade é inferior a 18 anos!";
            }
            $data_nasc = test_input($_POST["data_nasc"]);
       }
        if (empty($_POST["telefone"])){
            $telefoneErr = "Campo Obrigatório";
        }
        else{
            $telefone = test_input($_POST["telefone"]);
            // verificação do número de telefone em formato válido
            if(!preg_match("[0-9]", $telefone));
        }
        if (empty($_POST["foto"])){
            $fotoErr = "Campo Obrigatório";
        }
        else {
            $foto = test_input($_POST["foto"]);
        }
        if (empty($_POST["doc_ID"])){
            $doc_IDErr = "Campo Obrigatório";
        }
        else {
            $doc_ID = test_input($_POST["doc_ID"]);
            //verificação do documento de identificação em formato válido
            if(!preg_match("/^[a-zA-Z-'0-9]*$/", $doc_ID));
        }
        if (empty($_POST["password"])){
            $passwordErr = "Campo Obrigatório"; 
        }
        else {
            $password = test_input($_POST["password"]);
        }

    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
    <div class="flex-container">
    <h1>Formulário de Registo</h1>
    <p><span class="error">* Todos os campos são obrigatórios</span></p>  
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="input">    
            <div class="label">
                <label for="nome">Nome:</label>
                <span class="error">* <?php echo $nomeErr;?>
                </span><br>
                <input id="nome" type="text" name="nome" value="<?php echo $nome;?>" placeholder="Ex: Luis Miguel" required><br>        
            </div>        
        </div>    
        <div class="input">    
            <div class="label">       
                <label for="email">Email:</label>
                <span class="error">* <?php echo $emailErr;?>
                </span><br>
                <input id="email" type="text" name="email" value="<?php echo $email;?>" placeholder="Ex: endereço@gmail.com" required><br>
            </div>    
        </div>
        <div class="input">
            <div class="label">
                <label for="documento_identificação">Nº Documento:</label>
                <span class="error">* <?php echo $doc_IDErr;?>
                </span><br>    
                <input id="documento_identificação" type="text" name="documento_identificação" value="<?php echo $doc_ID;?>" placeholder="Ex: Cartão Cidadão, Passaporte" required><br>
            </div>
        </div>         
        <div class="input">    
            <div class="label">
                <label for="website">Website:</label>
                <span class="error">* <?php echo $websiteErr;?>
                </span><br>
                <input id="website" type="text" name="website" value="<?php echo $website;?>" placeholder="Ex: https://www.google.com/" required><br>    
            </div>
        </div>      
        <div class="input">    
            <div class="label">
                <label for="morada">Morada:</label>
                <span class="error">* <?php echo $moradaErr;?>
                </span><br>
                <input id="morada" type="text" name="morada" value="<?php echo $morada;?>" placeholder="Ex: Rua da Rasa, 55" required><br>
            </div>
        </div>
        <div class="input">    
            <div class="label">
                <label for="data_nascimento">Data de Nascimento:</label>
                <span class="error">* <?php echo $data_nascErr;?>
                </span><br>
                <input id="data_nascimento" type="date" name="data_nascimento" required><br>
            </div>
        </div>
        <div class="input">    
            <div class="label">
                <label for="foto">Fotografia:</label>
                <span class="error">* <?php echo $fotoErr;?>
                </span><br>    
                <input id="foto" type="file" name="foto" required <?php echo $foto?>><br>
            </div>
        </div>
        <div class="radiobutton">
            <div class="label">
                <label>Género:</label>
                <span class="error">* <?php echo $generoErr;?>
                </span><br>
                <div class="label">
                    <label for="masculino">Masculino</label>
                    <input id="masculino" type="radio" name="genero" required <?php if(isset($genero) && $genero=="masculino") echo "checked";?> value="Masculino">
                    <label for="feminino">Feminino</label>
                    <input id="feminino" type="radio" name="genero" required <?php if(isset($genero) && $genero=="feminino") echo "checked";?> value="Feminino">
                    <label for="nenhum">Não Responde</label>
                    <input id="nenhum" type="radio" name="genero" required <?php if(isset($genero) && $genero=="nenhum") echo "checked";?> value="Não Responde">
                    <br>
                </div>
            </div>        
        </div>
        <div class="button">
            <input type="reset" value="Inicializar" onclick="return confirm('Tem a certeza de que quer apagar os dados preenchidos?')">
            <input type="submit" value="Submeter" onclick="return confirm('Tem a certeza de que quer submeter os dados preenchidos?')">
        </div>
    </form>
    </div>
    <p>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img style="border:0;width:88px;height:31px"
            src="http://jigsaw.w3.org/css-validator/images/vcss"
            alt="CSS válido!">
    </a>
    </p>
</body>
</html>