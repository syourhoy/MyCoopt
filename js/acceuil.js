$(document).ready(function(){
    $("#Connexion").click(function(){
        $("#Connexion_modal").modal();
    });
});
$(document).ready(function(){
    $("#Inscription").click(function(){
        $("#Inscription_modal").modal();
    });
});

var app = angular.module("index_app", ['ng']);

app.run(function($http) {
    $http.get('serveur/php/header.php').then(function(reply) {
        if (reply.data['Etat'])
            location.href = "html/main.html";
    });
});

app.controller("connexionCtrl", function ($scope, $http, $timeout) {
    
    $scope.connexionClose = function() {
        $timeout(function() {
            $scope.login = "";
            $scope.password = "";
            $scope.etat = "";
        }, 100);
    };
    
    $scope.connexion = function() {
    
        if (!$scope.login ||
            $scope.login === "" ||
            !$scope.password ||
            $scope.password === "")
            $scope.etat = "Champs vide !";
        else {
            var donnee = {
                login: $scope.login,
                mdp: $scope.password
            };
            $http.post('serveur/php/connexion.php', donnee).then(function(reply) {
                if (reply.data['Etat'])
                    location.href = "html/main.html";
                else {
                    $scope.password = "";
                    $scope.etat = "Mot de passe incorrect";
                }
            });
        }
    };

});

app.controller("inscriptionCtrl", function ($scope, $http) {
    
    $scope.closeInscription = function() {  
        $scope.login = "";
        $scope.mail = "";
        $scope.mdp = "";
        $scope.mdp2 = "";
        $scope.fname = "";
        $scope.lname = "";
        $scope.agence = "";
        $scope.erreur_mdp = "";
        $scope.erreur_login = "";
        $scope.erreur_mail = "";
    };
    
	$scope.checkInscription = function () {
        $scope.erreur_mdp = "";
        $scope.erreur_login = "";
        $scope.erreur_mail = "";
        $scope.erreur_agence = "";
        
        if ($scope.login &&
            $scope.mdp &&
            $scope.mdp2 &&
            $scope.mail &&
            $scope.fname &&
            $scope.lname &&
            $scope.agence) {
                if ($scope.mdp != $scope.mdp2) {
                    $scope.erreur_mdp = "Les deux mots de passe ne correspondent pas.";
                    $scope.mdp2 = "";
                }
                else {
                    var donnee = {
                        login: $scope.login,
                        mail: $scope.mail,
                        mdp: $scope.mdp,
                        fname: $scope.fname,
                        lname: $scope.lname,
                        agence: parseInt($scope.agence)
                    };
                    $http.post('serveur/php/inscription.php', donnee).then(function(reply) {
                        if (!reply.data['Etat']) {
                            switch(reply.data['Erreur']) {
                                case 'mail':
                                    $scope.erreur_mail = "Le mail est déjà utilisé.";
                                    break;
                                case 'login':
                                    $scope.erreur_login = "Le login est déjà utilisé.";
                                    break;
                            }
                        }
                        else {
                            var donnee = {
                                login: $scope.login,
                                mdp: $scope.mdp
                            };
                            $http.post('serveur/php/connexion.php', donnee).then(function(reply) {
                                if (reply.data['Etat'])
                                    location.href = "html/main.html";
                                else {
                                    console.error('Connexion echoué');
                                }
                            });
                        }
                    }, function(reply) {
                        console.log("Erreur de script !");
                        console.log(reply.data);
                    });
                }
            }
        else
            $scope.erreur_agence = "Veuillez séléctionner votre agence.";
    };
});
