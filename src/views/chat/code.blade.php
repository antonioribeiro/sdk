<script>
    var socket = io('{{ url() . ':' . env('CHAT_PORT', '23172') }}');

    new Vue(
    {
        el: 'body',

        data: {
            messages: [],
            connected: false,
            listeningSockets: [],
            talkerUsername: '{{ $talkerUsername }}',
            talkerEmail: '{{ $talkerEmail }}',
            talkerId: '{{ $talkerId }}',
            currentMessage: '',
            chatId: '{{ $chatId }}',
            chatInfo: {},
            connected: false,
        },

        methods:
        {
            __sendMessage: function(event)
            {
                this.$http.get('{{ url() }}/api/v1/chat/client/send/'+this.chatId+'/'+this.talkerId+'/'+this.currentMessage);
            },

            __loadChats: function()
            {
                this.$http.get(
                    '{{ url() }}/api/v1/chat/client/all/'+this.chatId,
                    function(data, status, request)
                    {
                        this.$set('chatInfo', data);

                        console.log(data);
                    }
                );
            },

            __playNewMessageSound: function()
            {
                var audio = new Audio('{{ url() }}/assets/sound/newmessage.mp3');
                audio.play();
            },

            __socketOn: function(channel, callable)
            {
                if (this.listeningSockets.indexOf(channel) == -1)
                {
                    this.listeningSockets.push(channel);

                    return socket.on(channel, callable);
                }
            },

            __listenOnChatSockets: function()
            {
                socket.on('connect', function(data)
                {
                    this.connected = true;
                }.bind(this));

                socket.on('disconnect', function(data)
                {
                    this.connected = false;
                }.bind(this));

                socket.on('chat-channel:{{ $chatId }}', function(data)
                {
                    this.__loadChats();
                }.bind(this));
            },

            __chatLeftRight: function(message)
            {
                console.log(message.talker.id == this.talkerId ? 'left' : 'right');
                console.log(message.talker.id + ' - ' + this.talkerId);
                return message.talker.id == this.talkerId ? 'left' : 'right';
            }
        },

        ready: function()
        {
            this.__listenOnChatSockets();

            this.__loadChats();
        }
    });
</script>

