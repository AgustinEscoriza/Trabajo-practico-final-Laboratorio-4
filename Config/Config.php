<?php namespace Config;

define("ROOT", dirname(__DIR__) . "/");
//Path to your project's root folder
define("FRONT_ROOT", "/Trabajo-practico-final-Laboratorio-4 jueves 29/");
define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");

define("API_ROOT", "https://api.themoviedb.org/3/");
define("API_KEY", "?api_key=ac2b338077edff8c77e3671b8dbc9930");
define("MOVIE_PATH", "movie/");
define("MOVIE_NOW_PLAYING", "now_playing/");
define("IMAGE_ROOT", "https://image.tmdb.org/t/p/w300");
define("LIST_ROOT", "https://api.themoviedb.org/3/genre/movie/list");

define("DB_HOST", "localhost");
define("DB_NAME", "logindatabase");
define("DB_USER", "root");
define("DB_PASS", "localhost");
?>




