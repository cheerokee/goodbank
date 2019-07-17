angular.module("cash-out", [])
.controller("CashOutController", ["$scope","$http","$timeout","$filter", function($scope,$http,$timeout,$filter) {

    $scope.action = $("#type_solicitation").val();
    $scope.user_plan_id = $("#user_plan_id").val();

    $scope.transactions = [];

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
    $scope.loadTransactions($scope.user_plan_id);

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

    $scope.formatDate = function(dt)
    {
        if(dt != '') {
            var date = new Date(dt.date);
            return date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
        }else{
            return '';
        }
    };

    $scope.decisionAction = function(id_form){
        bootbox.confirm({
            message: "Deseja mesmo executar essa ação?",
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
                }else{
                    $("#" + id_form).submit();
                }
            }
        });
    };

    $(document).ready(function () {
        setTimeout(function () {
            $.HSCore.components.HSAreaChart.init(".js-area-chart");
            $.HSCore.components.HSDonutChart.init(".js-donut-chart");
            $.HSCore.components.HSBarChart.init(".js-bar-chart");
            $.HSCore.components.HSSideNav.init('.js-side-nav');
            $.HSCore.components.HSDropdown.init($('[data-dropdown-target]'), {dropdownHideOnScroll: false});
            $.HSCore.helpers.HSHamburgers.init('.hamburger');
            $('.js-select').selectpicker();
        },1000);
    });

}]);
