<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: user_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Hub - Home</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="style.css">


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="file:///C:/recipe/style.css">

</head>
<body>

    <!-- Navigation Bar -->
    <header>
        <div class="logo">Recipe Hub</div>
        <nav>
            <a href="home_page.php">Home</a>
            <a href="diet_plan.php">Diet Plan</a>
            <a href="submit_recipe.html">Submit Recipe</a>
            <a href="search.html">Add Ingredient</a>
            <a href="grocery_home.php">Grocery Order</a>
            <a href="history.php">History</a>
            
            


        </nav>
        <div class="search-icons">
            <i class="fa-solid fa-search"></i>
            <i class="fa-solid fa-bars"></i>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Are You Hungry?</h1>
            <p>Discover new flavors & cook your favorite dishes!</p>
            <button class="cta-button">Recipes</button>
        </div>
    </section>

    <!-- Recipe Categories -->
    <!-- Recipe Categories -->
<section class="categories">
    <h2>Popular Categories</h2>
    <div class="category-grid">
        <div class="category-card">
            <a href="italian.html">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR0xRb_3ObXaP__m4QzQLITxls1P3PSfxqPfw&s" alt="Italian Food">
                <h3>Italian</h3>
            </a>
        </div>
        <div class="category-card">
            <a href="Indian.html">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQqIQvy34g6C2Yg2aL70ZUX42qWHwN6oKECag&s" alt="Indian Food">
                <h3>Indian</h3>
            </a>
        </div>
        <div class="category-card">
            <a href="desserts.html">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRm4Kh5RZ4vTn-ZLgT47rYdTjS0ZCOLfVoWVg&s" alt="Desserts">
                <h3>Desserts</h3>
            </a>
        </div>
    </div>
</section>
<!-- Add this before </body> -->
<div class="recipe-chatbot">
  <button class="chatbot-toggle">Recipe Help</button>
  <div class="chatbot-box">
    <div class="chatbot-header">
      <h4>Recipe Assistant</h4>
      <span class="close-chat">×</span>
    </div>
    <div class="chatbot-body">
      <div class="bot-msg">Hi! Ask me about: <br>
        1. Vegetarian recipes<br>
        2. Chicken dishes<br>
        3. Quick meals<br>
        4. Baking tips<br>
        5. Cooking time</div>
    </div>
    <div class="chatbot-footer">
      <input type="text" placeholder="Type 1-5...">
      <button>Send</button>
    </div>
  </div>
</div>

<style>
.recipe-chatbot {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 1000;
}
.chatbot-toggle {
  background: #f97316;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 20px;
  cursor: pointer;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}
.chatbot-box {
  width: 250px;
  background: white;
  border-radius: 10px;
  box-shadow: 0 0 15px rgba(0,0,0,0.1);
  display: none;
  flex-direction: column;
  height: 300px;
}
.chatbot-header {
  background: #f97316;
  color: white;
  padding: 10px;
  border-radius: 10px 10px 0 0;
  display: flex;
  justify-content: space-between;
}
.chatbot-body {
  flex: 1;
  padding: 10px;
  overflow-y: auto;
}
.chatbot-footer {
  display: flex;
  padding: 8px;
  border-top: 1px solid #eee;
}
.chatbot-footer input {
  flex: 1;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}
.chatbot-footer button {
  background: #f97316;
  color: white;
  border: none;
  padding: 8px 12px;
  margin-left: 5px;
  border-radius: 4px;
  cursor: pointer;
}
.bot-msg {
  background: #f1f1f1;
  padding: 8px 12px;
  border-radius: 10px;
  margin: 5px 0;
  font-size: 14px;
}
.close-chat {
  cursor: pointer;
  font-size: 18px;
}
</style>

<script>
document.querySelector('.chatbot-toggle').addEventListener('click', function() {
  document.querySelector('.chatbot-box').style.display = 'flex';
  this.style.display = 'none';
});
document.querySelector('.close-chat').addEventListener('click', function() {
  document.querySelector('.chatbot-box').style.display = 'none';
  document.querySelector('.chatbot-toggle').style.display = 'block';
});

document.querySelector('.chatbot-footer button').addEventListener('click', respondToQuery);
document.querySelector('.chatbot-footer input').addEventListener('keypress', function(e) {
  if(e.key === 'Enter') respondToQuery();
});

function respondToQuery() {
  const input = document.querySelector('.chatbot-footer input');
  const msg = input.value.trim();
  if(!msg) return;
  
  const chatBody = document.querySelector('.chatbot-body');
  const userMsg = document.createElement('div');
  userMsg.textContent = msg;
  userMsg.style.textAlign = 'right';
  userMsg.style.margin = '5px 0';
  chatBody.appendChild(userMsg);
  
  let response = "";
  switch(msg) {
    case '1': response = "Try our Vegetable Stir Fry or Eggplant Parmesan recipes!"; break;
    case '2': response = "Recommended: Chicken Tikka Masala or Lemon Garlic Roast Chicken"; break;
    case '3': response = "Quick options: 15-min Pasta or Microwave Mug Cake"; break;
    case '4': response = "Baking tip: Always preheat oven and measure ingredients precisely"; break;
    case '5': response = "Most recipes show cooking time. Filter by '30-min meals' if needed"; break;
    default: response = "Please choose 1-5 for recipe help";
  }
  
  const botMsg = document.createElement('div');
  botMsg.className = 'bot-msg';
  botMsg.textContent = response;
  chatBody.appendChild(botMsg);
  
  input.value = '';
  chatBody.scrollTop = chatBody.scrollHeight;
}
</script>


  
    <!-- Footer -->
    <footer>
       <h3><p>&copy; 2025 Recipe Hub | All Rights Reserved</p></h3>
       <h3><p>&copy; contact:recipehub@gmail.com,9876456278</p></h3>
    </footer>
</body>