<?php
// Conexão com a base de dados
include('conn.php');

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    echo "Erro ao aceder à base de dados: $e";
}

// Consultas para obter os produtos
$top_vendas_query = "SELECT nome, preco, imagem FROM produto LIMIT 1";
$top_vendas_result = $conn->query($top_vendas_query);

$ultimas_roupas_query = "SELECT nome, preco, imagem FROM produto LIMIT 3";
$ultimas_roupas_result = $conn->query($ultimas_roupas_query);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuga Store</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Tuga Store</div>
            <ul class="menu">
                <li><a href="#catalogo">Catálogo</a></li>
                <li><a href="#sobre-nos">Sobre Nós</a></li>
                <li><a href="#contactos">Contactos</a></li>
            </ul>
            <div class="login-icon">
                <a href="login.php">🔒 Login</a>
            </div>
        </nav>
    </header>

    <main>
        <section id="catalogo">
            <h2>Catálogo</h2>

            <div class="top-vendas">
                <h3>Top 3 Vendas</h3>
                <div class="produtos">
                    <?php
                    if ($top_vendas_result->num_rows > 0) {
                        while ($row = $top_vendas_result->fetch_assoc()) {
                            echo "<div class='produto'>";
                            echo "<img src='image/" . $row['imagem'] . "' alt='" . $row['nome'] . "'>";
                            echo "<h4>" . $row['nome'] . "</h4>";
                            echo "<p>€" . $row['preco'] . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Nenhum produto encontrado.</p>";
                    }
                    ?>
                </div>
            </div>

            <div class="ultimas-roupas">
                <h3>Últimas Roupas Adicionadas</h3>
                <div class="produtos">
                    <?php
                    if ($ultimas_roupas_result->num_rows > 0) {
                        while ($row = $ultimas_roupas_result->fetch_assoc()) {
                            echo "<div class='produto'>";
                            echo "<img src='image/" . $row['imagem'] . "' alt='" . $row['nome'] . "'>";
                            echo "<h4>" . $row['nome'] . "</h4>";
                            echo "<p>€" . $row['preco'] . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Nenhuma roupa adicionada recentemente.</p>";
                    }
                    ?>
                </div>
            </div>
        </section>

        <section id="sobre-nos">
            <h2>Sobre Nós</h2>
            <p>A <strong>Roupa Tuga</strong> nasceu da paixão pela moda tradicional portuguesa, valorizando a herança cultural com peças contemporâneas inspiradas nas nossas raízes.</p>
        </section>

        <section id="contactos">
            <h2>Contactos</h2>
            <form id="contact-form">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="mensagem">Mensagem:</label>
                <textarea id="mensagem" name="mensagem" required></textarea>

                <button type="submit">Enviar</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Roupa Tuga. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
