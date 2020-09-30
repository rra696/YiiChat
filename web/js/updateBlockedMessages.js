setInterval(() => {
    $.ajax({
        url: "/chat/blocked-messages-list"
    }).done(function(data) {
        if (data.isOk) {
            $('#blocked_messages_list').html(data.message)
        } else {
            alert(data.message)
        }
    }).fail(function(data){ 
        alert('Произошла ошибка при обновлении чата!')
    })
}, 4000)