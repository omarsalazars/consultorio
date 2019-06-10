var app = angular.module("myApp", ["ngRoute","ngStorage"]);
app.config(function($routeProvider){
    $routeProvider
    .when("/",{
        templateUrl : "view/indexView.html"
    })
    .when("/about",{
        templateUrl : "view/about.html",
        controller : "aboutController"
    })
    .when("/blog",{
        templateUrl : "view/blog.html"
    })
    .when("/contact",{
        templateUrl : "view/contact.html"
    })
    .when("/elements",{
        templateUrl : "view/elements.html"
    })
    .when("/doctors",{
        templateUrl : "view/doctors.html"
    })
    .when("/departments",{
        templateUrl : "view/departments.html"
    })
    .when("/services",{
        templateUrl : "view/services.html"
    })
    .when("/login",{
        templateUrl : "view/login.html",
        controller: "loginController"
    })
    .when("/signin",{
        templateUrl : "view/signin.html",
        controller : "signinController"
    });
});

app.run(function($rootScope, $http, $location, $localStorage, $templateCache){
    // keep user logged in after page refresh
    if ($localStorage.currentUser) {
        $http.defaults.headers.common.Authorization = 'Bearer ' + $localStorage.currentUser.token;
    }

    // redirect to login page if not logged in and trying to access a restricted page
    $rootScope.$on('$locationChangeStart', function (event, next, current) {
        var publicPages = ['/login','/','/signin'];
        var restrictedPage = publicPages.indexOf($location.path()) === -1;
        console.log($location.path());
        if (restrictedPage && !$localStorage.currentUser) {
            $location.path('/');
        }
    });
});

app.controller("aboutController",function($scope){
    
});

app.controller('loginController',function($scope, $location, AuthenticationService){
    $scope.login = function(){
        $scope.loading = true;
        AuthenticationService.Login($scope.email,$scope.password, function(result){
            if (result === true) {
                alert("si brou");
                $location.path('/');
            } else {
                alert("nel brou");
                $scope.error = 'Username or password is incorrect';
                $scope.loading = false;
            } 
        });
    }

    initController();

    function initController() {
        // reset login status
        AuthenticationService.Logout();
    }
});

app.controller("signinController",function($location,$scope,$http){
    $scope.signin = function(){
        $http({
            method : "POST",
            url : "http://localhost/consultorio/api/paciente/create.php",
            headers: {
                "Accept": "application/json;charset=utf-8",
            },
            dataType:"json",
            data : {
                nombre : $scope.nombre,
                apellidos : $scope.apellidos,
                fechaNacimiento : formatDate($scope.fechaNacimiento),
                peso : $scope.peso,
                telefono : $scope.telefono,
                email : $scope.email,
                password : $scope.password
            }
        }).then(
            function success(response){
                $scope.data = response.data;
                alert('Tu usuario se ha creado correctamente. Inicia sesión para continuar');
                $window.location.href = 'consultorio/!#/login';
            },
            function error(response){
                $scope.data = response.statusText;
                alert('Ocurrió un error inesperado al crear tu cuenta, vuelve a intentarlo más tarde.');
                console.log(response);
            }
        );
    }
});

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}