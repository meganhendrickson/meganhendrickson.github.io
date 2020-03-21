import {
    getLocation
} from './utilities.js';
import Quake from './Quake.js';
import QuakesView from './QuakesView.js';

// Quake controller
export default class QuakesController {
    constructor(parent, position = null) {
        this.parent = parent;
        this.parentElement = null;
        // passing in location
        this.position = position || {
            lat: 0,
            lon: 0
        };
        this.quakes = new Quake(); //model
        this.quakesView = new QuakesView(); //view
    }

    async init() {
        // , and display quakes by calling this.getQuakesByRadius()
        this.parentElement = document.querySelector(this.parent); //element identified by this.parent
        await this.initPos(); //initial call of this.initPos()
        this.getQuakesByRadius(500); //display quakes by calling this.getQuakesByRadius()
    }

    async initPos() {
        // if a position has not been set
        if (this.position.lat === 0) {
            try {
                // try to get the position using getLocation()
                const posFull = await getLocation();

                // if we get the location back then set the latitude and longitude into this.position
                this.position.lat = posFull.coords.latitude;
                this.position.lon = posFull.coords.longitude;
                //console.log(posFull);
            } catch (error) {
                console.log(error);
            }
        }
    }

    async getQuakesByRadius(radius = 500) {
        // this method provides the glue between the model and view. Notice it first goes out and requests the appropriate data from the model, then it passes it to the view to be rendered.
        //set loading message
        this.parentElement.innerHTML = 'Loading...';
        // get the list of quakes in the specified radius of the location
        const quakeList = await this.quakes.getEarthQuakesByRadius(
            this.position,
            500 //there are no quakes within 100 miles of my location so I had to increase my radius in order to get any data
        );
        // render the list to html
        this.quakesView.renderQuakeList(quakeList, this.parentElement);
        // add a listener to the new list of quakes to allow drill down in to the details
        this.parentElement.addEventListener('touchend', e => {
            this.getQuakeDetails(e.target.dataset.id);
        });
    }

    async getQuakeDetails(quakeId) {
        // get the details for the quakeId provided and send them to the view to be displayed
        const quake = this.quakes.getQuakeById(quakeId);
        this.quakesView.renderQuake(quake, this.parentElement);
    }
}