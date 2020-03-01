//hikes model -- using classees and modules to organize code

import Comments from "./comments.js";

//create an array of hikes
const hikeList = [
  {
    name: 'Bechler Falls',
    imgSrc: 'bechler.jpg',
    imgAlt: 'Image of Bechler Falls',
    distance: '3 miles',
    difficulty: 'Easy',
    description:
      'Beautiful short hike along the Bechler river to Bechler Falls',
    directions:
      'Take Highway 20 north to Ashton. Turn right into the town and continue through. Follow that road for a few miles then turn left again onto the Cave Falls road.Drive to the end of the Cave Falls road. There is a parking area at the trailhead.'
  },
  {
    name: 'Teton Canyon',
    imgSrc: 'teton.jpg',
    imgAlt: 'Image of Bechler Falls',
    distance: '3 miles',
    difficulty: 'Easy',
    description: 'Beautiful short (or long) hike through Teton Canyon.',
    directions:
      'Take Highway 33 East to Driggs. Turn left onto Teton Canyon Road. Follow that road for a few miles then turn right onto Staline Raod for a short distance, then left onto Alta Road. Veer right after Alta back onto Teton Canyon Road. There is a parking area at the trailhead.'
  },
  {
    name: 'Dunanda Falls',
    imgSrc: 'dunanda.jpg',
    imgAlt: 'Image of Bechler Falls',
    distance: '7 miles',
    difficulty: 'Moderate',
    description:
      'Beautiful hike through Bechler meadows river to Denanda Falls',
    directions:
      'Take Highway 20 north to Ashton. Turn right into the town and continue through. Follow that road for a few miles then turn left again onto the Cave Falls road. Drive to until you see the sign for Bechler Meadows on the left. Turn there. There is a parking area at the trailhead.'
  }
];

const imgBasePath = 'images/';

export default class Hikes {
  constructor(elementId) {
    this.parentElement = document.getElementById(elementId);
    // build back button to return to the list
    this.backButton = this.buildBackButton();
    this.comments = new Comments('hikes', 'comments');
  }
  
  getAllHikes() {
    return hikeList;
  }
  // get just one hike
  getHikeByName(hikeName) {
    return this.getAllHikes().find(hike => hike.name === hikeName);
  }
  //show a list of hikes in the parentElement
  showHikeList() {
    this.parentElement.innerHTML = '';
    renderHikeList(this.parentElement, this.getAllHikes());
    this.addHikeListener();
    // make sure the back button is hidden
    this.backButton.classList.add('hidden');
    //show all comments
    this.comments.showCommentList();
  }
  // show one hike with full details in the parentElement
  showOneHike(hikeName) {
    const hike = this.getHikeByName(hikeName);
    this.parentElement.innerHTML = '';
    this.parentElement.appendChild(renderOneHikeFull(hike));
    // show the back button
    this.backButton.classList.remove('hidden');
    // show filtered comment list for just this hike
    this.comments.showCommentList(hikeName);

  }
  // in order to show the details of a hike on click we will need to attach a listener AFTER the list of hikes has been built. The function below does that.
  addHikeListener() {
    // We need to loop through the children of our list and attach a listener to each, remember though that children is a nodeList...not an array. So in order to use something like a forEach we need to convert it to an array.
    const childrenArray = Array.from(this.parentElement.children);
    childrenArray.forEach(child => {
      child.addEventListener('click', e => {
        // why currentTarget instead of target?
        this.showOneHike(e.currentTarget.dataset.name);
      });
    });
  }
  buildBackButton() {
    const backButton = document.createElement('button');
    backButton.innerHTML = 'All hikes';
    backButton.addEventListener('click', () => {
      this.showHikeList();
    });
    backButton.classList.add('hidden');
    this.parentElement.before(backButton);
    return backButton;
  }
}
// End of Hikes class
// methods responsible for building HTML (view)  
function renderHikeList(parent, hikes) {
  hikes.forEach(hike => {
    parent.appendChild(renderOneHikeLight(hike));
  });
}
function renderOneHikeLight(hike) {
  const item = document.createElement('li');
  item.classList.add('light');
  // setting this to make getting the details for a specific hike easier later.
  item.setAttribute('data-name', hike.name);
  item.innerHTML = 
        `<div class ="hikename"> 
          <h2 class="hikename">${hike.name}</h2>
        </div>
        <div class="image">
          <img src="${imgBasePath}${hike.imgSrc}" alt="${hike.imgAlt}" class="sm-img">
        </div>
        <div class="details">
          <p>Distance: ${hike.distance}</p>
          <p>Difficulty: ${hike.difficulty}</p>
        </div>`;

  return item;
}
function renderOneHikeFull(hike) {
  const item = document.createElement('li');
  item.innerHTML = ` 
    
        <div class="hikepic">
        <img src="${imgBasePath}${hike.imgSrc}" alt="${hike.imgAlt}" class="hikepic">
        </div>
        <h2>${hike.name}</h2>
        <div>
            <h4>Distance</h4>
            <p>${hike.distance}</p>
        </div>
        <div>
            <h4>Difficulty</h4>
            <p>${hike.difficulty}</p>
        </div>
        <div>
            <h4>Description</h4>
            <p>${hike.description}</p>
        </div>
        <div>
            <h4>How to get there</h4>
            <p>${hike.directions}</p>
        </div>
        <div>
         <h4>Comments</h4>
            
        </div>
    `;
  return item;
}

