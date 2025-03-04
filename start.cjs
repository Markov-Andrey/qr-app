(async () => {
    try {
        const { default: app } = await import('./public/build/app.js');
        if (typeof app === 'function') {
            app();
        } else {
            // Если app не является функцией, верни HTML строку
            return '<html><body><h1>HELLO!</h1></body></html>';
        }
    } catch (error) {
        return `<html><body><h1>Error: ${error.message}</h1></body></html>`;
    }
})();
