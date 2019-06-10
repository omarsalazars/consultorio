<!doctype html>
<html lang="en">
    <head>
        <?php require 'view/assets.php' ?>
    </head>

    <body ng-app="myApp">
        <?php require 'view/header.html'; ?>

        <div ng-view style="margin-top:30vh;"></div>

        <?php require 'view/footer.html'; ?>

    </body>
</html>