<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

//Para la parte de administracion de la cita
function esUltimo($actual, $proximo): bool
{
    if ($actual !== $proximo) {
        return true;
    }
    return false;
}

//Funcion que revisa que el usuario este autenticado
function isAuth()
{
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

//Funcion que revisa que el usuario este autenticado
function isAdmin()
{
    if (!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}

