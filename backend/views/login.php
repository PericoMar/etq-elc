<div class="main-login">
    <img src="public/img/etiquetas-electronicas-expfoarm-8.webp" alt="Etiquetas electronicas" class="img-etq">
    <section class="login-form">
        <form action="index.php" method="post" class=login>
        <h1>Inicia sesión</h1>
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" placeholder="Usuario" class="input input-user">
            <label for="password">Contraseña:</label>
            <div class="input-wrapper">
                <input type="password" class="input password" placeholder="Contraseña" data-lpignore="true" id="input-pwd" id="passwd" name="passwd">
                <img class="input-icon password" src="public/img/eye-fill.svg" alt="Show password" id="eye-img-match" id="eye-icon">
            </div>
            <?php
                if(isset($mensaje)){
                    ?>
                    <small class="alert-msg"><?php echo $mensaje ?></small>
                    <?php
                }
            ?>
            <button class=btn-login>Iniciar sesión</button>
        </form>
    </section>
</div>