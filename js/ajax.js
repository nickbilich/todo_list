function ajax(type = 'POST', action = '', success = '', params = ''){
    $.ajax({
        type: type,
        url: 'actions/' + action + '.php',
        data: params,
        success: success
    });
}