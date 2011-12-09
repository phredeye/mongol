<?php
/**
 * HomePage
 *
 * @author Fred Isaacs
 */
$app->get("/", function() use ($app) {
    $app->render("home.phtml");
});
