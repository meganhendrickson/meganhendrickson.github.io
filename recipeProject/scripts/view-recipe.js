allRecipes = getAllRecipes()

const recipeId = window.location.hash.substring(1)

const recipe = findRecipe(allRecipes, recipeId)

if (recipe === undefined) {
    location.assign('./index.html')
}

renderViewPageRecipe(recipe)

//Click to edit the recipe on its own page
document.querySelector('#edit-recipe-button').addEventListener('click', () => {
    const id = uuidv4()
    window.location.assign(`./edit-recipe.html#${recipe.id}`)
})