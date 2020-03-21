//helper function to fetch the data from an external source and return it in JSON format
function getJSON(url) {
    return fetch(url)
        .then(function(response){
            if (!response.ok) {
                throw Error(response.statusText);
            } else {
                return response.json();
            }
        })
        .catch(function(error) {
            console.log(error);
        });
}

//model code
function getShips(url) {
    return getJSON(url);
}

//view code
function renderShipList (ships, shipListElement) {
    const list = shipListElement; //references <tbody> portion of the table
    list.innerHTML ='';
    //loop through ships
    ships.forEach(function(ship) {
        //create elemeents for the list (<tr>)
        let listItem = document.createElement('tr');
        listItem.innerHTML = `
        <td><a href ="${ship.url}">${ship.name}</a></td>
        <td>${ship.length}</td>
        <td>${ship.crew}</td>    
        `;
    
    listItem.addEventListener('click', function(event) {
        event.preventDefault();
        getShipDetails(ship.url);
    });

    //add the list item to the list
    list.appendChild(listItem);
    });
}

//render details to HTML
function renderShipDetails(shipData) {
    console.log(shipData);
    const results = shipData.results;
}

//controller code
function showShips(url = 'https://swapi.co/api/starships/') {
    getShips(url).then(function(data) {
        console.log(data);
        const results = data.results;

        //get the list element
        const shipListElement = document.getElementById('shiplist');
        renderShipList(results, shipListElement);

        //enable the next and previous buttons
        if (data.next) {
            const next = document.getElementById('next');
            //I use onclick instead of touchend because I am testing this code on my computer not on a touch screen device
            next.onclick = () => {
                showShips(data.next);
            };
        }

        if (data.previous) {
            const prev = document.getElementById('prev');

            prev.onclick = () => {
                showShips(data.previous);
            };
        }
    });
}

function getShipDetails(url) {
    //call getJSON functions for the provided url
    getShips(url).then(function(data) {
        renderShipList(data);
        //populate the elements in the #detailbox
    });
}
showShips();