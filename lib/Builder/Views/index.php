<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $data['title'] ?? ''?></title>
        <link rel="stylesheet" href="/app/styles/global-css">
        <?php
            if ($data['viewType']==='PREVIEW') {
                echo '<!-- Previewer CSS -->';
                echo '<link rel="stylesheet" href="/app/styles/previewer-css">';
            }
        ?>
        <?php
        /**
         * This state only appears in Preview mode. It checks whether the given template or section
         * is existing.
         */
             if ($data['viewType']==='PREVIEW') {
                 echo '<script type="text/javascript">';
                 $pathToContent = __dir__.$data['contentFor'];
                 if (!file_exists($pathToContent)) {
                    echo 'var Previewer = {status:"error"}';
                } else {
                    echo 'var Previewer = {status:"success"}';
                }
                 echo '</script>';
             }
        ?>
        <?php dumpStaticObjects($data);?>
        <!-- Strawberry JS Atlas Version 1.0.0 -->
        <script type="text/javascript" src="/app/script/strawberry-js"></script>
        <!-- Main JS -->
        <script type="text/javascript" src="/app/script/main-js"></script>
        <!-- jQuery -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!--Font Declarations-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;500;700;800&family=Rubik:wght@300;400;700&display=swap" rel="stylesheet">
        <!--Third Party Library-->
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/moment@2.29.3/moment.min.js"></script>
    </head>
    <body>
        <section id="Loader">
          <div class="wrapper">
            <img class="spinner" src="https://cdn.shopify.com/s/files/1/0560/7466/6159/files/spinner.gif?v=1646281504">
          </div>
        </section>
        <?php
            if ($data['viewType']==='PREVIEW') echo '<app xscope="Previewer">';
            else echo '<app xscope="'.$data['viewType'].'">';
        ?>
            <main xpatch="@PageState" id="main" class="Page wrapper-outer">
                <div class="wrapper-inner">
                    <section xif="PageSvc.state=='success'">
                        <?php contentFor($data); ?>
                    </section>
                    <section xif="PageSvc.state=='error'">
                        <?php module('page-error') ?>
                    </section>
                </div>
            </main>
        <?php echo '</app>'; ?>
    </body>
</html>
