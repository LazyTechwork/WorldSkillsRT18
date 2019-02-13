// Инициализируем ядро Умного Дома
var smartHouseCore = {
    // Метод для проверки авторизации в системе
    checkAuthorization: function () {
        return docCookies.hasItem("token");
    },
    // Метод для автоматической авторизации и сохранении токена в COOKIE файле
    authorize: function (token) {
        docCookies.setItem("token", token);
        return checkAuthorization();
    },
    // Получить ссылку на метод
    getMethodUrl: function (method) {
        return "http://smarthome.web.wsr.ru/api/" + method;
    },
    // Проверка на пустой ключ
    isKeyEmpty: function (key) {
        return $.isEmptyObject(key) || pretty.errors == null;
    }
};
