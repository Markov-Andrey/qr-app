import manifest from './public/build/manifest.json' assert { type: 'json' };

const appJs = Object.values(manifest).find(file => file.isEntry)?.file;

if (appJs) {
    import(`./build/assets/${appJs}`)
        .then(() => console.log('✅ App loaded:', appJs))
        .catch(err => console.error('❌ Load error:', err));
} else {
    console.error('❌ App entry not found in manifest.json');
}
