// Quake View

export default class QuakesView {
    renderQuakeList(quakeList, listElement) {
        //build a list of the quakes
        quakeList.features.forEach(element => {
          const item = document.createElement('li');
          console.log(element);
          item.setAttribute('data-id', element.id); //set to add id of the quake as a properity of the li
          item.innerHTML = `${element.properties.title}
          <p>${new Date(element.properties.time)}</p>`; //inclucde for title and date/time of the quake
          listElement.appendChild(item); // add it to the listElement
        });
    
        listElement.innerHTML = quakeList.features
          .map(quake => {
            return `<li data-id=${quake.id}>${//add id of the quake as a properity of the li
              quake.properties.title //quake title
            } <div>${new Date(quake.properties.time)}</div></li>`;//quake date and time
          })
          .join('');
      }
      renderQuake(quake, element) {
        const quakeProperties = Object.entries(quake.properties); //turn the object into an array to iterate over it easier
        // for the provided quake make a list of each of the properties associated with it
        element.innerHTML = quakeProperties
          .map(item => {
            if (item[0] === 'time' || item[0] === 'updated') {
              return `<li>${item[0]}: ${new Date(item[1])}</li>`;
            } else return `<li>${item[0]}: ${item[1]}</li>`;
          })
          .join(''); //append the list to the provided element.
      }
}