var app = angular.module("MyApp", ['ngMaterial', 'ngPDFViewer', 'ui-notification']);

app.config(function(NotificationProvider) {
    NotificationProvider.setOptions({
       delay: 10000,
        startTop: 20,
        startRight: 10,
        verticalSpacing: 20,
        horizontalSpacing: 20,
        positionX: 'right',
        positionY: 'top'
    });
});

app.controller("Header", function ($scope, $http, Notification, $interval) {
    $scope.titre = "Titre brut";
		$scope.notif = "";

    $scope.listNotfis = [];
    
    $interval(function() { 
			$http.get('../serveur/php/getNotifs.php').then(function(reply) {
        for (var i = 0; i < reply.data.length; i++) {
            $scope.listNotfis.push( {
                exp: reply.data[i]['exp'],
                notif: reply.data[i]['notif']
            } );
        }
        $scope.notif = i;
			});
		}, 2000);
    
    $scope.notification = function() {
        if ($scope.notif != "") {
            for (var i = 0; i < parseInt($scope.notif); i++) {
                Notification($scope.listNotfis[i].notif);
            }
            $scope.notif = "";
        }
    }
    
    $http.get('../serveur/php/header.php').then(function(reply) {
	console.log(reply.data);
	   $scope.nom = reply.data['nom'];
	   $scope.prenom = reply.data['prenom'];
	   var xp_brut = reply.data['xp'];
	   $scope.level = (xp_brut - xp_brut % 100) / 100 + 1;
	   $scope.xp = xp_brut % 100;
	   $scope.img = reply.data['img'];
        $scope.role = reply.data['role'];
	   if ($scope.level == 1)
           $scope.titre = "Debutant";
	   else if ($scope.level == 2)
	       $scope.titre = "Heli-Coopteur";
	   else if ($scope.level == 3)
           $scope.titre = "Cooptant-Content";
	   else if ($scope.level == 4)
	       $scope.titre = "The Serial-Coopteur";
        else if ($scope.level == 5)
            $scope.titre = "Pharaon des Cooptes";
        else
            $scope.titre = "Administrateur de génie";
    }, function(reply) {
        console.log("Connexion faill");
    });
 
    $scope.deconnexion = function() {
	$http.get('../serveur/php/deconnexion.php').then(function(reply) {
	    location.href = "../index.html";
	});
    };
    
});


/* ############################################ */
/* ############# DIRECTIVE COOTPANT ########### */
/* ############################################ */


app.directive("cooptant", function () {
    return{
	templateUrl: "template_cooptant.html"
    };
});

app.controller('ctrlCooptee', function($scope, $http, $mdDialog, $interval) {

	$scope.cooptes = [];
    
    $scope.tmpStatut = "";
    
	$http.get('../serveur/php/coopte.php').then(function(reply) {
		for (var i = 0; i < reply.data.length; i++) {
			$scope.cooptes.push({
				lastname: reply.data[i]['lname'],
				firstname: reply.data[i]['fname'],
				origin: reply.data[i]['origin'],
                fromm: reply.data[i]['fromm'],
                commend: reply.data[i]['commend'],
                student: reply.data[i]['student'],
                genre: reply.data[i]['genre'],
                statut: reply.data[i]['statut_cooptant']
			});
		}
	});
    
    $interval(function() {
        $http.get('../serveur/php/coopte.php').then(function(reply) {
           for (var i = 0; i < reply.data.length; i++) {
               $scope.cooptes[i] = {
                lastname: reply.data[i]['lname'],
				firstname: reply.data[i]['fname'],
				origin: reply.data[i]['origin'],
                fromm: reply.data[i]['fromm'],
                commend: reply.data[i]['commend'],
                student: reply.data[i]['student'],
                genre: reply.data[i]['genre'],
                statut: reply.data[i]['statut_cooptant']
               };
           } 
        });
    }, 5000);

	$scope.addCoopte = function($event) {
		$mdDialog.show( {
			targetEvent: $event,
			clickOutsideToClose:true,
			templateUrl: 'template_addcoopte.html',
            locals: {
                listCooptes: $scope.cooptes
            },
			controller: function($scope, $mdDialog, listCooptes, $http) {
                $scope.valider = function() {
                    var coopte = [];
                    coopte = {
                        lastname: $scope.lastname,
                        firstname: $scope.firstname,
                        genre: $scope.genre,
                        commend: $scope.commend,
                        student: $scope.student,
                        fromm: $scope.fromm,
                        origin: $scope.origin
                    };
                    
                    $http.post('../serveur/php/addCoopte.php', coopte).then(function(reply) {
                        console.log('Reussi');
                    }, function(reply) {
				        console.log(reply);
                        console.log('Fail');
                    });
                    listCooptes.splice(0, 0, coopte);
                    $mdDialog.hide();
                }
                
                $scope.cancel = function() {
                    $mdDialog.cancel();
                }
			}
		});
	};

});

/* ####################################*/
/* DIRECTIVE STATS POUR L'ONGLET STATS */
/* ####################################*/

app.directive("stats", function() {
    return {
        templateUrl: "template_stat.html"
    };
});

app.controller('ctrlStat', function($scope) { 
        $scope.check_statut = "false";
        $scope.check_metier = "false";
        $scope.check_agence = "false";

        $scope.printStat = function() { 
          var divContents = $("#stat").html();
          var printWindow = window.open('', '', 'height=400,width=800');
          printWindow.document.write('<html><head><title>Stats</title>');
          printWindow.document.write('</head><body>');
          if ($scope.check_statut == true)
            printWindow.document.write($("#chart_div").html());
          if ($scope.check_metier == true)
            printWindow.document.write($("#chart_div2").html());
          if ($scope.check_agence == true)
            printWindow.document.write($("#chart_div3").html());
          printWindow.document.write('</body></html>');
          printWindow.document.close();
          printWindow.print();
        };
});

/* ############################################ */
/* ############# DIRECTIVE ADMIN ############## */
/* ############################################ */
app.directive("admin", function () {
    return{
	templateUrl: "template_admin.html"
    };
});

app.controller('ctrlAdmin', ['$scope', '$http', '$mdDialog', 'PDFViewerService', 'Notification', function($scope, $http, $mdDialog, pdf, Notification) {  
    $scope.listCoopt = [];
    $scope.listRH = [];
    $scope.selectRH = -1;
    
    $http.get('../serveur/php/listrh.php').then(function(reply) {
       for(var i = 0; i < reply.data.length; i++) {
          $scope.listRH.push( {
              id: i,
              lname: reply.data[i]['lname'],
              fname: reply.data[i]['fname'],
              id_base: reply.data[i]['id']
          }); 
       }
    });

    $http.get('../serveur/php/coopterh.php').then(function(reply) {
       for(var i = 0; i < reply.data.length; i++) {
           $scope.listCoopt.push( {
               id: i,
               coopte_id: reply.data[i]["coopte_id"],
               coopte_lname: reply.data[i]["lname"],
               coopte_fname: reply.data[i]["fname"],
               coopte_cv: reply.data[i]["cv"],
               cooptant_id: reply.data[i]["cooptant_id"],
               cooptant_lname: reply.data[i]["lcoopt"],
               cooptant_fname: reply.data[i]["fcoopt"],
							 origin: reply.data[i]['origin'],
							 fromm: reply.data[i]['fromm']
           } );
       }
    });
    
    $scope.showCV = function($event) {
        $mdDialog.show( {
			targetEvent: $event,
			clickOutsideToClose:true,
            locals: {
                cv: this.coopt['coopte_cv']
            },
			template: '<div>' +
                    '<md-dialog-content>' +
                    '<div class="md-dialog-content">' +
                    '<pdfviewer src="{{cv}}"></pdfviewer>' +
                    '</div>' +
                    '</md-dialog-content>' +
                    '</div>',
			controller: function($scope, $mdDialog, cv) {
                $scope.cv = cv;
			}
		});
    };
    
    $scope.assignRH = function() {
        if (this.selectRH !== -1) {
            var donnee = {
                id_coopte: parseInt(this.coopt['coopte_id']),
                id_rh: parseInt($scope.listRH[this.selectRH]['id_base']),
                id_case: this.coopt['id']
            };
            $http.post('../serveur/php/rhforcoopt.php', donnee).then(function(reply){
                Notification.success("Le coopté a été correctement assigné :)");
                $scope.listCoopt.splice(donnee.id_case, 1);
            });
        }
    };
    
    $scope.addRH = function() {
        if (!$scope.cooptant ||
           $scope.cooptant === "") {
            $scope.erreur_cooptant = "Entrez un login correct.";
        }
        else {
            var donnee = {
                login: $scope.cooptant
            };
            $http.post('../serveur/php/addtoRh.php', donnee).then(function(reply) {
               if(reply.data['Etat'])
                   $scope.erreur_cooptant = "Succes";
                else
                    $scope.erreur_cooptant = "Le login est incorrect.";
            });
        }
    }
}]);


/* ############################################ */
/* ############# DIRECTIVE RH ################# */
/* ############################################ */
app.directive('rh', function() {
    return {
        templateUrl: 'template_rh.html'
    };
});

app.controller('ctrlRH', ['$scope', '$http', 'Notification', function($scope, $http, Notification) {
    // Charge la liste des cooptés assigné au RH qui est connecte
    $scope.listByRH = [];
    
    $http.get('../serveur/php/cooptebyrh.php').then(function(reply) {
        for (var i = 0; i < reply.data.length; i++) {
            $scope.listByRH.push( {
                id: reply.data[i]['id'],
								lastname: reply.data[i]['lname'],
								firstname: reply.data[i]['fname'],
                origin: reply.data[i]['origin'],
                fromm: reply.data[i]['fromm'],
                commend: reply.data[i]['commend'],
                student: reply.data[i]['student'],
                genre: reply.data[i]['genre'],
                job: reply.data[i]['job'],
                statut: reply.data[i]['statut']
            });
        }
    });
    
    
    
    // Charge la liste des jobs depuis le fichier listJobs.php
    $scope.listJobs = [];
    
    $http.get('../serveur/php/listJobs.php').then(function(reply) {
        for (var i = 0; i < reply.data.length; i++) {
            $scope.listJobs.push( {
                id: reply.data[i]['id'],
                name: reply.data[i]['name'],
                index: i
            } );
        }
    });
    
    $scope.listStatuts = [];
    
    $http.get('../serveur/php/listStatuts.php').then(function(reply) {
        for (var i = 0; i < reply.data.length; i++) {
            $scope.listStatuts.push( {
                id: reply.data[i]['id'],
                rh: reply.data[i]['rh'],
                index: i
            });
        }
    });
    
    $scope.upCoopte = function() {
        $scope.listByRH[this.$index].statut = this.selectStatuts;
        $scope.listByRH[this.$index].job = this.selectJobs;
        var donnee = {
          idcoopte: $scope.listByRH[this.$index].id,
            idjob: $scope.listByRH[this.$index].job,
            idstatut: $scope.listByRH[this.$index].statut
        };
        $http.post('../serveur/php/upCoopteByRH.php',donnee).then(function(reply) {
            if(reply.data['Etat'])
                Notification.success('Le coopté a changer de status avec Succés :)');
            else
                Notification.error('Un probleme est survenue, désolé...');
        });
    };
}]);

/* ############################################ */
/* ############# DIRECTIVE COMPTE ############# */
/* ############################################ */

app.directive("compte", function (){
    return{
	templateUrl: "template_compte.html"
    };
});

app.controller('accountCtrl', function ($scope, $http, $mdDialog) {

    $scope.change_mdp = function ($event) {
	$mdDialog.show( {
	    targetEvent: $event,
	    clickOutsideToClose:true,
	    templateUrl: 'change_mdp.html',
	    locals:{
		oldmdp: $scope.oldmp,
		newmdp: $scope.newmdp,
		okmdp: $scope.okmdp
	    },
	    controller: function($scope, $mdDialog, oldmdp, newmdp, okmdp) {
		
		$scope.validemdp = function () {
		    var data = [];
		    data = {
			oldmdp: $scope.oldmdp,
			newmdp: $scope.newmdp,
			okmdp: $scope.okmdp
		    };
		    $http.post('/present/serveur/php/changemdp.php', data).then(function(reply){
			if (!reply.data['Etat'])
			    $scope.error_change_mdp = "Votre ancien mot de passe ou vos nouveaux mots de passe sont incorrect !";
			else
			    $mdDialog.cancel();
		    });								
		}
		
		$scope.closemdp = function() {
		    $mdDialog.cancel();
		}
	    }
	});
    };
});
