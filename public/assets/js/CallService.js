//global variable 
var done_tag;
var action;
var formid;
var ServicePath = document.URL.slice(0, document.URL.lastIndexOf('/') + 1) + "";
// calling web service
function TransportCall(data, successFn = onSuccess, errorFn = onError) {
    debugger;
    on();

    data.MSC = $.md5(new Date().getDate().toString().padStart(2, "0"));
    var srvdata = JSON.stringify(data);
    $.ajax({
        data: srvdata,
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        async: true,
        url: GetUrl(),
        success: function showData(arg) {
            off();
            successFn(arg);
        },
        error: function err(arg) {

            // off();
            // alert(JSON.stringify(arg));
            if (arg.status == 404) {
                // alert(arg.statusText);
                alert("Session Expired!!");
                window.open("../", '_self');
            } else if (arg.status == 401) {
                // alert(arg.statusText);
                alert("Session Expired!!");
                window.open("../", '_self');
            }
            errorFn(arg);
            off();
        }
    });
}


function SilentTransportCall(data, successFn = onSuccess, errorFn = onError) {
    var MSC = $.md5(new Date().getDate().toString().padStart(2, "0"));
    var srvdata = JSON.stringify(data);
    $.ajax({
        beforeSend: function (request) {
            request.setRequestHeader("MSC", MSC);
        },
        data: srvdata,
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        async: true,
        url: GetUrl(),
        success: function showData(arg) {
            successFn(arg);
        },
        error: function err(arg) {
            // alert(JSON.stringify(arg));
            if (arg.status == 404) {
                // alert(arg.statusText);
                alert("error", "Session Expired!!");
                window.open("../", '_self');
            } else if (arg.status == 401) {
                // alert(arg.statusText);
                alert("error", "Session Expired!!");
                window.open("../", '_self');
            }
            errorFn(arg);
        }
    });
}

function GetUrl() {
    if (ServicePath.toLocaleLowerCase().indexOf("pages") >= 0) {
        return ServicePath.toLocaleLowerCase().replace("pages/", "") + "app/index.php";
    } else {
        return ServicePath + "app/index.php";
    }
}

function on() {

}

function off() {

}
