angular.module("user-network", [])
.controller("userNetworkController", ["$scope","$http","$timeout","$filter", function($scope,$http,$timeout,$filter) {

    $scope.user_id = $('#user').val();
    $scope.searchInput = "";

    $scope.user = {};

    $scope.user_plans = [];

    $scope.user_links = {};
    $scope.page_user = 1;
    $scope.user_tot_pages = 0;

    $scope.user_plan_links = {};
    $scope.page_user_plan = 1;
    $scope.user_plan_tot_pages = 0;

    $scope.loadUsers = function(url = '') {
        if(url == ''){
            url = "/api/user";
        }

        $.ajax({
            url: url,
            type: "GET",
            data: {
                'filter'    :   [
                    {
                        'type' : 'andx',
                        'conditions' : [
                            {'field' :'sponsor', 'type':'eq', 'value' : $scope.user_id}
                        ],
                        'where'  :  'and'
                    }
                ],
                'order-by' : [
                    {
                        'type':'field',
                        'field':'id',
                        'direction': 'desc',
                    }
                ]
            },
            dataType: "json",
            success: function (response) {
                $timeout(function(){
                    $scope.user_tot_pages = response.page_count;
                    $scope.user_links = response._links;

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
                                        $scope.users[i].totAportes = response.total_items;
                                        $scope.users[i].user_plans = response._embedded.user_plan;
                                    },600);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                errorNotify("Erro ao consultar os aportes");
                            }
                        });
                    }
                },600);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify('Erro ao carregar os usuários');
            }
        });
    };
    $scope.loadUsers();

    $scope.previous = function(resource) {
        switch (resource) {
            case "user":
                $scope.loadUsers($scope.user_links.prev.href);
                $scope.page_user--;
                break;
            case "user_plan":
                $scope.loadUserPlans($scope.user_plan_links.prev.href);
                $scope.page_user_plan--;
                break;
        }
    };

    $scope.next = function(resource) {
        switch (resource) {
            case "user":
                $scope.loadUsers($scope.user_links.next.href);
                $scope.page_user++;
                break;
            case "user_plan":
                $scope.loadUserPlans($scope.user_plan_links.next.href);
                $scope.page_user_plan++;
                break;
        }
    };

    $scope.page = function(pagination,resource) {
        switch (resource) {
            case "user":
                $scope.loadUsers($scope.user_links.next.href);
                $scope.page_user++;
                break;
            case "user_plan":
                $scope.loadUserPlans($scope.user_plan_links.next.href);
                $scope.page_user_plan++;
                break;
        }
    };

    $scope.selectAportes = function(user) {
        console.log(user);
        $scope.user = user;
        $.ajax({
            url: "/api/user-plan",
            type: "GET",
            data: {
                "filter"    :   [
                    {
                        'type' : 'andx',
                        'conditions' : [
                            {'field' :'user', 'type':'eq', 'value' : $scope.user.id}
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

    $scope.typingTimer = null;
    $scope.doneTypingInterval = 5000;

    $scope.doneTyping = function() {
        $.ajax({
            url: "/api/user",
            type: "GET",
            data: {
                'filter'    :   [
                    {
                        'type' : 'andx',
                        'conditions' : [
                            {'field' :'sponsor', 'type':'eq', 'value' : $scope.user_id },
                            {'field' :'name', 'type':'like', 'value' : "%" + $scope.searchInput + "%" }
                        ],
                        'where'  :  'and'
                    }
                ],
                'order-by' : [
                    {
                        'type':'field',
                        'field':'id',
                        'direction': 'desc',
                    }
                ]
            },
            dataType: "json",
            success: function (response) {
                $timeout(function(){
                    $scope.users = response._embedded.user;
                    console.log($scope.users);
                },600);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify('Erro ao carregar os aportes');
            }
        });
    };

    $scope.keyUpSearch = function() {
        clearTimeout($scope.typingTimer);
        $scope.typingTimer = $timeout(function () {
            $scope.doneTyping();
        },$scope.doneTypingInterval);
    };

    $scope.keyDownSearch = function () {
        clearTimeout($scope.typingTimer);
    };

    $(document).ready(function () {
        setTimeout(function () {
            $.HSCore.components.HSDropdown.init($('[data-dropdown-target]'), {dropdownHideOnScroll: false});
            $.HSCore.helpers.HSHamburgers.init('.hamburger');
        },2000);
    });
}]);
