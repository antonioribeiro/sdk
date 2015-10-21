<script>
    var socket = io('{{ url() . ':' . env('CHAT_PORT', '23172') }}');

    new Vue(
    {
        el: 'body',

        data: {
            messages: [],
            talkerUsername: '{{ $talkerUsername }}',
            talkerEmail: '{{ $talkerEmail }}',
            talkerId: '{{ $talkerId }}',
            currentMessage: '',
            chatId: '{{ $chatId }}',
            connected: false,
        },

        methods:
        {
            __sendMessage: function(event)
            {
                var userId = event.targetVM.$data.talkerId;

                var message = event.targetVM.$data.currentMessage;

                var chatId = event.targetVM.$data.chatId;

                this.$http.get('{{ url() }}/api/v1/chat/client/send/'+chatId+'/'+userId+'/'+message);
            }
        },

        ready: function()
        {
            socket.on('connect', function(data)
            {
                this.connected = true;
            }.bind(this));

            socket.on('disconnect', function(data)
            {
                this.connected = false;
            }.bind(this));

            {{--{{ $listenChannel }}--}}

            socket.on('chat-channel:{{ $chatId }}', function(data)
            {
                var isOperator = data.username == '{{ $operatorUsername }}';

                var message = {
                    "isOperator": isOperator,
                    "username": data.username,
                    "message": data.message,
                    "pull": isOperator ? 'left' : 'right',
                    "photo": isOperator ? '{!! $operatorAvatar !!}' : '{!! $talkerAvatar !!}',
                };

                this.messages.push(message);
            }.bind(this));
        }
    });
</script>
