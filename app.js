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
    })
        .when("/cuenta",{
        templateUrl: "view/account.html",
        controller: "accountController"
    })
        .when("/admin",{
        templateUrl : "view/admin.html",
        controller: "adminController"
    })
        .when("/administrador",{
        templateUrl: "view/administrator.html",
        controller: "administratorController"
    });
});

app.run(function($rootScope, $http, $location, $localStorage, $templateCache){
    // keep user logged in after page refresh
    if ($localStorage.currentUser) {
        $http.defaults.headers.common.Authorization = 'Bearer ' + $localStorage.currentUser.jwt;
        $rootScope.name = $localStorage.currentUser.nombre;
        $rootScope.logged=true;
        $rootScope.admin = $localStorage.currentUser.admin;
    }

    // redirect to login page if not logged in and trying to access a restricted page
    $rootScope.$on('$locationChangeStart', function (event, next, current) {
        var publicPages = ['/login','/','/signin','/admin'];
        var restrictedPage = publicPages.indexOf($location.path()) === -1;
        console.log($location.path());
        if (restrictedPage && !$localStorage.currentUser) {
            $location.path('/');
        }

        if($location.path=='/citas'){
            $('.nav-link').removeClass('active');

        }

    });
});

app.controller("administratorController",function($scope,$http){
    $scope.tabs=[true,false,false,false];

    $http({
        method: 'GET',
        url: 'http://localhost/consultorio/api/cita/read.php'
    }).then(
        function success(response){
            $scope.citas = response.data;
        },
        function error(response){
            console.log(response);
        }
    );

    $http({
        method: 'GET',
        url: 'http://localhost/consultorio/api/paciente/read.php'
    }).then(
        function success(response){
            $scope.pacientes = response.data;
        },
        function error(response){
            console.log(response);
        }
    );
    
    $http({
        method: 'GET',
        url: 'http://localhost/consultorio/api/doctor/read.php'
    }).then(
        function success(response){
            $scope.doctores = response.data;
        },
        function error(response){
            console.log(response);
        }
    );
    
    $http({
        method: 'GET',
        url: 'http://localhost/consultorio/api/administrativo/read.php'
    }).then(
        function success(response){
            $scope.administradores = response.data;
        },
        function error(response){
            console.log(response);
        }
    );

    $scope.deleteCita = function(cita){
        $http({
            method: 'DELETE',
            url: 'http://localhost/consultorio/api/cita/delete.php',
            data: {
                idCita: cita.idCita
            }
        }).then(
            function success(response){
                alert("Cita borrada exitosamente");
                $scope.citas.splice($scope.citas.indexOf(cita),1);

            },
            function error(response){
                alert("Hubo un error borrando la cita");
            }
        );
    }

    $scope.deletePaciente = function(paciente){
        $http({
            method: 'DELETE',
            url: 'http://localhost/consultorio/api/paciente/delete.php',
            data: {
                idPaciente: paciente.idPaciente
            }
        }).then(
            function success(response){
                alert("Paciente borrado exitosamente");
                $scope.pacientes.splice($scope.pacientes.indexOf(paciente),1);

            },
            function error(response){
                alert("Hubo un error borrando al paciente");
            }
        );
    };

    $scope.toggle = function(index){
        for(var i=0;i<$scope.tabs.length;i++){
            $scope.tabs[i]=false;
        }
        $scope.tabs[index]=true;
    }
});

app.controller("adminController",function($scope, $rootScope, $http, AuthenticationService, $location){
    $scope.login = function(){
        $scope.loading = true;
        AuthenticationService.AdminLogin($scope.email,$scope.password, function(result){
            if (result === true) {
                $location.path('/');
            } else {
                alert("nel");
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

app.controller("accountController",function($scope,$rootScope,$http,$localStorage){

    $http({
        method: 'GET',
        url: 'http://localhost/consultorio/api/paciente/read_one.php',
        dataType: 'json',
        params : {
            idPaciente : $localStorage.currentUser.idPaciente
        }
    }).then(
        function success(response){
            $scope.user = response.data;
            $scope.user.peso = parseInt($scope.user.peso);
            $scope.user.telefono = parseInt($scope.user.telefono);
            console.log(response);
            data = {
                nombre : $scope.user.nombre,
                apellidos : $scope.user.apellidos,
                fechaNacimiento : formatDate($scope.user.fechaNacimiento),
                peso : $scope.user.peso,
                telefono : $scope.user.telefono,
                email : $scope.user.email,
                password : $scope.user.password,
                jwt: $localStorage.currentUser.jwt
            };
        },
        function error(response){
            console.log(response);
        }
    );

    $http({
        method : 'GET',
        url : 'http://localhost/consultorio/api/cita/read_by_user.php',
        params: {
            idPaciente : $localStorage.currentUser.idPaciente
        }
    }).then(
        function success(response){
            console.log(response.data);
            $scope.citas = response.data;
        },
        function error(response){
            console.log(response);
        }
    );

    $scope.update = function(){
        $http({
            method: 'PUT',
            url: 'http://localhost/consultorio/api/paciente/update_paciente.php',
            headers: {
                "Accept": "application/json;charset=utf-8",
            },
            dataType:"json",
            data : data
        }).then(
            function success(response){
                $scope.data = response.data;
                alert('Tu información ha sido actualizada');
                $localStorage.currentUser.jwt = response.data.jwt;
            },
            function error(response){
                $scope.data = response.statusText;
                alert('Ocurrió un error inesperado al actualizar tu información, vuelve a intentarlo más tarde.');
                console.log(response);
            }
        );
    };
});

app.controller("headerController",function($scope,$rootScope,AuthenticationService){
    $scope.logout = function(){
        AuthenticationService.Logout();
        $rootScope.logged=false;
    } 
});



app.controller("aboutController",function($scope){

});

app.controller('loginController',function($scope, $location, AuthenticationService){
    $scope.login = function(){
        $scope.loading = true;
        AuthenticationService.Login($scope.email,$scope.password, function(result){
            if (result === true) {
                $location.path('/');
            } else {
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