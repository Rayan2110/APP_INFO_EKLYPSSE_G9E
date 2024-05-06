<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../CSS/header.css">
        <link rel="stylesheet" href="../CSS/pages.css">
        <meta charset=" utf-8" />
        <title>Contact</title>
    </head>
    <body>
 
    <?php
                // Inclure le fichier header.php
                include 'header.php';
                ?>

    
                
        <div class="contact-container">
            <form action="https://api.web3forms.com/submit" method="POST" class="contact-left">
                <div class="contact-left-title">
                    <h2>Contact Us</h2>
                    <hr>
                </div>
                <input type="hidden" name="access_key" value="f0389b80-465b-4565-ab58-897042271442">
                <input type="text" name="name" placeholder="Your name" class="contact-inputs" required>
                <input type="email" name="email" placeholder="Your email" class="contact-inputs" required>
                <textarea name="message" placeholder="Your message" class="contact-inputs" required></textarea>
                <button type="submit">Submit <img src="Front\Images\arrow_icon.png" alt=""></button>
            </form>
            <div class="contact-right">
                <img src="Front\Images\right_img.png" alt="">
            </div>
        </div>
    </body>
    <footer>

    <?php
                // Inclure le fichier header.php
                include 'footer.php';
                ?>
        
    </footer>
</html>