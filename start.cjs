(async () => {
    try {
        const { default: app } = await import('./public/build/app.js');
        return '<html><body><h1>HELLO!</h1></body></html>';
    } catch (error) {
        return `<html><body><h1>Error: ${error.message}</h1></body></html>`;
    }
})();
