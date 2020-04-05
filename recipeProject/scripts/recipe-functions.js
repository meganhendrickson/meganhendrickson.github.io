//Save recipe to local storage
const saveRecipes = (allRecipes) => {
    const recipesStringified = JSON.stringify(allRecipes)
    localStorage.setItem('Recipes', recipesStringified)
}
//Retrieve recipes from local storage
const getAllRecipes = () => {
    let recipesJSON = localStorage.getItem('Recipes')
    if (recipesJSON === null) {
        recipesJSON = "[{\"id\":\"adf4c594-b991-430f-9548-e5b77bd2651d\",\"plan\":false,\"name\":\"Bagel and Cheese\",\"description\":\"Toast the bagel. Spread cream cheese on it. Enjoy!\",\"ingredients\":[{\"id\":\"7c605ef7-ede6-44de-9754-4fa30776f833\",\"name\":\"Blueberry Bagel\",\"completionStatus\":false},{\"id\":\"d0dad136-0a35-42ee-9fee-56ad2148a006\",\"name\":\"Cream Cheese\",\"completionStatus\":false}]},{\"id\":\"3c59d0f0-079f-4bbb-8002-2f2597c8a841\",\"plan\":true,\"name\":\"Peanut Butter and Jam\",\"description\":\"Spread peanut butter on one slice of bread. Spread jam on the other slice of bread. Put them together and enjoy!\",\"ingredients\":[{\"id\":\"8eb46e4e-ffc1-49b1-a924-895a709ee2a6\",\"name\":\"2 slices Bread\",\"completionStatus\":false},{\"id\":\"75082091-5ebe-46b6-b730-4b17ce421229\",\"name\":\"Peanut Butter\",\"completionStatus\":false},{\"id\":\"aac72eb5-c385-4efd-9f7d-735d2e498493\",\"name\":\"Jam\",\"completionStatus\":false}]}]"
    }
    return recipesAll = JSON.parse(recipesJSON)
}

const findRecipe = (allRecipes, recipeId) => {
    const recipe = allRecipes.find(function (element) {
        return element.id === recipeId
    })
    return recipe
}

//Click to view to all recipes
document.querySelector('#all-recipes-button').addEventListener('click', () => {
    const id = uuidv4()
    window.location.assign(`./`)
})

const findIngredient = () => {

}

const addIngredient = (e, recipeIngredients) => {
    const ingredientID = uuidv4()
    recipeIngredients.push({
        id: ingredientID,
        name: e.target.elements[0].value,
        completionStatus: false
    })
}

const renderIngredients = (ingredients) => {
    //Select the ingredients section
    const ingredientSection = document.querySelector('#ingredients-section')
    //Clear Ingredients Section
    ingredientSection.textContent = ''

    ingredients.forEach((element) => {
        //create the ingredient element
        const ingredientItem = document.createElement('p')
        //add element title to item
        let itemName = document.createElement('span')
        if (element.name.length === 0) {
            itemName.textContent = 'Unnamed Ingredient'
        } else {
            itemName.textContent = element.name
        }
        itemName.classList.add('text-element')
        ingredientItem.appendChild(itemName)
        //addremove button to item
        const removeButton = document.createElement('button')
        removeButton.innerHTML = '<i class="fas fa-trash-alt"></i>'
        removeButton.classList.add('remove-element')

        removeButton.addEventListener('click', function () {
            deleteIngredient(ingredients, element)
            renderIngredients(ingredients)
        })
        ingredientItem.appendChild(removeButton)
        //return item as ingredient element
        ingredientSection.appendChild(ingredientItem)
    })
}

const deleteIngredient = (ingredients, element) => {
    const ingredientIndex = ingredients.findIndex((ingredient) => ingredient.id === element.id)
    ingredients.splice(ingredientIndex, 1)
}


const renderRecipe = (recipe) => {
    const recipeName = document.querySelector('#recipe-name')
    const recipeDescription = document.querySelector('#recipe-description')
    recipe.id = window.location.hash.substr(1)
    recipeName.value = recipe.name
    recipeDescription.value = recipe.description
    renderIngredients(recipe.ingredients)
}

const calculateCompletionStatus = (recipe) => {
    let count = 0
    //count number of items in ingredient list
    let numberOfIngredients = recipe.ingredients.length
    console.log(numberOfIngredients)
    //count number of ingredients checked-off
    recipe.ingredients.forEach((ingredient) => {
        if (ingredient.completionStatus === true) {
            count++
        }
    })

    if (count === 0) {
        return 'You have &nbsp <span> none </span> &nbsp of the ingredients'
    } else if (count === numberOfIngredients) {
        return 'You have &nbsp <span> all </span> &nbsp the ingredients'
    } else {
        return 'You have &nbsp <span> some </span> &nbsp of the ingredients'
    }
}

const loadMainPage = () => {
    //Retrieve all recipes from local storage
    const recipesFromStorage = getAllRecipes();
    //Display each recipe in local storage
    if (recipesFromStorage.length === 0) {
        let recipesDIV = document.querySelector('#recipes-div')
        let titleParagraph = document.createElement('h2')
        titleParagraph.innerHTML = 'You currently have 0 recipes stored in your Recipe App!'
        recipesDIV.appendChild(titleParagraph)
    } else {
        recipesFromStorage.forEach(renderMainPageRecipes)
    }

}

//Recipe filter function
const filterRecipes = (allRecipes, filter) => {
    return filteredArray = allRecipes.filter((recipe) => recipe.name.toLowerCase().includes(filter))
}

const renderFilteredRecipes = (filteredRecipes) => {
    let recipesDIV = document.querySelector('#recipes-div')
    recipesDIV.textContent = ''
    filteredRecipes.forEach(renderMainPageRecipes)
}

const loadMealPlan = () => {
    mealPlan = checkedRecipes();
    renderFilteredRecipes(mealPlan);
}

const checkedRecipes = () => {
    let allRecipes = getAllRecipes()
    return allRecipes.filter(recipe => recipe.plan === true);
}

const getShoppingListIngredients = () => {
    mealPlan = checkedRecipes();
    let ingredients = [];
    mealPlan.forEach(recipe => {
        ingredients = ingredients.concat(recipe.ingredients);
    })

    return ingredients;
}

const renderShoppingList = (ingredients) => {

    //Select the ingredients section
    const shoppingListDisplay = document.querySelector('#shopping-list-display')
    //Clear Ingredients Section
    shoppingListDisplay.textContent = ''

    //create the ingredient element
    const shoppingList = document.createElement('ul')
    ingredients.forEach((element) => {
        //add element title to item
        let itemName = document.createElement('li')
        itemName.textContent = element.name
        itemName.classList.add('text-element')
        shoppingList.appendChild(itemName)
        //return item as ingredient element
        shoppingListDisplay.appendChild(shoppingList)
    })
}



// display main recipe list
const renderMainPageRecipes = (recipe) => {

    let recipesDIV = document.querySelector('#recipes-div')
    let planCheckbox = document.createElement('input')
    let titleParagraph = document.createElement('h4')
    let recipeBox = document.createElement('a')

    planCheckbox.setAttribute('type', 'checkbox')
    planCheckbox.checked = recipe.plan
    planCheckbox.classList.add('checkbox')

    titleParagraph.textContent = recipe.name
    titleParagraph.appendChild(planCheckbox)
    titleParagraph.classList.add('list-item')

    recipeBox.appendChild(titleParagraph)
    recipeBox.setAttribute('href', `./view-recipe.html#${recipe.id}`)
    recipeBox.style.textDecoration = 'none'

    //check for checkbox changes and update recipe status
    planCheckbox.addEventListener('change', (e) => {
        let localRecipe = findRecipe(allRecipes, recipe.id);
        localRecipe.plan = e.target.checked;
        saveRecipes(allRecipes)
    })

    recipesDIV.appendChild(recipeBox)
}

const deleteRecipe = (allRecipes, recipeId) => {
    const recipeIndex = allRecipes.findIndex((recipe) => recipe.id === recipeId)

    allRecipes.splice(recipeIndex, 1)
}

// display individual recipe
const renderViewPageRecipe = (recipe) => {
    recipe.id = window.location.hash.substr(1)
    document.querySelector('#recipe-name').innerHTML = recipe.name
    document.querySelector('#recipe-description').innerHTML = recipe.description
    renderViewPageIngredients(recipe.ingredients)
}

const renderViewPageIngredients = (ingredients) => {
    //Select the ingredients section
    const ingredientSection = document.querySelector('#ingredients-section')
    //Clear Ingredients Section
    ingredientSection.textContent = ''

    //create the ingredient element
    const ingredientItem = document.createElement('ul')
    ingredients.forEach((element) => {
        //add element title to item
        let itemName = document.createElement('li')
        if (element.name.length === 0) {
            itemName.textContent = 'Unnamed Ingredient'
        } else {
            itemName.textContent = element.name
        }
        itemName.classList.add('text-element')
        ingredientItem.appendChild(itemName)
        //return item as ingredient element
        ingredientSection.appendChild(ingredientItem)
    })
}