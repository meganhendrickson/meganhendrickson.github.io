// CODE EXPLAINED channel

//Select the Elements
const clear = document.querySelector(".clear");
const dateElement = document.getElementById("date");
const list = document.getElementById("list");
const input = document.getElementById("input");

// Classes names
const CHECK = "fa-check-circle";
const UNCHECK = "fa-circle-thin";
const LINE_THROUGH = "lineThrough";

// Variables
let LIST, id;

// get item from local storage
let data = localStorage.getItem("TODO");

// if data is not empty
if(data){
    LIST = JSON.parse(data);
    id = LIST.length; // set the id to the last
    loadList(LIST); // load the list to the UI
}else{
    // if data is empty
    LIST = [];
    id = 0;
}

// load items to the UI
function loadList(array){
    array.forEach(function(item){
        addToDo(item.name, item.id, item.done, item.trash);
    });

}

//clear the local storage
clear.addEventListener("click", function(){
    localStorage.clear();
    location.reload();
});

// Show today's date
const options = {weekday:"long", month:"short", day:"numeric"};
const today = new Date();
dateElement.innerHTML = today.toLocaleDateString("en-US", options);

// Add to do function
function addToDo(toDo, id, done, trash){
    //check if item is in the trash
    if(trash){ return;}

    // check if item is completed
    const DONE = done ? CHECK : UNCHECK;
    const LINE = done ? LINE_THROUGH : "";
    
    const item = `
        <li class="item">
            <i class="fa ${DONE} co" job="complete" id="${id}"></i>
            <p class="text ${LINE}">${toDo}</p>
            <i class="fa fa-trash-o de" job="delete" id="${id}"></i>
        </li>
    `;

    const position = "beforeend";

    list.insertAdjacentHTML(position, item);   
}


//addToDo("drink water", 1, true, false); //code for testing

// add an item to the list user the enter key
document.addEventListener("keyup", function(even){
    if(event.keyCode == 13){
        const toDo = input.value;
        // if the input is not empty
        if(toDo){
            addToDo(toDo, id , false, false);
            //place item in LIST array
            LIST.push({
                name : toDo,
                id : id,
                done: false,
                trash: false
            });

            //add item to local storage (this code must be added everywhere the LIST arraw is updated)
            localStorage.setItem("TODO", JSON.stringify(LIST));

            id++;
        }
        input.value = "";
    }
});

// Complete to do
function completeToDo(element){
    element.classList.toggle(CHECK);
    element.classList.toggle(UNCHECK);
    element.parentNode.querySelector(".text").classList.toggle(LINE_THROUGH);

    //update LIST array
    LIST[element.id].done = LIST[element.id].done ? false : true;
}

//remove to do item (trash)
function removeToDo(element){
    element.parentNode.parentNode.removeChild(element.parentNode);

    //update LIST array
    LIST[element.id].trash = true;
}

// target the items created dynamically
list.addEventListener("click", function(event){
    const element = event.target; // return the clicked element inside list
    const elementJob = element.attributes.job.value; // complete or delete

    if(elementJob == "complete"){
        completeToDo(element);
    }else if(elementJob == "delete"){
        removeToDo(element);
    }

    //add item to local storage (this code must be added everywhere the LIST arraw is updated)
    localStorage.setItem("TODO", JSON.stringify(LIST));
});


function showAll(){
    clearList();
    LIST.forEach(function(item){
        addToDo(item.name, item.id, item.done, item.trash);
    });
}

//clear list
function clearList(){
    var child = list.lastElementChild;
    while(child){
        list.removeChild(child);
        child = list.lastElementChild;
    }
}

function clearItem(item, index){
    list.removeChild(item);
}

function showCompleted(){
    clearList();
    LIST.forEach(function(item){
        if(item.done == true){
            addToDo(item.name, item.id, item.done, item.trash);
        }
    });
}

// show only active items
function showActive(){

    clearList();
    LIST.forEach(function(item){
        if(item.done != true){
            addToDo(item.name, item.id, item.done, item.trash);
        }
    });

}