<!DOCTYPE html>
<html>
	<!-- following code is from www.w3schools.com that creates my photo slideshow -->
	<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Main</title>

	<!-- following code is from www.w3schools.com that creates my photo slideshow -->
    <script>
		var slideIndex = 1;
		showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");

    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
        slides[i].classList.remove("slide-left", "slide-right");
    }

    slides[slideIndex-1].style.display = "block";

    if (n > slideIndex) {
        slides[slideIndex-1].classList.add("slide-left");
    } else if (n < slideIndex) {
        slides[slideIndex-1].classList.add("slide-right");
    }

    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    dots[slideIndex-1].className += " active";
}
    </script>

<head>
  <title>Main Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Header -->
  <header>
    <h1>Book Nook</h1>
  </header>

  <!-- Navigation Bar -->
  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="books.php">Books</a></li>
      <li><a href="login.php">Login</a></li>
      <li><a href="favourites.php">Favourites</a></li>
    </ul>
  </nav>

  <!-- Body Content -->
  <section>
    <h2>Welcome to the Book Nook!</h2>
    <p>
Welcome to Book Nook, your ultimate online destination for book lovers! At Book Nook, we've built a comprehensive database of books, complete with their essential information. Our platform goes beyond mere book listings, as we empower our users to curate their own personalized collections of favorite reads. By creating an account and logging in, you gain access to a world of literary exploration where you can effortlessly organize, edit, and expand your unique book collection. Join our vibrant community of readers and become an active participant in shaping the Book Nook database, as you have the freedom to contribute new books and refine existing entries. Embark on a journey of literary discovery with Book Nook, where the joy of reading and the thrill of community engagement seamlessly blend together!</p>
	  
  <!-- Slideshow container (from www.w3schools.com)-->
    <div class="gallery">

		<!-- Navigation Dots -->
<div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
</div>

        <!-- Full-width images with number and caption text -->
        <div class="mySlides fade">
            <div class="numbertext">1 / 3</div>
            <img src="images/littlewomen.jpg" style="width:100%" alt="Product 1">
        </div>
        <div class="mySlides fade">
            <div class="numbertext">2 / 3</div>
            <img src="images/it.jpg" style="width:100%" alt="Product 2">
        </div>

        <div class="mySlides fade">
            <div class="numbertext">3 / 3</div>
            <img src="images/normalpeople.jpg" style="width:100%" alt="Product 3">
        </div>

        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
	</section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2023 Gabrielle's Website. All rights reserved.</p>
  </footer>
	<script>
		showSlides(slideIndex);
	</script>
	</body>
	</html>