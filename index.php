<?php

/*******w******** 
    
    Name: Mckenzie Cook
    Date: 03.18.2024
    Description: Kimi no Bento CMS index.php 

 ****************/

include('inc/database.inc.php');

include_once('inc/config.inc.php');

include('inc/header.inc.php');
?>



<section class="hero">
    <div class="container">
        <h2>Welcome to our Bento Box World</h2>
        <p>Explore our delicious selection of bento boxes crafted with fresh ingredients.</p>
    </div>
</section>

<section class="featured">
    <div class="container">
        <h2>Featured Bento Boxes</h2>
        <!-- Display featured bento boxes dynamically here -->
        <div class="bento-box">
            <img src="bento1.jpg" alt="Bento Box 1">
            <h3>Bento Box 1</h3>
            <p>Description of the bento box...</p>
        </div>
        <div class="bento-box">
            <img src="bento2.jpg" alt="Bento Box 2">
            <h3>Bento Box 2</h3>
            <p>Description of the bento box...</p>
        </div>
        <!-- Add more featured bento boxes as needed -->
    </div>
</section>
<?php

include('inc/footer.inc.php');
?>