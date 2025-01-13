<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Conexão com a base de dados
include ('conn.php');

// Obtém o filtro atual, se existir
$filtro = isset($_GET['status']) ? $_GET['status'] : '';

// Prepara a consulta com base no filtro
$sql = "SELECT id, cliente, produto, quantidade, estado FROM orders";
if ($filtro) {
    $sql .= " WHERE estado = $estado";
}

$stmt = $conn->prepare($sql);

if ($filtro) {
    $stmt->bind_param("s", $filtro);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir Encomendas</title>
    <link rel="stylesheet" href="encomendas_style.css">
</head>
<body>
    <h1>Gerir Encomendas</h1>

    <!-- Filtros -->
    <div class="filter">
        <a href="gerir_encomendas.php" class="<?= !$filtro ? 'active' : '' ?>">Todas</a>
        <a href="gerir_encomendas.php?status=Aceite pela transportadora" class="<?= $filtro === 'Aceite pela transportadora' ? 'active' : '' ?>">Aceites pela transportadora</a>
        <a href="gerir_encomendas.php?status=Seguido para entrega" class="<?= $filtro === 'Seguido para entrega' ? 'active' : '' ?>">Seguido para entrega</a>
        <a href="gerir_encomendas.php?status=Entregue" class="<?= $filtro === 'Entregue' ? 'active' : '' ?>">Entregues</a>
    </div>

    <!-- Tabela de Encomendas -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['cliente'] ?></td>
                    <td><?= $row['produto'] ?></td>
                    <td><?= $row['quantidade'] ?></td>
                    <td><?= $row['estado'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php $stmt->close(); $conn->close(); ?>
</body>
</html>
