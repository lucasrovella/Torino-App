<?php

    include("./actualizar_sesion.php");
    date_default_timezone_set("America/Argentina/Buenos_Aires");

    include("./conexion.php");
    $usuario_id = $_SESSION['id'];
    $consulta = mysqli_query($conexion, "SELECT COUNT(*) AS contador FROM reservas WHERE usuario_id = '$usuario_id'");
    $reservas = mysqli_fetch_assoc($consulta)["contador"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/general.css">
    <link rel="stylesheet" href="../estilos/index.css">
    <link rel="stylesheet" href="../estilos/modal.css">
    <title>Torino Fútbol: Reservá las mejores canchas</title>
    <style>
        .notificacion_reservas{
            min-height: 40px;
            height: auto;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            box-sizing: border-box;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .error{
            background: red;
            color: white;
        }

        .exito{
            color: white;
            background: #23d366;
        }

        #info_usuario
        {
            background-image: url("../imgs/fondo_contacto5.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        #info_faltas
        {
            background-image: url("../imgs/tarjeta_roja.jpg");
            background-repeat: no-repeat;
            background-size: contain;
            padding: 80px 45px;
            box-sizing: border-box;
        }

        #roja{
            height: 200px;
            width: auto;
            position: absolute;
            right: 0;
        }

        .niveles_container{
            justify-content: space-between;
        }

        .titulo_info
        {
            font-weight: bold;
            font-size: 3rem;
            text-shadow: 1px 1px 10px black;
        }

        .texto_info
        {
            font-weight: bold;
            font-size: 4rem;
            text-shadow: 1px 1px 10px black;
        }

        #texto_faltas
        {
            color: white;
            font-weight: normal;
            font-size: 1.5rem;
            text-shadow: 1px 1px 10px black;
        }

        .reserva, .reserva_perdida
        {
            padding: 15px;
            border-radius: 10px;
            font-size: 1.8rem;
            box-sizing: border-box;
            font-weight: bold;
            margin-bottom: 8px;
            cursor: default;
        }

        .reserva{
            color: white;
            background-color: #a177ff;
        }

        .reserva_perdida{
            color: white;
            background-color: red;
        }

        .reserva:hover{
            background-color: #5f18ff;
        }

        .reserva_perdida:hover{
            background-color: crimson;
        }

        #titulo_reservas
        {
            margin: 10px 0px; 
            color: #8650fe;
            font-weight: bold;
            font-size: 3.2rem;
        }

        #beneficios{
            width: 100%;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 2rem;
            margin-bottom: -14px;
            transition: 1s;
            cursor: pointer;
        }

        #beneficios_container{
            justify-content: space-around;
        }

        .beneficios_inactivo{
            color: #7a7aff;
            background-color: #c9c9ff;
        }

        .beneficios_activo{
            background-color: #5f22e3;
            color: white;
        }

        .icono_info{
            height: 32px;
            margin-right: 15px;
        }

        .btn_triangulo{
            height: 14px;
            width: 25px;
            margin-left: 10px;
            margin-top: 5px;
            transition: 0.2s;
        }

        #panel_usuario{
            height: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 45px;
            box-sizing: border-box;
            background-image: url("../imgs/fondo_contacto5.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        #usuario{
            width: 380px;
            height: 250px;
            padding: 40px;
            /* font-size: 2.8rem; */
            background-color: white;
            border-radius: 10px;
            font-weight: 400;
        }

        #reservas{
            width: 58%;
            max-width: 750px;
            height: 250px;
            padding: 40px;
            margin-left: 20px;
            font-size: 3rem;
            background-color: white;
            border-radius: 10px;
        }

        #reservas_responsive{
            display: none;
            padding: 20px 30px 0px 30px;
            margin-top: 10px;
        }

        #container_reservas{
            width: 100%;
            margin-top: 20px;
            box-sizing: border-box;
        }

        #container_reservas_responsive{
            padding: 20px 10px;
            box-sizing: border-box;
            background-color: white;
            border-radius: 10px;
        }

        #titulo_usuario{
            margin: 0;
            margin-bottom: -24px;
        }
        
        #avisar_senia{
            display: block;
            width: 500px;
            margin: auto;
            font-size: 3rem;
            color: #8650fe;
            text-align: center;
            margin-top: 45px;
            margin-bottom: -20px;
        }

        #wpp_web_senia{
            color: white;
            background: #23d366;
            padding: 17px;
            border-radius: 30px;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            font-size: 2.5rem;
        }

        #wpp_web_senia:hover{
            background: seagreen;
        }

        #wpp_logo{
            width: 25px; 
            filter:invert(1);
            margin-right: 10px;
        }

        .datos_panel_usuario{
            display: flex;
            align-items: center;
            margin-bottom: 3px;
        }

        @media(min-width: 1390px){
            #beneficios_container{
                padding: 45px 0px;
            }

            .niveles_container{
                justify-content: center;
            }

            .item_nivel{
                width: 370px;
                margin: 20px;
                height: 300px;
            }

            #info_faltas{
                padding: 100px 45px;
            }
        }

        @media(max-width: 1300px)
        {
            .item_texto td{
                font-size: 1.4rem;
            }
        }
        
        @media(max-width: 1250px){
            .item_nivel{
                height: 300px;
            }

            #reservas{
                width: 55%;
                height: 200px;
                padding: 15px 20px;
                font-size: 2rem;
            }

            .reserva{
                padding: 10px;
                font-size: 1.4rem;
            }

            #panel_usuario{
                height: 280px;
            }

            #titulo_usuario{
                font-size: 2rem;
            }

            #usuario{
                padding: 15px 25px;
                width: 35%;
                font-size: 2rem;
                height: 200px;
            }

            #avisar_senia{
                font-size: 2.5rem;
                width: 400px;
            }

            #wpp_web_senia{
                font-size: 1.8rem;
            }
        }

        @media(max-width: 970px)
        {
            #reservas{
                display: none;
            }

            #reservas_responsive{
                display: block;
                text-align: center;
            }

            #usuario{
                width: 60%;
            }

            #avisar_senia{
                width: 320px;
                font-size: 2rem;
                margin-bottom: 0;
            }

            #wpp_web_senia{
                padding: 17px;
                font-size: 1.7rem;
            }

            #wpp_logo{
                width: 20px;
                filter: invert(1);
                margin-right: 5px;
            }


        }

        @media(max-width: 650px)
        {
            #beneficios{
                height: 70px;
            }

            .bienvenido
            {
                font-size: 2.5rem;
                background-image: url("../imgs/jugador_pelota7.png");
            }

            .item_nivel{
                height: 200px;
            }

            .item_texto{
                font-size: 1.2rem;
            }

            #panel_usuario{
                justify-content: center;
            }

            #usuario{
                width: 85%;
                font-size: 1.7rem;
            }

            .texto_info{
                font-size: 2.7rem;
            }

            .titulo_info{
                font-size: 3.2rem;
            }

            #texto_faltas{
                font-size: 1.2rem;
            }

            #titulo_reservas{
                font-size: 2.4rem;
                /* text-align: center; */
            }

            .reserva, .reserva_perdida{
                font-size: 1.2rem;
                /* text-align: center; */
            }

            .item_nivel{
                height: 280px;
            }

            .info_container{
                padding: 45px 12px;
            }
        }

        @media(max-width: 425px){
            #panel_usuario{
                justify-content: center;
                padding: 20px 0px;
                height: auto;

            }

            #usuario{
                width: 80%;
                padding: 30px 20px;
            }


            #info_faltas{
                background-image: url("../imgs/roja.png");
            }

            #texto_niveles{
                font-size: 1rem;
            }

            .titulo_info{
                font-size: 2.5rem;
            }

            .texto_info{
                font-size: 2rem;
            }

            .texto_faltas{
                font-size: 1rem;
            }

            .icono_info{
                height: 28px;
            }
        }

        @media(max-width: 360px){
            #titulo_reservas{
                font-size: 2rem;
            }

            .reserva, .reserva_perdida{
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php 
        if(isset($_GET["exceso_reservas"])){
            echo "<div class='notificacion_reservas error'>¡No podés tener más de 3 reservas pendientes!</div>";
        }
        if(isset($_GET["superposicion_reservas"])){
            echo "<div class='notificacion_reservas error'>¡Ya tenés una reserva en el mismo día y horario!</div>";
        }
        if(isset($_GET["reserva_no_disponible"])){
            echo "<div class='notificacion_reservas error'>¡La reserva ya no está disponible!</div>";
        }
        if(isset($_GET["reserva_confirmada"])){
            echo "<div class='notificacion_reservas exito'>¡La reserva fue confirmada con éxito!</div>";
        }
    ?>
    <main>
        <section id="panel_usuario">
            <article id="usuario" class="texto_2">
                <h1 class="titulo_3 violeta" id="titulo_usuario"><?php echo $_SESSION["nombre"] . " " . $_SESSION["apellido"] ?></h1><br>
                    <div class="datos_panel_usuario"><img src="../imgs/level2.png" alt="Icono Falta" class="icono_info"> Nivel: <?php echo $_SESSION["nivel"] ?></div>
                    <div class="datos_panel_usuario"><img src="../imgs/calendario.png" alt="Icono Falta" class="icono_info"> Reservas: &nbsp;<span style="color:#8650fe"><?php echo $reservas ?></span> </div>
                    <div class="datos_panel_usuario"><img src="../imgs/check.png" alt="Icono Falta" class="icono_info"> Asistencias: &nbsp;<span style="color:#8650fe"><?php echo $_SESSION["racha"] ?></span> </div>
                    <div class="datos_panel_usuario"><img src="../imgs/falta.png" alt="Icono Falta" class="icono_info"> Faltas: &nbsp;<span style="color: red;"><?php echo $_SESSION["faltas"]?></span></div>
                    <div class="datos_panel_usuario"><img src="../imgs/simbolo_dinero.png" alt="icono_saldo_a_favor" class="icono_info"> Saldo a Favor: &nbsp;<span style="color: #23d366;">$<?php echo $_SESSION["saldo_a_favor"]?></span></div>
            </article>
            <article id="reservas">
                <span class="titulo_3 violeta">Tus próximas reservas</span>
                <div id="container_reservas">
                    
                    <?php include("./reservas_pendientes.php") ?>
                </div>
            </article>
        </section>
        
        <section id="reservas_responsive">
            <p id="titulo_reservas">Tus próximas reservas</p>
            <div id="container_reservas_responsive">
                <?php include("./reservas_pendientes.php") ?>
            </div>
        </section>
        
        <section id="avisar_senia">
            <div style="font-weight: bold;">Si tenés alguna consulta...</div>
            <a id="wpp_web_senia" href="https://wa.me/1159807762/?text=Hola!%20Me%20comunico%20para%20hacer%20una%20consulta" target="_blank"><img src="../imgs/wppLogo.png" id="wpp_logo" alt="Logo Whatsapp">Comunicate con nosotros</a>
        </section>

        <?php include("./niveles.php") ?>

        <br>
        <div style="background: black;">
            <section id="info_faltas">
                <div class="titulo_info" style="color: white;">
                    Evitá la roja
                </div>
                <div id="texto_faltas">
                    Los beneficios que otorgamos exigen un compromiso mutuo. <br>
                    Para mantener tu nivel de beneficios no podés tener más de 3 faltas.<br> 
                    Por cada vez que canceles fuera del tiempo reglamentario sumás una falta. 
                </div>
            </section>
        </div>

    </main>
    <?php include("./footer.php") ?>
</body>
</html>
<?php include("./nav_desplegable.php") ?>
<script>
    // var navbar_desplegable = document.querySelector(".navbar_desplegable");

    var container_reservas = document.getElementById("container_reservas");
    var beneficios_container = document.getElementById("beneficios_container");
    var img = document.getElementById("btn_beneficios");
    // var flag = false;
    var flag_beneficios = false;

    //Cuando mediante PHP no se pueda detectar que no hay reservas pendientes,
    //que es en el caso en que habían reservas pendientes para ese día pero ya pasó la hora,
    //se detecta mediante JavaScript con este código
    if(container_reservas.childElementCount == 0){
        var div = document.createElement("div");
        div.className = "reserva";
        div.innerHTML = "No tenés reservas pendientes...";
        container_reservas.appendChild(div);
    }
</script>
