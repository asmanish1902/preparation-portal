<?php

function vite_css(): string
{
    return '<link rel="stylesheet" href="/build/assets/app.css">';
}

function vite_js(): string
{
    return '<script type="module" src="/build/assets/app.js"></script>';
}
