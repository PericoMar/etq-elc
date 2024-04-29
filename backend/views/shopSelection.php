<section class="shop-selection">
    <?php
        if(!$tiendas){
            ?>
            <div class="alert-contact">
                <img src="../public/img/exclamation-circle.svg" alt="alert" class="img-alert">
                <h1>No tienes tiendas que gestionar</h1>
                <p>Para cualquier gestión: <a href="">+34 628198745</a></p>
            </div>
            <?php
        } else {
    ?>
    <form action="<?php echo $this->baseUrl ?>/seleccion-tienda/" method=post class="form-shop">
        <header>
            <img src="../public/img/shop.svg" alt="Tienda" class="img-shop">
            <h1>Selecciona la tienda a gestionar</h1>
        </header>
        <select name="tienda" id="tiendas" class="select-shop">
            <?php
                foreach($tiendas as $tienda){
                    ?>
                    <option value="<?php echo $tienda['tienda_id'] ?>"><?php echo $tienda['nombre_tienda'] ?></option>
                    <?php
                }
            ?>
        </select>
        <?php
            if(isset($mensaje)){
                ?>
                    <small class="alert-msg"><?php echo $mensaje ?></small>
                <?php
            }
        ?>
        <button class="btn-login">Seleccionar Tienda</button>
    </form>
    <?php
        }
    ?>
</section>