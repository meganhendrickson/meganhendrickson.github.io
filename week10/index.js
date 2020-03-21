import { getJSON, getLocation } from './utilities.js';
import QuakesController from './QuakesController.js';

const myQuakesController = new QuakesController('#quakeList');
myQuakesController.init();