const { createRequire } = require('module');
const requireESM = createRequire(import.meta.url);
const app = requireESM('./public/build/app.js');
