<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tuga Store</title>
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
        <section id="login">
            <h2>Login</h2>
            <form action="autenticar.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br><br><br>
                <button type="submit">Entrar</button>
            </form>
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
