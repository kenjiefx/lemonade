<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <?php
            if (isTemplate('product-template')) {
                echo '<title>'.data('product')['title'].'</title>';
            } else {
                echo '<title>Testing Template</title>';
            }
        ?>
        <script type="text/javascript">
            <?php toParse('product',data('product')); ?>
        </script>
        <script type="text/javascript" src="/scripts/strawberry.js"></script>
        <link rel="stylesheet" href="/styles/global.css">
    </head>
    <body>
        <?php content(); ?>
    </body>
</html>
