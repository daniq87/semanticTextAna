function getNegativeParams() {
    return '?attributeName=' + document.getElementById("filterNegativeAttribute").value + '&pag=1';
}

function clearNegativeFilter(method, action, params, div) {
    $('#filterNegativeAttribute').val('');
    ajaxRefreshDiv(method, action, params, div);
}

$(document).ready(function () {
    var $filterNegativeAttribute = $('#filterNegativeAttribute');
    // KNP Paginator Ajax
    $('#negative-container').on('click', ".navigation .pagination li a", function (e) {
        e.preventDefault();
        var params = '?attributeName=' + $filterNegativeAttribute.val() + '&pag=' + $(this).html();

        ajaxRefreshDiv('GET', 'index/NegativeAttribute', params, 'negative-container');
    });
});
