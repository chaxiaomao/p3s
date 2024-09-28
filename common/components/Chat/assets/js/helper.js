(function() {
    window.Helper = {
        Message: {}
    };
    Helper.dict = {
        'zh': {
            'New message from': '新消息来自',
            'Connect to chat': '进入聊天室',
            'Left this chat': '离开聊天室',
            'Send message': '发消息',
            'Connection refused': '连接被拒绝',
            'Current room is not available': '当前房间不可用',
            'Copied to clipboard': '已复制到剪贴板',
            'Connection error. Try to reload page': '连接失败，重新加载页面',
            'Something wrong. Connection will be closed': '发生错误，连接将中断！'
        },
        'ru': {
            'New message from': 'Сообщение от',
            'Connect to chat': 'Подключился к чату',
            'Left this chat': 'Вышел из чата',
            'Send message': 'Отправить сообщение',
            'Current room is not available': 'Текущий чат недоступен',
            'Copied to clipboard': 'Скопировано в буфер обмена',
            'Connection error. Try to reload page': 'Ошибка соединения. Попробуйте обновить страницу',
            'Something wrong. Connection will be closed': 'Произошла ошибка. Соединение будет закрыто'
        }
    };
    Helper.t = function(message) {
        var lang = Cookies.get('chatLang') || 'en';
        if (lang === 'en') {
            return message;
        }
        return Helper.dict[lang][message];
    };
    Helper.Message.info = function(message) {
        var opts = {
            text: message,
            type: 'info',
            history: false,
            icon: false,
            styling: 'bootstrap3'
        };
        new PNotify(opts);
    };
    Helper.Message.error = function(message) {
        var opts = {
            text: message,
            type: 'error',
            history: false,
            icon: false,
            styling: 'bootstrap3'
        };
        new PNotify(opts);
    };
    Helper.uid = function() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
            return v.toString(16);
        });
    };
    return Helper;
}());