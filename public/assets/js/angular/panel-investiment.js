angular.module("panelInvestmentView", [])
.controller("InvestimentViewController", ["$scope","$http","$timeout","$filter", function($scope,$http,$timeout,$filter) {

    $scope.user_id = $("#user_id").val();
    $scope.aport_btn = true;
    $scope.load_btn = false;
    $scope.renew = false;
    $scope.cash_out = false;
    $scope.enableSolicitation = true;

    $scope.plan  = {};
    $scope.user_plan  = {
        status: 0,
        balance: 0,
        _embedded : {
            wallet : null,
            payment_method: null,
            plan: null,
            user: null
        }
    };
    $scope.user = {};
    $scope.payment_method = {};
    $scope.account = {};

    $scope.plans = [];
    $scope.wallets = [];
    $scope.payment_methods = [];
    $scope.user_plans = [];
    $scope.total_balances = 0;
    $scope.transactions = [];
    $scope.accounts = [];
    $scope.banks = [];

    $scope.comissions = [];
    $scope.total_comission = 0;
    $scope.comission_links = {};
    $scope.page_comission = 1;
    $scope.comission_tot_pages = 0;
    $scope.comission_pages = [];

    $scope.comission = {};
    $scope.comission_transactions = [];
    $scope.comission_transaction_links = {};
    $scope.page_comission_transaction = 1;
    $scope.comission_transaction_tot_pages = 0;
    $scope.comission_transaction_pages = [];

    $scope.receive_method = 0;

    /** Dias disponíveis para solicitar saque **/
    $scope.canDays = [29,30,31,1];

    $scope.loadUser = function() {
        $http({
            url: "/api/user/" + $scope.user_id,
            async: false,
            type: "GET",
            dataType: "json"
        }).then(function successCallback(response) {
            $scope.user = response.data;
            $scope.user_plan._embedded.user = $scope.user;
        });
    };
    $scope.loadUser();

    $scope.loadWallets = function() {
        $.ajax({
            url: "/api/wallet",
            type: "GET",
            data: {
                'filter'    :   [
                    {
                        'type' : 'andx',
                        'conditions' : [
                            {'field' :'user', 'type':'eq', 'value' : $scope.user_id}
                        ],
                        'where'  :  'and'
                    }
                ]
            },
            dataType: "json",
            success: function (response) {
                $scope.wallets = response._embedded.wallet;
                if(response.total_items == 1){
                    $scope.user_plan._embedded.wallet = $scope.wallets[0];
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify('Erro ao carregar as configurações');
            }
        });
    };
    $scope.loadWallets();

    $scope.loadPlans = function() {
        $http({
            url: "/api/plan",
            async: false,
            type: "GET",
            dataType: "json"
        }).then(function successCallback(response) {
            $scope.plans = response.data._embedded.plan;
            $timeout(function () {

                // initialization of charts

            },600);
        });
    };
    $scope.loadPlans();

    $scope.loadPaymentMethods = function() {
        $.ajax({
            url: "/api/payment-method",
            type: "GET",
            dataType: "json",
            success: function (response) {
                $scope.payment_methods = response._embedded.payment_method;
                if(response.total_items == 1){
                    $scope.user_plan._embedded.payment_method = $scope.payment_methods[0];
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify("Houve erro ao carregar as formas de pagamento");
            }
        });
    };
    $scope.loadPaymentMethods();
    $scope.selectPaymentForm = function(payment_method) {
        $scope.user_plan.payment_method = payment_method.id;
        $scope.payment_method = payment_method;
    };

    $scope.loadUserPlans = function() {
        $.ajax({
            url: "/api/user-plan",
            type: "GET",
            data: {
                'filter'    :   [
                    {
                        'type' : 'andx',
                        'conditions' : [
                            {'field' :'user', 'type':'eq', 'value' : $scope.user_id}
                        ],
                        'where'  :  'and'
                    }
                ]
            },
            dataType: "json",
            success: function (response) {
                $scope.user_plans = response._embedded.user_plan;
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
                            $scope.user_plans[index].balance = balances[user_plan.id];
                            $timeout(function () {
                                $scope.total_balances += balances[user_plan.id];
                            },300);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify('Erro ao carregar os aportes');
            }
        });
    };
    $scope.loadUserPlans();

    $scope.loadComissions = function(url = '') {
        if(url == ''){
            url = "/api/user-plan";
        }

        $.ajax({
            url: url,
            type: "GET",
            data: {
                'filter'    :   [
                    {'type' : 'innerjoin', 'field' : 'user', 'alias' : 'u'},
                    {
                        'type' : 'andx',
                        'conditions' : [
                            {'type' : 'eq', 'alias' : 'u', 'field' : 'sponsor', 'value' : $scope.user_id},
                            {'field' :'status', 'type':'eq', 'value' : 1 }
                        ],
                        'where'  :  'and'
                    }
                ]
            },
            dataType: "json",
            success: function (response) {
                $scope.comission_pages = $scope.numberArray(response.page_count);
                $scope.comission_tot_pages = response.page_count;

                $scope.comission_links = response._links;

                $scope.comissions = response._embedded.user_plan;

                if(response.page_count > 0){
                    for(i in $scope.comissions){
                        let comission = $scope.comissions[i];
                        $.ajax({
                            url: "/admin/comission",
                            type: "POST",
                            dataType: "json",
                            data: {id_patrocinador : $scope.user_id, id_indicado: comission._embedded.user.id},
                            success: function (response) {
                                for(index in $scope.comissions){
                                    let user_plan = $scope.comissions[index];
                                    $timeout(function () {
                                        var i = response.findIndex(x => x.user_plan === user_plan.id);
                                        $scope.comissions[index].comission = response[i].value;

                                    },300);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {

                            }
                        });
                    }
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify('Erro ao carregar os aportes');
            }
        });
    };
    $scope.loadComissions();

    $scope.loadTotalComission = function() {
        $.ajax({
            url: "/admin/comission",
            type: "POST",
            dataType: "json",
            data: {id_patrocinador : $scope.user_id},
            success: function (response) {
                for(i in response){
                    $scope.total_comission += response[i].value;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });
    };
    $scope.loadTotalComission();

    $scope.loadComissionTransactions = function(user_plan,url = '') {
        $scope.comission = user_plan;
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
                    $scope.comission_transaction_pages = $scope.numberArray(response.page_count);
                    $scope.comission_transaction_tot_pages = response.page_count;
                    $scope.comission_transaction_links = response._links;
                    $scope.comission_transactions = response._embedded.transaction;
                },300);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify('Erro ao carregar os aportes');
            }
        });
    };

    $scope.previous_comission_transactions = function() {
        $scope.loadComissionTransactions($scope.comission,$scope.comission_transaction_links.prev.href);
        $scope.page_comission_transaction--;
    };

    $scope.next_comission_transactions = function() {
        $scope.loadComissionTransactions($scope.comission,$scope.comission_transaction_links.next.href);
        $scope.page_comission_transaction++;
    };

    $scope.page_comission_transactions = function(pagination) {
        $scope.loadComissionTransactions($scope.comission,'/api/transaction?page=' + pagination);
        $scope.page_comission_transaction = pagination;
    };

    $scope.next_comissions = function() {
        $scope.loadComissions($scope.comission_links.next.href);
        $scope.page_comission++;
    };

    $scope.previous_comissions = function() {
        $scope.loadComissions($scope.comission_links.prev.href);
        $scope.page_comission--;
    };

    $scope.page_comissions = function(pagination) {
        $scope.loadComissions('/api/user-plan?page=' + pagination);
        $scope.page_comission = pagination;
    };

    $scope.loadTransactions = function(user_plan_id) {
        $.ajax({
            url: "/api/transaction",
            type: "GET",
            data: {
                'filter'    :   [
                    {
                        'type' : 'andx',
                        'conditions' : [
                            {'field' :'user_plan', 'type':'eq', 'value' : user_plan_id},
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
                    $scope.transactions = response._embedded.transaction;
                },600);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify('Erro ao carregar os aportes');
            }
        });
    };

    $scope.viewExtract = function(user_plan_id) {
        $scope.loadTransactions(user_plan_id);
    };

    $scope.viewCashOut = function (user_plan) {
        $timeout(function () {
            $scope.user_plan = user_plan;
            $timeout(function () {
                $.HSCore.components.HSRangeSlider.init('.js-range-slider');
            },600);
        },300);

        $scope.loadAccounts();
        $scope.loadWallets();
        $scope.account = {};
        $scope.wallet = {};
        $("#modal_cash_out").modal();
    };

    $scope.loadAccounts = function() {
        $.ajax({
            url: "/api/account",
            type: "GET",
            data: {
                'filter'    :   [
                    {
                        'type' : 'andx',
                        'conditions' : [
                            {'field' :'user', 'type':'eq', 'value' : $scope.user_id}
                        ],
                        'where'  :  'and'
                    }
                ]
            },
            dataType: "json",
            success: function (response) {
                $timeout(function () {
                    $scope.accounts = response._embedded.account;
                },300);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify('Erro ao carregar as configurações');
            }
        });
    };

    $scope.loadBanks = function(){
        $.ajax({
            url: "/api/bank",
            type: "GET",
            dataType: "json",
            success: function (response) {
                $scope.banks = response._embedded.bank;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorNotify("Erro ao consultar as carteiras bitcoin");
            }
        });
    };
    $scope.loadBanks();

    $scope.selectAccount = function (account) {
        $scope.account = account;
        $("#modal_select_account").modal('hide');
        $("#modal_cash_out").modal();
    };

    $scope.updateAccount = function() {
        $scope.account.user = $scope.user_id;
        if($scope.account.id){
            $.ajax({
                url: '/api/account/' + $scope.account.id,
                type: "PATCH",
                async: true,
                contentType : 'application/json',
                data: JSON.stringify($scope.account),
                success: function (o) {
                    $scope.account = {user: $scope.user_id};
                    $scope.loadAccounts($scope.user_id);
                    successNotify("Conta bancária atualizada com sucesso!");
                },
                error: function (o) {
                    errorNotify("Houve um erro ao editar a carteira!");
                },
                dataType: "json"
            });
        }else{
            $.ajax({
                url: '/api/account',
                type: "POST",
                async: true,
                contentType : 'application/json',
                data: JSON.stringify($scope.account),
                success: function (o) {
                    $scope.loadAccounts();
                    successNotify("Conta bancária cadastrada com sucesso!");
                },
                error: function (o) {
                    errorNotify("Houve um erro ao criar a carteira!");
                },
                dataType: "json"
            });
        }
    };

    $scope.aporteModalNew = function (plan) {
        $scope.plan = plan;
        $scope.user_plan._embedded.plan = $scope.plan;
    };

    $scope.add = function() {
        $scope.aport_btn = false;
        $scope.load_btn = true;
        var formData = new FormData(document.getElementById("plan_contract_form"));

        var f = document.getElementById('receipt').files[0],
            r = new FileReader();

        r.onloadend = function(e) {
            var data = e.target.result;
            var ext = f.name.substring(f.name.indexOf(".") + 1);
            formData.append('file', data);

            $scope.sendAdd(formData);
        };

        r.readAsBinaryString(f);

        return false;
    };

    $scope.sendAdd = function(formData){

        $.ajax({
            url: '/admin/contract-save',
            type: 'POST',
            data:  formData,
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
            success: function(result, textStatus, jqXHR)
            {
                var result_obj = JSON.parse(result);
                var r = result_obj.result;
                var message = JSON.parse(result).message;
                if(r){
                    successNotify(message);
                    successNotify("Vamos analisar a sua solicitação, em breve entraremos em contato!");

                    $("#investimentModal").modal('hide');
                    $timeout(function(){
                        location.href = "/admin/my-investiment";
                    },5000);
                }else{
                    errorNotify(message);
                }

                $scope.aport_btn = true;
                $scope.load_btn = false;
            },
            error: function (result) {
                errorNotify("Aconteceu algum erro ao enviar a solicitação de contrato, por favor, entre em contato com o administrador!");
                $scope.aport_btn = true;
                $scope.load_btn = false;
            }
        });
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

    $scope.getExpirationDays = function(date) {
        if(date){
            let start_date = new Date(date.date);
            let current_date = new Date();
            let future_date = start_date;

            future_date.setFullYear(start_date.getFullYear() + 1);

            let number_days = calculaDias(current_date, future_date);
            return (number_days > 0)?number_days:0;
        }else{
            return 0;
        }
    };

    $scope.getPercentDays = function(date) {

        if(date){
            let start_date = new Date(date.date);
            let current_date = new Date();
            let future_date = start_date;

            future_date.setFullYear(start_date.getFullYear() + 1);
            let total = 365;

            let restante = calculaDias(current_date, future_date);
            restante = (restante > 0)?restante:0;
            let percent = restante * 100 / 365;

            return percent.toFixed(2);
        }else{
            return 0;
        }
    };

    $scope.getStatus = function(status) {
        status_str = '';

        switch (status){
            case 0:
                status_str = 'Inativo';
                break;
            case 1:
                status_str = 'Ativo';
                break;
            case 2:
                status_str = 'Resgate Solicitado';
                break;
            case 3:
                status_str = 'Resgatado';
                break;
            case 4:
                status_str = 'Cancelado';
                break;
            default:
                status_str = 'Status não definido';
        }

        return status_str;
    };

    $scope.getStatusColor = function(status) {
        color = '';

        switch (status){
            case 0:
                color = "g-brd-yellow g-bg-yellow-lineargradient";
                break;
            case 1:
                color = "g-brd-lightblue-v3 g-bg-lightblue-v3";
                break;
            case 2:
                color = "g-brd-green g-bg-green-gradient-opacity-v1";
                break;
            case 3:
                color = "g-brd-red g-bg-red-lineargradient";
                break;
            case 4:
                color = "g-brd-black g-bg-black";
                break;
            default:
                color = "g-brd-lightblue-v3 g-bg-lightblue-v3";
        }

        return color;
    };

    $scope.getMonth = function(month) {
        var month_str = "";
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
        return month_str
    };

    $scope.cycleFuture = function(cycle) {
        if( typeof cycle !== 'undefined' && cycle !== null ){
            let date = new Date();
            let sumDateNow = date.getFullYear() + (date.getMonth() + 1 / 100);
            let sumFirstCycle = cycle.year + (cycle.month / 100);
            return (sumFirstCycle > sumDateNow)?true:false;
        }else{
            return false;
        }
    };

    $scope.renewChange = function () {
        if($scope.renew){
            $scope.renew = false;
        }else{
            $scope.renew = true;
            $scope.cash_out = false;
        }
    };

    $scope.cachOutChange = function () {
        if($scope.cash_out){
            $scope.cash_out = false;
        }else{
            $scope.cash_out = true;
            $scope.renew = false;
        }
    };

    $scope.enableCashOut = function() {
        let date = new Date();

        if(!in_array(date.getDate(),$scope.canDays)){
            return true;
        }

        return false;
    };

    $scope.sendCashOut = function() {
        if($scope.user_plan.account == null && $scope.user_plan.wallet == null){
            errorNotify('Você precisa selecionar alguma conta ou carteira para finalizar saque');
            return false;
        }

        let data = {
            'renew' : $scope.renew,
            'cash_out'  :   $scope.cash_out,
            'user_plan_id' : $scope.user_plan.id,
            'account': $scope.user_plan.account,
            'wallet' : $scope.user_plan.wallet,
            'receive_method' : $scope.receive_method
        };

        let msg = '';

        if($scope.renew || $scope.cash_out){
            if($scope.renew){
                msg = 'Você tem certeza que deseja renovar o contrato do aporte e sacar o rendimento total?';
            }

            if($scope.cash_out){
                msg = 'Você tem certeza que deseja efetuar o resgate do aporte e sacar o rendimento total?';
            }

            data.value = $scope.user_plan.balance;
        }else{
            msg = 'Você deseja realmente efetuar o saque?';
            data.value = Number($("#result2min").val());
        }

        bootbox.confirm({
            message: msg,
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
                if(!result){
                    this.modal("hide");
                    $("#modal_cash_out").modal("hide");
                }else{
                    $timeout(function () {
                        $scope.enableSolicitation = false;
                    },300);
                    $.ajax({
                        url: "/admin/send-cash-out",
                        type: "POST",
                        dataType: "json",
                        data: data,
                        success: function (response) {
                            if(response.result){
                                successNotify(response.message);
                            }else{
                                errorNotify(response.message);
                            }
                            $timeout(function () {
                                $scope.enableSolicitation = true;
                            },300);
                            $("#modal_cash_out").modal("hide");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $("#modal_cash_out").modal("hide");
                        }
                    });
                }
            }
        });
    };

    function calculaDias(date1, date2) {

        // The number of milliseconds in one day
        var ONE_DAY = 1000 * 60 * 60 * 24;

        // Convert both dates to milliseconds
        var date1_ms = date1.getTime();
        var date2_ms = date2.getTime();

        // Calculate the difference in milliseconds
        var difference_ms = Math.abs(date1_ms - date2_ms);
        // Convert back to days and return
        return Math.round(difference_ms/ONE_DAY);
    }

    function in_array(needle, haystack){
        var found = 0;
        for (var i=0, len=haystack.length;i<len;i++) {
            if (haystack[i] == needle) return true;
            found++;
        }
        return false;
    }

    $scope.numberArray = function(number){
        var arr = [];

        for(var i = 1; i <= number; i++){
            arr.push(i);
        }

        return arr
    };

    $('#modal_cash_out').on('hidden.bs.modal', function (e) {
        $scope.renew = false;
        $scope.cash_out = false;
        $scope.receive_method = 0;
    });

    $(document).ready(function () {
        setTimeout(function () {
            $.HSCore.components.HSAreaChart.init(".js-area-chart");
            $.HSCore.components.HSDonutChart.init(".js-donut-chart");
            $.HSCore.components.HSBarChart.init(".js-bar-chart");
            $.HSCore.components.HSSideNav.init('.js-side-nav');
            $.HSCore.components.HSDropdown.init($('[data-dropdown-target]'), {dropdownHideOnScroll: false});
            $.HSCore.helpers.HSHamburgers.init('.hamburger');
            $('.js-select').selectpicker();
        },2000);
    });

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

}]);
