import {
    getJSON
} from './utilities.js';

// Quake Model

export default class Quake {
    constructor() {
        this.baseUrl =
            'https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson&starttime=2019-01-01&endtime=2019-03-02';
        //store the last batch of retrieved quakes in the model.  
        this._quakes = [];
    }

    async getEarthQuakesByRadius(position, radius = 100) {
        // use the getJSON function and the position provided to build out the correct URL to get the data   
        const query =
          this.baseUrl +
          `&latitude=${position.lat}&longitude=${position.lon}&maxradiuskm=${radius}`;
        console.log(query);
        this._quakes = await getJSON(query); //Store it into this._quakes, then return it
        return this._quakes;
      }
}