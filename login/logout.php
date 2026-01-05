<?php
session_start();

session_unset();
session_destroy();

header("Location: https://karrr000.github.io/my-web-demo-FRESH/login.html");