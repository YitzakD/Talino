<?php $title = $menu['accueil'][$_SESSION['locale']]; ?>

<?php include("partials/_header.php"); ?>

    <div class="todo-line-up" id="ancre_home">

        <div class="logo">

            <h1 class="td_logo"><span class="fa fa-check logo-check"></span><?= WEBSITE_NAME; ?></h1>

        </div>

        <div class="about">

            <p class="about_title"><?= WEBSITE_NAME; ?> est gratuit, souple et c'est un moyen visuel d'organiser ce que vous voulez avec qui vous voulez.</p>

            <p class="about_text">
                Laissez tomber les longs échanges par e-mail, les tableurs obsolètes, les notes auto-collantes qui se décollent et les logiciels compliqués pour gérer vos projets. <?= WEBSITE_NAME; ?> vous permet de voir votre projet dans son ensemble en un clin d'oeil.
            </p>

            <p class="about_btn"><a href="#ancre_register">Inscrivez-vous, c'est gratuit.</a></p>

            <p class="about_con"><a href="#ancre_login">Se connecter...</a></p>

        </div>

    </div>

    <div class="todo-line-up"  id="ancre_register">

        <?php include "partials/_register.form.php"; ?>

    </div>

    <div class="todo-line-up" id="ancre_login">

        <?php include "partials/_login.form.php"; ?>

    </div>

    <div class="todo-line-up" id="ancre_contact">

        <?php include "partials/_home.footer.php"; ?>

    </div>

<?php include("partials/_footer.php"); ?>