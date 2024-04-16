<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carousel Pagination Gallery</title>
  <style>
    .carousel {
      position: relative;
      width: 100%;
      overflow: hidden;
    }

    .carousel-container {
      display: flex;
      transition: transform 0.5s ease;
    }

    .carousel-slide {
      min-width: 100%;
      flex: 0 0 auto;
    }

    img {
      width: 100%;
      height: auto;
    }

    .prev-btn,
    .next-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0, 0, 0, 0.5);
      color: white;
      padding: 10px;
      border: none;
      cursor: pointer;
    }

    .prev-btn {
      left: 10px;
    }

    .next-btn {
      right: 10px;
    }
  </style>
</head>
<body>

<div class="carousel">
  <div class="carousel-container">
    <?php
      // Connect to your database
      $conn = new mysqli("localhost", "root", "", "uts_db");

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Query to fetch images from the database
      $sql = "SELECT * FROM shopproducts";
      $result = $conn->query($sql);

      // Display images in the carousel
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo '<div class="carousel-slide">';
          echo '<img src="../../img/' . $row["shop_ID"] . '/products/' . $row["product_ID"] . '.png" alt="HELLOWORLD">';
          echo '</div>';
        }
      } else {
        echo "0 results";
      }
      $conn->close();
    ?>
  </div>
  <button class="prev-btn">Prev</button>
  <button class="next-btn">Next</button>
</div>

<script>
  const carouselSlide = document.querySelector(".carousel-slide");
  const nextButton = document.querySelector(".next-btn");
  const prevButton = document.querySelector(".prev-btn");
  const slides = document.querySelectorAll(".carousel-slide");

  let counter = 0;
  const size = slides[0].clientWidth;

  nextButton.addEventListener("click", () => {
    if (counter >= slides.length - 1) return;
    carouselSlide.style.transition = "transform 0.5s ease-in-out";
    counter++;
    carouselSlide.style.transform = `translateX(${-size * counter}px)`;
  });

  prevButton.addEventListener("click", () => {
    if (counter <= 0) return;
    carouselSlide.style.transition = "transform 0.5s ease-in-out";
    counter--;
    carouselSlide.style.transform = `translateX(${-size * counter}px)`;
  });

  carouselSlide.addEventListener("transitionend", () => {
    if (slides[counter].id === "last-clone") {
      carouselSlide.style.transition = "none";
      counter = slides.length - 2;
      carouselSlide.style.transform = `translateX(${-size * counter}px)`;
    }
    if (slides[counter].id === "first-clone") {
      carouselSlide.style.transition = "none";
      counter = slides.length - counter;
      carouselSlide.style.transform = `translateX(${-size * counter}px)`;
    }
  });
</script>

</body>
</html>
