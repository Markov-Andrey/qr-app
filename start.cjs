const path = require('path');
const fs = require('fs');

const appJsPath = path.resolve(__dirname, 'public/build/app.js');

if (fs.existsSync(appJsPath)) {
    import(appJsPath)
        .then(() => console.log('✅ App loaded'))
        .catch(err => console.error('❌ Load error:', err));
} else {
    console.error(`❌ File not found: ${appJsPath}`);
}
