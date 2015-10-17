<script>
    var socket = io('{{ url() . ':' . env('CHAT_PORT', '23172') }}');

    new Vue(
    {
        el: 'body',

        data: {
            messages: [],
            currentUsername: '{{ $talkerUsername }}',
            currentEmail: '{{ $talkerEmail }}',
            currentMessage: '',
            chatId: '{{ $chatId }}',
            connected: false,
        },

        methods:
        {
            __sendMessage: function(event)
            {
                var user = event.targetVM.$data.currentUsername;

                var message = event.targetVM.$data.currentMessage;

                var chatId = event.targetVM.$data.chatId;

                this.$http.get('{{ url() }}/chat/client/send/'+chatId+'/'+user+'/'+message);
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

            socket.on('{{ $listenChannel }}', function(data)
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
