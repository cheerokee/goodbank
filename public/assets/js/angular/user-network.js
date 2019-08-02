angular.module("user-network", [])
.controller("userNetworkController", ["$scope","$http","$timeout","$filter", function($scope,$http,$timeout,$filter) {

    $scope.user_id = $('#user').val();
    $scope.searchInput = "";

    $scope.user = {};



    $scope.user_links = {};
    $scope.page_user = 1;
    $scope.user_tot_pages = 0;
    $scope.user_pages = [];

    $scope.user_plans = [];
    $scope.user_plan_links = {};
    $scope.page_user_plan = 1;
    $scope.user_plan_tot_pages = 0;
    $scope.user_plan_pages = [];

    $scope.user_plan = {};
    $scope.transactions = [];
    $scope.transaction_links = {};
    $scope.page_transaction = 1;
    $scope.transaction_tot_pages = 0;
    $scope.transaction_pages = [];

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
                    $scope.user_pages = $scope.numberArray(response.page_count);

                    $timeout(function () {
                        $.HSCore.components.HSDropdown.init($('[data-dropdown-target]'), {dropdownHideOnScroll: false});
                        $.HSCore.helpers.HSHamburgers.init('.hamburger');
                    },2000);

                    $scope.user_tot_pages = response.page_count;

                    $scope.user_links = response._links;

                    $scope.users = response._embedded.user;
                    // for(index in $scope.users){
                    //     let user = $scope.users[index];
                    //
                    //
                    //     $.ajax({
                    //         url: "/api/user-plan",
                    //         type: "GET",
                    //         data: {
                    //             "filter"    :   [
                    //                 {
                    //                     'type' : 'andx',
                    //                     'conditions' : [
                    //                         {'field' :'user', 'type':'eq', 'value' : user.id}
                    //                     ],
                    //                     'where'  :  'and'
                    //                 }
                    //             ]
                    //         },
                    //         async: false,
                    //         dataType: "json",
                    //         success: function (response) {
                    //             if(response._embedded.user_plan.length > 0){
                    //                 let user_id = response._embedded.user_plan[0]._embedded.user.id;
                    //
                    //                 // Procurando no meio do array de usuários, o id que bate com o id do aporte pesquisado
                    //                 let i = $scope.users.findIndex(x => x.id === user_id);
                    //
                    //                 $timeout(function () {
                    //                     $scope.users[i].totAportes = response.total_items;
                    //                     $scope.users[i].user_plans = response._embedded.user_plan;
                    //                 },600);
                    //             }
                    //         },
                    //         error: function(jqXHR, textStatus, errorThrown) {
                    //             errorNotify("Erro ao consultar os aportes");
                    //         }
                    //     });
                    // }
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
                $scope.loadCustomerAportes($scope.user_plan_links.prev.href);
                $scope.page_user_plan--;
                break;
        }
    };

    $scope.previous_transactions = function() {
        $scope.loadTransactions($scope.user_plan,$scope.transaction_links.prev.href);
        $scope.page_transaction--;
    };

    $scope.next = function(resource) {
        console.log(resource);
        switch (resource) {
            case "user":
                $scope.loadUsers($scope.user_links.next.href);
                if($scope.page_user != $scope.user_tot_pages){
                    $scope.page_user++;
                }
                break;
            case "user_plan":
                console.log(resource,$scope.user_plan_links.next.href);
                $scope.loadCustomerAportes($scope.user_plan_links.next.href);
                if($scope.page_user_plan != $scope.user_plan_tot_pages){
                    $scope.page_user_plan++;
                }
                break;
        }
    };

    $scope.next_transactions = function() {
        $scope.loadTransactions($scope.user_plan,$scope.transaction_links.next.href);
        $scope.page_transaction++;
    };

    $scope.page = function(pagination,resource) {
        switch (resource) {
            case "user":
                $scope.loadUsers('/api/user?page=' + pagination);
                $scope.page_user = pagination;
                break;
            case "user_plan":
                $scope.loadCustomerAportes($scope.user_plan_links.next.href);
                $scope.page_user_plan = pagination;
                break;
        }
    };

    $scope.page_transactions = function(pagination) {
        $scope.loadTransactions($scope.user_plan,'/api/transaction?page=' + pagination);
        $scope.page_transaction = pagination;
    };

    $scope.selectAportes = function(user) {
        $scope.user = user;
        $.ajax({
            url: '/api/user-plan',
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
                $timeout(function(){
                    $scope.user_plan_links = response._links;
                    $scope.user_plans = response._embedded.user_plan;
                    $scope.user_plan_pages = $scope.numberArray(response.page_count);

                    var ids = [];
                    for(index in $scope.user_plans){
                        ids.push({ id : $scope.user_plans[index].id });
                        $scope.user_plans[index].balance = 0;
                    }

                    $.ajax({
                        url: "/admin/balance",
                        type: "POST",
                        dataType: "json",
                        data: {ids : ids},
                        success: function (response) {
                            var balances = response;
                            for(index in $scope.user_plans){
                                let user_plan = $scope.user_plans[index];
                                $timeout(function () {
                                    $scope.user_plans[index].balance = balances[user_plan.id];
                                },300);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {

                        }
                    });

                    $.ajax({
                        url: "/admin/comission",
                        type: "POST",
                        dataType: "json",
                        data: {id_patrocinador : $scope.user_id, id_indicado: $scope.user.id},
                        success: function (response) {
                            for(index in $scope.user_plans){
                                let user_plan = $scope.user_plans[index];
                                $timeout(function () {
                                    var i = response.findIndex(x => x.user_plan === user_plan.id);
                                    $scope.user_plans[index].comission = response[i].value;
                                    console.log(response[i].value);
                                },300);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {

                        }
                    });
                },300);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify("Erro ao consultar os aportes");
            }
        });
    };

    $scope.loadTransactions = function(user_plan,url = '') {
        $scope.user_plan = user_plan;
        if(url == ''){
            url = "/api/transaction";
        }

        $.ajax({
            url: url,
            type: "GET",
            data: {
                'filter'    :   [
                    {'type' : 'innerjoin', 'field' : 'user_plan', 'alias' : 'up'},
                    {
                        'type' : 'andx',
                        'conditions' : [
                            {'type' : 'eq', 'alias' : 'up', 'field' : 'id', 'value' : user_plan.id},
                            {'field' :'user', 'type':'eq', 'value' : $scope.user_id }
                        ],
                        'where'  :  'and'
                    }

                ],
                'order-by' : [
                    {
                        'type':'field',
                        'field':'date',
                        'direction': 'desc',
                    }
                ]
            },
            dataType: "json",
            success: function (response) {
                $timeout(function(){
                    $scope.transaction_pages = $scope.numberArray(response.page_count);
                    $scope.transaction_tot_pages = response.page_count;
                    $scope.transaction_links = response._links;
                    $scope.transactions = response._embedded.transaction;
                    console.log($scope.transactions);
                },300);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify('Erro ao carregar os aportes');
            }
        });
    };

    $scope.getMonthStr = function(month) {
        month_str = "";

        switch (month) {
            case 1:
                month_str = "Janeiro";
                break;
            case 2:
                month_str = "Fevereiro";
                break;
            case 3:
                month_str = "Março";
                break;
            case 4:
                month_str = "Abril";
                break;
            case 5:
                month_str = "Maio";
                break;
            case 6:
                month_str = "Junho";
                break;
            case 7:
                month_str = "Julho";
                break;
            case 8:
                month_str = "Agosto";
                break;
            case 9:
                month_str = "Setembro";
                break;
            case 10:
                month_str = "Outubro";
                break;
            case 11:
                month_str = "Novembro";
                break;
            case 12:
                month_str = "Dezembro";
                break;
        }

        return month_str;
    };

    $scope.typingTimer = null;
    $scope.doneTypingInterval = 1000;

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
                    $timeout(function () {
                        $.HSCore.components.HSDropdown.init($('[data-dropdown-target]'), {dropdownHideOnScroll: false});
                        $.HSCore.helpers.HSHamburgers.init('.hamburger');
                    },600);
                },600);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify('Erro ao carregar os aportes');
            }
        });
    };

    $scope.numberArray = function(number){
        var arr = [];

        for(var i = 1; i <= number; i++){
            arr.push(i);
        }

        return arr
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

    $scope.formatDate = function(dt)
    {
        if(dt != '') {
            var date = new Date(dt.date);
            return date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
        }else{
            return '';
        }
    };

    $(document).ready(function () {
        setTimeout(function () {
            $.HSCore.components.HSDropdown.init($('[data-dropdown-target]'), {dropdownHideOnScroll: false});
            $.HSCore.helpers.HSHamburgers.init('.hamburger');
        },2000);
    });
}]);
