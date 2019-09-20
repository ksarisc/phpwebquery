<?php
global $page;
?><!DOCTYPE html>
<html>
<head>
    <title><?php $page->title(); ?></title>
</head>
<body>
    <header>
        <h1 class="page-title"><?php $page->title(); ?></h1>
    </header>
    <?php $page->body(); ?></title>
</body>
<link rel="stylesheet" href="/styles/page.css" type="text/css">
<script type="text/javascript" src="/scripts/page.js"></script>
</html>
