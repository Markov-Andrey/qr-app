var app;

(async () => {
    try {
        // Попытка импортировать модуль через dynamic import
        const { default: appModule } = await import('./public/build/app.js');
        app = appModule;

        // Проверка, если `app` - функция, вызываем её
        if (typeof app === 'function') {
            app();
        }

        // Возвращаем HTML строку
        return '<html><body><h1>HELLO!</h1></body></html>';
    } catch (error) {
        // Если ошибка, возвращаем HTML с сообщением об ошибке
        return `<html><body><h1>Error: ${error.message}</h1></body></html>`;
    }
})();
