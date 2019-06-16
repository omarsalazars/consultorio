<!doctype html>
<html lang="en">
    <head>
        <?php require 'view/assets.html'; ?>
    </head>

    <body ng-app="myApp">
        <header ng-include src="'view/header.html'"></header>
        <ng-view></ng-view>
        <?php require 'view/footer.html'; ?>
    </body>
</html>