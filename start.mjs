// start.mjs

(() => {
    import('./resources/js/app.js')
        .then((module) => {
            console.log('Модуль загружен');
        })
        .catch((err) => {
            console.error('Ошибка при загрузке модуля:', err);
        });
})();
