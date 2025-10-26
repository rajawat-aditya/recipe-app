<?php

class Head{
    public static function render(String $title = "Kith | Powered by Slew"): void {
        ?>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <base href="/">
            <title><?php echo $title; ?></title>
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
            rel="stylesheet">
            <link rel="stylesheet" href="/static/output.css">
             <link rel="icon" type="image/x-icon" href="/static/fav.png">
             <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
            <link rel="stylesheet"
                href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://api.fontshare.com/v2/css?f[]=aktura@400&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
         <?php
    }
}

?>
