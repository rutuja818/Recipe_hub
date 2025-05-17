document.getElementById('searchButton').addEventListener('click', () => {
    const ingredients = document.getElementById('searchBar').value;
    const apiKey = '2841d96db99b4ae284a7f9f17d7c8594';

    if (!ingredients.trim()) {
        alert("Please enter some ingredients.");
        return;
    }

    // Save search
    fetch('save_search.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `ingredients=${encodeURIComponent(ingredients)}`
    });

    // First API call: Get recipes based on ingredients
    fetch(`https://api.spoonacular.com/recipes/findByIngredients?ingredients=${ingredients}&number=5&apiKey=${apiKey}`)
        .then(response => response.json())
        .then(data => {
            const recipeList = document.getElementById('recipeList');
            recipeList.innerHTML = '';

            data.forEach(recipe => {
                // Second API call: Get full recipe info
                fetch(`https://api.spoonacular.com/recipes/${recipe.id}/information?apiKey=${apiKey}`)
                    .then(res => res.json())
                    .then(fullRecipe => {
                        const recipeDiv = document.createElement('div');
                        recipeDiv.classList.add('recipe');
                        recipeDiv.innerHTML = `
                            <h2>${fullRecipe.title}</h2>
                            <img src="${fullRecipe.image}" width="200"/><br>
                            <p><strong>Ready in:</strong> ${fullRecipe.readyInMinutes} minutes</p>
                            <p><strong>Servings:</strong> ${fullRecipe.servings}</p>
                            <p><strong>Instructions:</strong><br> ${fullRecipe.instructions || 'No instructions available.'}</p>
                            <a href="${fullRecipe.sourceUrl}" target="_blank">View Full Recipe</a>
                        `;
                        recipeList.appendChild(recipeDiv);
                    });
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
