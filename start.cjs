const express = require('express');
const path = require('path');

const app = express();
const PORT = 3000; // Можешь поменять на нужный порт

app.use(express.static('public')); // Раздаём статику

app.get('/', async (req, res) => {
    try {
        const { default: appFunction } = await import(path.join(process.cwd(), 'public/build/app.js'));

        if (typeof appFunction === 'function') {
            appFunction(); // Вызываем, если это функция
        }

        res.send('<html><body><h1>HELLO!</h1></body></html>');
    } catch (error) {
        res.send(`<html><body><h1>Error: ${error.message}</h1></body></html>`);
    }
});

app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
