$(document).ready(function () {  
    var socket  = new WebSocket('ws://127.0.0.1:8090');

    socket.onopen = function(e) {
        socket.send( JSON.stringify({
            command: "open", 
            userId: $('#loggedIn').val() 
        }) );
    };

    $('.user-chat').on('click', function () {
        let id = $(this).attr('data-id');
        var url = base_url + 'chat/chat-box/'+id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            dataType: 'html',
            type: "GET",
            success: function (data) {
                $('#chatWindow').html(data);
            },
            error: function (error) {
                console.log(error) 
            }
        });
    });

    socket.onmessage = function(e) {
        var data = JSON.parse(e.data);
        let loggedInUser = $('#loggedIn').val();
        if(data.senderId == loggedInUser){
            $("#send-message-details").append('<li class="flex justify-end sender-details"><div class="relative max-w-xl px-4 py-2 text-gray-700 bg-gray-100 rounded shadow"><span class="block">'+data.message+'</span></div></li>');
        }else{
            $("#send-message-details").append('<li class="flex justify-start receiver-details"><div class="relative max-w-xl px-4 py-2 text-gray-700 rounded shadow"><span class="block">'+data.message+'</span></div></li>');
        }

    }

    $(document).on('click', '#sendMessageBtn' ,function (e) {
        socket.send( JSON.stringify({
            command: "message", 
            senderId: $('#sender_id').val(),
            receiverId: $('#receiver_id').val(),
            message: $('#message').val(),
        }));
        $('#message').val('');
    });
   
    $("#sendMessageForm").validate({
        rules: {
            message: {
                required: true
            }
        },
        messages: {
            message: {
                required: 'Please enter message'
            }
        }
    });

});