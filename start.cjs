const path = require('path');

const appJsPath = path.join(__dirname, 'public', 'build', 'app.js');

try {
    require(appJsPath);
    console.log('✅ App loaded');
} catch (err) {
    console.error('❌ Load error:', err);
}
