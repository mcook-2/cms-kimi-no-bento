<?php

/*******w******** 
    
    Name: Mckenzie Cook
    Date: 04.19.2024
    Description: Kimi no Bento CMS index.php 

 ****************/

//include('inc/database.inc.php');

include_once('inc/config.inc.php');

include('inc/header.inc.php');
?>

<section class="featured">
    <div class="container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb ">
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                </ol>
            </nav>
            <h2 class="display-4 mb-4">Welcome to Kimi No Bento</h2>
            <p class="lead">Join our bento community and explore our delicious selection of bento boxes crafted with fresh ingredients.</p>
        </div>
        <h2>Featured Bento Boxes</h2>
        <div class="bento-box">
            <img src="img/bento_1.png" alt="Bento Box 1">
            <h3>Salmon Bento</h3>
            <p>A delightful combination of fresh salmon slices, steamed rice, mixed vegetables, and a side of tangy teriyaki sauce.</p>
        </div>
        <div class="bento-box">
            <img src="img/bento_2.png" alt="Bento Box 2">
            <h3>Sushi & Teriyaki Bento</h3>
            <p>A delicious assortment of sushi rolls, nigiri, and sashimi, accompanied by grilled teriyaki chicken and steamed rice.</p>
        </div>
        <div class="bento-box">
            <img src="img/bento_3.jpg" alt="Bento Box 3">
            <h3>Grilled Chicken Bento</h3>
            <p>Tender grilled chicken marinated in a savory sauce, served with stir-fried vegetables, and fluffy jasmine rice.</p>
        </div>

    </div>
</section>
<?php

include('inc/footer.inc.php');
?>