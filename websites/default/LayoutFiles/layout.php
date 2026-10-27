<!DOCTYPE html>
<html>
    <head> 
        <title><?=$title?></title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/uon.css">
    </head>
    <body>
        <header>
             <img src="/logo.jpg" alt="logo" />
            <!-- including the navigation file as part of the layout file, so that when the layout file is ran, the design.php file also runs -->
            <?php require '/websites/default/LayoutFiles/navigation.php'; ?>
        </header>

       <section>
       </section>

        <main>
            <?= $content ?>
        </main>
        
        <!-- including the design file as part of the layout file, so that when the layout file is ran, the design.php file also runs -->
         <?php require '/websites/default/LayoutFiles/design.php'; ?>
    </body>
</html>