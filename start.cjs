const { default: app } = await import('./public/build/app.js');
if (typeof app === 'function') {
    app();
}
