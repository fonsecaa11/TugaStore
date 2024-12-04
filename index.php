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
        </nav>
    </header>

    <main>
        <section id="catalogo">
            <h2>Catálogo</h2>
            <div class="produtos">
                <div class="produto">
                    <img src="https://via.placeholder.com/150" alt="Camisa de Linho">
                    <h3>Camisa de Linho</h3>
                    <p>€49,90</p>
                </div>
                <div class="produto">
                    <img src="https://via.placeholder.com/150" alt="Saia Tradicional">
                    <h3>Saia Tradicional</h3>
                    <p>€39,90</p>
                </div>
                <div class="produto">
                    <img src="https://via.placeholder.com/150" alt="Lenço Bordado">
                    <h3>Lenço Bordado</h3>
                    <p>€19,90</p>
                </div>
            </div>
        </section>

        <section id="sobre-nos">
            <h2>Sobre Nós</h2>
            <p>A **Roupa Tuga** nasceu da paixão pela moda tradicional portuguesa, valorizando a herança cultural com peças contemporâneas inspiradas nas nossas raízes.</p>
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

    <script src="javascript/script.js"></script>
</body>
</html>

