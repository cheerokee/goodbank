angular.module("rapidUserApp", []).filter("brdateFilter", function(){
    return function(input) {
        var o = input.replace(/-/g, "/"); // Troca hifen por barra
        return Date.parse(o + " -0000");
    };
})
.controller("rapidUserController",
["$scope","$http","$timeout","$filter", function($scope,$http,$timeout,$filter) {
    $scope.user = {};

    $scope.users = [];

    $scope.user_plan = {};

    $scope.user_plans = [];

    $scope.plans = [];

    $scope.clear = function(){
        $scope.user = {
            id: null,
            sponsor: null,
            name: null,
            email: null,
            document: null,
            phone: null,
            celphone: null,
            birthdate: null
        };

        $scope.user_plan = {
            id: null,
            user: null,
            plan: null,
            approved_date: null
        };
    };

    $scope.save = function() {
        if($scope.user.id == null){
            /** Salvar o usuário **/
            let data = $scope.user;
            data.password = 123;
            data.active = 1;

            $.ajax({
                url: '/api/user',
                type: "POST",
                async: true,
                contentType : 'application/json',
                data: JSON.stringify(data),
                success: function (o) {
                    successNotify("Usuário inserido com sucesso!");
                    $scope.clear();
                    $scope.loadUsers();
                },
                error: function (o) {
                    errorNotify("Houve um erro ao criar usuário!");
                },
                dataType: "json"
            });
        }else{
            $.ajax({
                url: '/api/user/' + $scope.user.id,
                type: "PATCH",
                async: true,
                contentType : 'application/json',
                data: JSON.stringify($scope.user),
                success: function (o) {
                    successNotify("Usuário atualizado com sucesso!");
                    $scope.clear();
                    $scope.loadUsers();
                },
                error: function (o) {
                    errorNotify("Houve um erro ao criar usuário!");
                },
                dataType: "json"
            });
        }
    };

    $scope.edit = function(user) {
        $scope.user = {
            id: user.id,
            sponsor: (user._embedded && user._embedded.sponsor) ? user._embedded.sponsor.id : null,
            name: user.name,
            email: user.email,
            document: user.document,
            phone: user.phone,
            celphone: user.celphone
        };

        let date = user.birthdate.date;
        date = new Date(date);
        $timeout(function () {
            $scope.user.birthdate = date;
        },300);
    };

    $scope.del = function($user_id){
        bootbox.confirm({
            message: "Você deseja realmente excluir esse registro?",
            buttons: {
                cancel: {
                    label: "Não",
                    className: "btn-danger"
                },
                confirm: {
                    label: "Sim",
                    className: "btn-success btnConfirm",
                }
            },
            callback: function (result) {
                if (!result) {
                    this.modal("hide");
                } else {
                    $.ajax({
                        url: "/api/user/" + $user_id,
                        type: "DELETE",
                        dataType: "json",
                        success: function (response) {
                            $timeout(function () {
                                $scope.loadUsers();
                            },300);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            errorNotify("Erro ao excluir o usuário");
                        }
                    });
                }
            }
        });
    }

    $scope.loadUsers = function() {

        $.ajax({
            url: "api/user",
            async: false,
            type: "GET",
            dataType: "json",
            data: {
                'order-by' : [
                    {
                        'type':'field',
                        'field':'id',
                        'direction': 'desc',
                    }
                ]
            },
            success: function (response) {
                $timeout(function () {
                    $scope.users = response._embedded.user;

                    for(index in $scope.users){
                        let user = $scope.users[index];

                        $.ajax({
                            url: "/api/user-plan",
                            type: "GET",
                            data: {
                                "filter"    :   [
                                    {
                                        'type' : 'andx',
                                        'conditions' : [
                                            {'field' :'user', 'type':'eq', 'value' : user.id}
                                        ],
                                        'where'  :  'and'
                                    }
                                ]
                            },
                            async: false,
                            dataType: "json",
                            success: function (response) {
                                if(response._embedded.user_plan.length > 0){
                                    let user_id = response._embedded.user_plan[0]._embedded.user.id;

                                    // Procurando no meio do array de usuários, o id que bate com o id do aporte pesquisado
                                    let i = $scope.users.findIndex(x => x.id === user_id);

                                    $timeout(function () {
                                        $scope.users[i].user_plans = response._embedded.user_plan;
                                    },600);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                errorNotify("Erro ao consultar as carteiras bitcoin");
                            }
                        });
                    }

                    console.log($scope.users);
                },300);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify("Erro ao listar os usuários");
            }
        });


    };

    $scope.loadUsers();

    $scope.loadUser = function() {
        $http({
            url: "/api/user/" + $scope.user.id,
            async: false,
            type: "GET",
            dataType: "json"
        }).then(function successCallback(response) {

        });
    };

    $scope.loadPlans = function() {
        $http({
            url: "/api/plan",
            async: false,
            type: "GET",
            dataType: "json"
        }).then(function successCallback(response) {
            console.log(response);
            $timeout(function () {
                $scope.plans = response.data._embedded.plan;
            },300);
        });
    };

    $scope.loadPlans();

    $scope.changeUserPlans = function (user_id) {
        $scope.user_plan = {
            id: null,
            user: null,
            plan: null,
            approved_date: null
        };

        $scope.user_plan.user = user_id;

        $.ajax({
            url: "/api/user-plan",
            type: "GET",
            data: {
                "filter"    :   [
                    {
                        'type' : 'andx',
                        'conditions' : [
                            {'field' :'user', 'type':'eq', 'value' : user_id}
                        ],
                        'where'  :  'and'
                    }
                ]
            },
            async: false,
            dataType: "json",
            success: function (response) {
                $scope.user_plans = response._embedded.user_plan;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify("Erro ao consultar os aportes");
            }
        });
    };

    $scope.editUserPlan = function(user_plan_id) {
        $http({
            url: "/api/user-plan/" + user_plan_id,
            async: false,
            type: "GET",
            dataType: "json"
        }).then(function successCallback(response) {
            $timeout(function () {
                $scope.user_plan.id =  response.data.id;
                $scope.user_plan.id =  response.data.id;
                $scope.user_plan.id =  response.data.id;
                $scope.user_plan.id =  response.data.id;

                $scope.user_plan = {
                    id: response.data.id,
                    user: response.data._embedded.user.id,
                    plan: response.data._embedded.plan.id
                };

                let date = response.data.approved_date.date;
                date = new Date(date);
                $scope.user_plan.approved_date = date;
            },300);
        });
    };

    $scope.saveUserPlan = function() {
        if($scope.user_plan.id == null){
            $.ajax({
                url: "/admin/save-user-plan",
                type: "POST",
                dataType: "json",
                data: $scope.user_plan,
                success: function (response) {
                    if(response.result){
                        successNotify("Aporte salvo com sucesso");
                        $timeout(function () {
                            $scope.changeUserPlans($scope.user_plan.user);
                            $scope.loadUsers();
                        },300);
                    }else{
                        errorNotify("Erro ao salvar o aporte");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    errorNotify("Erro ao salvar o aporte");
                }
            });
        }else{
            $.ajax({
                url: "/admin/save-user-plan",
                type: "POST",
                dataType: "json",
                data: $scope.user_plan,
                success: function (response) {
                    if(response.result){
                        successNotify("Aporte atualizado com sucesso");
                        $timeout(function () {
                            $scope.changeUserPlans($scope.user_plan.user);
                        },300);
                    }else{
                        errorNotify("Erro ao atualizar o aporte");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    errorNotify("Erro ao atualizar o aporte");
                }
            });
        }
    };

    $scope.delUserPlan = function($user_id,user_plan_id){
        bootbox.confirm({
            message: "Você deseja realmente excluir esse registro?",
            buttons: {
                cancel: {
                    label: "Não",
                    className: "btn-danger"
                },
                confirm: {
                    label: "Sim",
                    className: "btn-success btnConfirm",
                }
            },
            callback: function (result) {
                if (!result) {
                    this.modal("hide");
                } else {
                    $.ajax({
                        url: "/api/user-plan/" + user_plan_id,
                        type: "DELETE",
                        dataType: "json",
                        success: function (response) {
                            $timeout(function () {
                                $scope.changeUserPlans($user_id);
                                $scope.loadUsers();
                            },300);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            errorNotify("Erro ao excluir o aporte");
                        }
                    });
                }
            }
        });
    }
}]);
