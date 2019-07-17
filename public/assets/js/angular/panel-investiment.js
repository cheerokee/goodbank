angular.module("panelInvestmentView", [])
.controller("InvestimentViewController", ["$scope","$http","$timeout","$filter", function($scope,$http,$timeout,$filter) {

    $scope.user_id = $("#user_id").val();
    $scope.aport_btn = true;
    $scope.load_btn = false;
    $scope.renew = false;
    $scope.cash_out = false;

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

    $scope.plans = [];
    $scope.wallets = [];
    $scope.payment_methods = [];
    $scope.user_plans = [];
    $scope.transactions = [];

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

    $scope.loadTransactions = function(user_plan_id) {

        $.ajax({
            url: "/api/transaction",
            type: "GET",
            data: {
                'filter'    :   [
                    {
                        'type' : 'andx',
                        'conditions' : [
                            {'field' :'user_plan', 'type':'eq', 'value' : user_plan_id}
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
                    $scope.load();
                    $scope.aport_btn = true;
                    $scope.load_btn = false;
                }else{
                    errorNotify(message);
                    $scope.aport_btn = true;
                    $scope.load_btn = false;
                }
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
            let future_date = new Date();
            future_date.setDate(start_date.getDate() + 365);
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
            let future_date = new Date();
            future_date.setDate(start_date.getDate() + 365);

            let total = calculaDias(start_date, future_date);
            total = (total > 0)?total:0;

            let restante = calculaDias(current_date, future_date);
            restante = (restante > 0)?restante:0;

            let percent = restante * 100 / total;

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
        let canDays = [29,30,31,1];

        if(!in_array(date.getDate(),canDays)){
            return true;
        }

        return false;
    };

    $scope.sendCashOut = function() {
        let data = {
            'renew' : $scope.renew,
            'cash_out'  :   $scope.cash_out,
            'user_plan_id' : $scope.user_plan.id
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
                    $.ajax({
                        url: "/admin/send-cash-out",
                        type: "POST",
                        dataType: "json",
                        data: data,
                        success: function (response) {
                            console.log(response);
                            return false;
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

    function calculaDias(date1, date2){
        //formato do brasil 'pt-br'
        moment.locale('pt-br');
        //setando data1
        var data1 = moment(date1,'DD/MM/YYYY');
        //setando data2
        var data2 = moment(date2,'DD/MM/YYYY');
        //tirando a diferenca da data2 - data1 em dias
        var diff  = data2.diff(data1, 'days');

        return diff;
    }

    function in_array(needle, haystack){
        var found = 0;
        for (var i=0, len=haystack.length;i<len;i++) {
            if (haystack[i] == needle) return true;
            found++;
        }
        return false;
    }

    $('#modal_cash_out').on('hidden.bs.modal', function (e) {
        $scope.renew = false;
        $scope.cash_out = false;
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

}]);
