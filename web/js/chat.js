setInterval(() => {
    $.ajax({
        method: "GET",
        url: "/chat/update-messages",
    }).done(function(data) {
        if (data.isOk) {
            $('#messages_box').html(data.message)
        } else {
            alert(data.message)
        }
    }).fail(function(data){ 
        alert('Произошла ошибка при обновлении чата!')
    })
}, 2000)

$('#newMessageForm').on('beforeSubmit', function() {
    let form = $(this)
       
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serializeArray(),
        beforeSend: function() {
          $("#newMessageForm button").attr('disabled', 'disabled')  
        },
        success: function(data) {
            if (data.isOk) {
                $('#messageform-text').val('')
                $('#messages_box').append(data.message)
                scrollChatBoxToBottom()
            } else {
                alert(data.message)
            } 
        },
        error: function() {
            alert('Произошла ошибка при отправке сообщения!')
        },
        complete: function() {
            $("#newMessageForm button").removeAttr('disabled')
        }
    })

    return false;
});

function blockMessage(msgId) {
    let msgBlock = $("#message_" + msgId);
    
    $.ajax({
        method: "GET",
        url: "/chat/block-message",
        data: {
            msgId: msgId
        },
        success: function(data) {
            if (data.isOk) {
                msgBlock.remove()
            } else {
                alert(data.message)
            } 
        },
        error: function() {
            alert('Произошла ошибка при отправке запроса на блокировку сообщения!')
        },
    })
}

function unblockMessage(msgId) {
    let msgBlock = $("#blocked_message_" + msgId);
    
    $.ajax({
        method: "GET",
        url: "/chat/unblock-message",
        data: {
            msgId: msgId
        },
        success: function(data) {
            if (data.isOk) {
                msgBlock.remove()
            } else {
                alert(data.message)
            } 
        },
        error: function() {
            alert('Произошла ошибка при отправке запроса на разблокировку сообщения!')
        },
    })
}

function changeUserRole(id, role) {
    $.ajax({
        method: "GET",
        url: "/auth/change-user-role",
        data: {
            userId: id,
            roleName: role
        },
        success: function(data) {
            if (data.isOk) {
                $("#member_block_" + id).html(data.message)
            } else {
                alert(data.message)
            } 
        },
        error: function() {
            alert('Произошла ошибка при попытке сменить роль!')
        },
    })
}

function scrollChatBoxToBottom()
{
    let text = $('.chat_area');
    text.scrollTop(text.prop('scrollHeight'));
}