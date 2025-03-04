import('./public/build/app.js')
    .then(() => console.log('✅ App loaded'))
    .catch(err => console.error('❌ Load error:', err));
