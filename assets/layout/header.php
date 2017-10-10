        <header>
            <h1>ETEC Forum</h1>
        </header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="contato.php">Contato</a></li>
                <li>|</li>
                <?php if(estaAutorizado()): ?>
                    <?php if(estaAutorizado(true)): ?>
                    <li><a href="usuarios.php">Usuários</a></li>
                    <li>|</li>
                    <?php endif ?>
                <li>
                    <a href="logout.php">Logout</a> (<?= $_SESSION['usuario_email'] ?>)
                </li>
                <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="usuario_insert.php">Registrar-se</a></li>
                <?php endif; ?>
                </li>
            </ul>
        </nav>