const { Game } = require('./classes/Game');

require('./bootstrap');

document.onload = Game.setListeners();
