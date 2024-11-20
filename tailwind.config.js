const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./components/**/*.{js,vue,ts}",
        "./layouts/**/*.vue",
        "./pages/**/*.vue",
        "./composables/**/*.{js,ts}",
        "./plugins/**/*.{js,ts}",
        "./App.{js,ts,vue}",
        "./app.{js,ts,vue}",
        "./Error.{js,ts,vue}",
        "./error.{js,ts,vue}",
    ],
    theme: {
        extend: {
        },
    },
    plugins: [
    ],
}
