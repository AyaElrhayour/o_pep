<?php 
session_start();
if(isset($_SESSION["logged"]) && $_SESSION["logged"] && isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  header("Location: dashboard.php");
}
require_once('./app/funcs/plant.php');
require_once('./app/funcs/cart.php');
require_once("./app/funcs/category.php");
require_once('./app/funcs/logout.php');

$categories = getAll();

$plants = getPlants();




 function addPlantToCart(){
    
    if(isset($_POST["add"])){
        if (addToCart($_POST["plant_id"])){
            header('Location: home.php');
        }else{
            die('failed');
        }
    }
 }

 addPlantToCart();




 function clientLogout() {
  if (isset($_POST["logout"])) {
   
    if (logout()) {
      // die("here");
      header("Location: index.php");
    }
  }
}

clientLogout();

?>


<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="assets/imgs/logoG.png" type="image/x-icon">

        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

        <link rel="stylesheet" href="./assets/css/home.css">

        <title>Home </title>
    </head>
    <body>
        <header class="header" id="header">
            <nav class="nav container">
                <a href="#" class="nav__logo">
                    <img src="./assets/imgs/logoG.png" alt="logo">
                </a> 
                <div class="search">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input name="plant_name" type="text" placeholder="Search here">
                        <i class="ri-search-2-line"></i>
                    </form>
               </div>
                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="#home" class="nav__link active-link">Home</a>
                        </li>
                        <li class="nav__item">
                            <a href="#products" class="nav__link">Products</a>
                        </li>
                        <!-- shopping cart -->
                        <li>
                          <button class="button--flex navbar__button cart-open">
                            <i class="ri-shopping-bag-line"></i>
                        </button>
                      </li>
                         <!-- log out -->
                        <li>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                          <button type="submit" name="logout" class="button--flex navbar__button">
                          <i class="ri-logout-box-r-line"></i>
                        </button>
                        </form>
                      </li>                      
                    </ul>
                    
                    <div class="nav__close" id="nav-close">
                        <i class="ri-close-line"></i>
                    </div>
                </div>
            </nav>
            <div class="popup-container">
              <div class="cart_popup">
                  <button class="cart-close">
                    <i class="ri-close-circle-line"></i>
                  </button>
                <img class="logo" src="./assets/imgs/logoW.png" alt="">
                <h1>Your Plants</h1>
                <ul class="cartItemsList">
                  <li>
                    <div class="pic">
                    <img src="./assets/imgs/product1.png" alt="">
                    </div>
                    <div class="info">
                      <p>plant name</p>
                      <p>plant category</p>
                    </div>
                    <div class="price">
                      <p>price</p>
                    </div>
                    <div class="removePlant">
                    <i class="ri-close-circle-fill"></i>
                  </div>
                  </li>
                </ul>
                <div class="check-out">
                  <div class="total">0$</div>
                  <button class="clear">Clear All</button>
                  <button class="check">Check Out</button>
                </div>
              </div>
            </div>
        </header>

        
        <main class="main">

            <section class="home" id="home">
                <div class="home__container container grid">
                    <img src="assets/imgs/home.png" alt="" class="home__img">

                    <div class="home__data">
                        <h1 class="home__title">
                            Plants will make <br> your life better
                        </h1>
                        <p class="home__description">
                            Create incredible plant design for your offices or apastaments. 
                            Add fresness to your new ideas.
                        </p>
                        <a href="#products" class="button button--flex">
                            Explore <i class="ri-arrow-right-down-line button__icon"></i>
                        </a>
                    </div>

                   
                </div>
            </section>
            
            <section class="product section container" id="products">
                <h2 class="section__title-center">
                    Check out our products
                </h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="select-container">
                <select class="form-select" name="category_id" id="category">
                <option value="0" selected>Plant Category</option>
                    <?php foreach ($categories as $category){?>
                <option value="<?php echo $category["category_id"]; ?>">
                      <?php echo $category["category_name"]; ?>
                    </option>
                    <?php }?>
            </select>
            <div class="icon-container">
              <i class="ri-arrow-down-s-fill"></i>
            </div>
            <button class="select-btn" type="submit">Filter</button>
        </form>
                <div class="product__container grid">
                
                <?php foreach ($plants as $plant) {
              ?>
                    <article class="product__card">
                        <div class="product__circle"></div>

                        <img src="assets/imgs/<?php echo $plant["plant_img"]; ?>" alt="" class="product__img">

                        <h3 class="product__title"><?php echo $plant["plant_name"]; ?></h3>
                        <span class="product__price"><?php echo $plant["plant_price"]; ?>$</span>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input name="plant_id" type="hidden" value="<?php echo $plant["plant_id"]; ?>">
                        <button  name="add" type="submit" class="button--flex product__button">
                            <i class="ri-shopping-bag-line"></i>
                        </button>
                    </form>
                    </article>
                    <?php
              }    ?>

            </section>

        </main>

        <footer class="footer section">
            <div class="footer__container container grid">
                <div class="footer__content">
                <a href="#" class="nav__logo">
                    <img src="./assets/imgs/logoG.png" alt="">
                </a>




                </div>

                <div class="footer__content">
                    <h3 class="footer__title">Our Address</h3>

                    <ul class="footer__data">
                        <li class="footer__information">1234 - Safi</li>
                        <li class="footer__information">P2306</li>
                      
                    </ul>
                </div>

                <div class="footer__content">
                    <h3 class="footer__title">Contact Us</h3>

                    <ul class="footer__data">
                        <li class="footer__information">0617196324</li>
                        
                        <div class="footer__social">
                            <a href="https://www.facebook.com/" class="footer__social-link">
                                <i class="ri-facebook-fill"></i>
                            </a>
                            <a href="https://www.instagram.com/" class="footer__social-link">
                                <i class="ri-instagram-line"></i>
                            </a>
                            <a href="https://twitter.com/" class="footer__social-link">
                                <i class="ri-twitter-fill"></i>
                            </a>
                        </div>
                    </ul>
                </div>
            </div>


        </footer>
        


        <script src="./assets/js/home.js"></script>
    </body>
</html>