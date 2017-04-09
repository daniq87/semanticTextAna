
function ajaxRefreshDiv(method, url, params, refreshDiv) {

//    alert('ajax url='+url+params);
    $("#" + refreshDiv).html("Loading...");
    $('#loading-progress-bar').removeClass('hidden');

    $.ajax({
        type: method,
        url: url + params,
        success: function (data) {
            $("#" + refreshDiv).html(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Ajax: ' + textStatus + ' errorThrown: ' + errorThrown);
        },
        complete: function () {
            $('#loading-progress-bar').addClass('hidden');
            $('#message').addClass('hidden');
            $('#noAjax-notification').empty();
        }
    });
}

function activeTab(tab, route) {
    $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    ajaxRefreshDiv("GET", route, "", tab);
}

