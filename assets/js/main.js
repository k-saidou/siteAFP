/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
const $ = require('jquery');
require('bootstrap');




// any CSS you import will output into a single css file (app.css in this case)
import '../css/main.css';



// returns the final, public path to this file
// path is relative to this file - e.g. assets/images/logo.png
const logoPath = require('../images/test.jpg');

let html = `<img src="${logoPath}" alt="ACME logo">`;




// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/main.js');
