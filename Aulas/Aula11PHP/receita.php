<?php
include('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciente_id = $_POST['paciente_id'];
    $medicamento = $_POST['medicamento'];
    $data_administracao = $_POST['data_administracao'];
    $hora_administracao = $_POST['hora_administracao'];
    $dose = $_POST['dose'];

    $sql = "INSERT INTO receitas (paciente_id, medicamento, data_administracao, hora_administracao, dose) 
            VALUES ('$paciente_id', '$medicamento', '$data_administracao', '$hora_administracao', '$dose')";
    if (mysqli_query($conn, $sql)) {
        echo "Receita cadastrada com sucesso!";
    } else {
        echo "Erro: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Cadastro de Receita Médica</h2>
    <form method="POST">
        <div class="form-group">
            <label>Paciente</label>
            <select name="paciente_id" class="form-control">
                <?php
                $pacientes = mysqli_query($conn, "SELECT * FROM pacientes");
                while ($paciente = mysqli_fetch_assoc($pacientes)) {
                    echo "<option value='" . $paciente['id'] . "'>" . $paciente['nome'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label>Medicamento</label>
            <input type="text" name="medicamento" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Data de Administração</label>
            <input type="date" name="data_administracao" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Hora de Administração</label>
            <input type="time" name="hora_administracao" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Dose</label>
            <input type="text" name="dose" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar Receita</button>
    </form>
</div>
</body>
</html>
