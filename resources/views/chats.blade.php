<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ChatSystem</title>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
</head>
<body>
    <div class="chat">
            <div class="top">
                <img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">
                <div>
                    <p>Ross Edlin</p>
                    <small>Online</small>
                </div>
            </div>
            <div class="messages">
                    @include('receive',['message' => "Hey!Whats up"])
            </div>
            <div class="bottom">
                <form action="">
                    <input type="text" id="message" name="message" placeholder="Please enter a message..." autocomplete="off">
                    <button type="submit"></button>
                </form>
            </div>
    </div>

    <script>
        const pusher = new Pusher('{{config('broadcasting.connection.pusher.key')}}', {cluster: 'eu'});
        const channel = new pusher.subscribe('public');

        //receive message 
        channel.bind('chat',function(data)
        {
            $.post("/receive", {
                _token: '{{csrf_token()}}',
                message:data.message,
            })
                .done(function(res){
                    $(".message > .message").last().after(res);
                    $(document).scrollTop($(document).height());
                });
        });

        //broadcast message
        $("form").submit(function(event){
            event.preventDefault();
        });

        $.ajax({
            url: "/broadcast",
            method: 'POST',
            headers:{
                'X-Socket-Id': pusher.connection.socket_id
            },

            data: {
                _token: '{{csrf_token()}}',
                message: $("form #message").val(),
            }
        }).done(function (res){
            $(".message > .message").last().after(res);
            $("form #message").val('');
            $(document).scrollTop($(document).height());
        });


    </script>
</body>
</html>