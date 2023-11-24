// webpack.mix.js

const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .js('public/assets/js/loader.js', 'public/js'); // Ajoutez cette ligne pour inclure loader.js
   // Vous pouvez également inclure d'autres assets, comme les fichiers CSS, avec mix.sass() ou mix.css()

// Autres configurations possibles avec Laravel Mix
