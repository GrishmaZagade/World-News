<div id="google_translate_element"></div>

<style>
 /* Custom styles for Google Translate element */
.goog-te-gadget {
  font-family: Arial, sans-serif !important;
  display: inline-block;
  text-align: center;
}

/* Hide Google Translate icon */
.goog-te-gadget-icon,
.goog-te-menu-value span:last-child {
  display: none !important;
}

/* Style the Google Translate menu */
.goog-te-menu-value {
  color: #004cff !important; /* Matches primary color */
  display: inline-flex !important;
  align-items: center !important;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* Remove right padding from the first child */
.goog-te-menu-value span:first-child {
  padding-right: 0 !important;
}

/* Container for the gadget */
.goog-te-gadget-simple {
  background-color: #e8f1ff !important; /* Light blue background for contrast */
  border: 1px solid #004cff !important; /* Border matches primary color */
  border-radius: 6px; /* Smooth corners */
  font-size: 12px;
  font-weight: 700;
  display: inline-block;
  padding: 8px 12px !important;
  cursor: pointer;
  text-align: center;
  transition: all 0.3s ease;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Text color */
.goog-te-gadget-simple span {
  color: #004cff !important;
  font-family: "Arial", sans-serif;
}

/* Hover effect */
.goog-te-gadget-simple:hover {
  background-color: #c8dfff !important;
  box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px);
}

/* Make the entire widget responsive */
@media (max-width: 768px) {
  .goog-te-gadget-simple {
    font-size: 10px;
    padding: 6px 8px !important;
  }
}

</style>

<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'en',
      includedLanguages: 'en,en-GB,hi,bn,te,ta,mr,gu,kn,ml,pa,es,fr,de,it,ja,zh-CN,zh-TW,ko,ru,ar,pt,nl,tr,pl,sv,vi,th,id,ms',// Specify the languages you want
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
  }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


<?php
// Fetching all the Functions and DB Code
require_once('./includes/functions.inc.php');
require_once('./includes/database.inc.php');


// Creates a session or resumes the current one based on a session identifier. 
session_start();

// Getting the URI From the Web
$uri = $_SERVER['REQUEST_URI'];

// Variable to store the page title used in title tag
$page_title = "";

// Flag variables to know which Page we are at
$home = true;
$login = false;
$bookmark = false;
$changePass = false;
$category = false;
$search = false;

// Strpos returns the position of the search string in the main string or returns 0 (false)
// Checking if the page is Home Page
if (strpos($uri, "index.php") != false) {
  $page_title = " Home";
}

// Checking if the page is Login Page
if (strpos($uri, "login.php") != false) {
  $page_title = " Login";
  $home = false;
  $login = true;
}

// Checking if the page is Bookmarks Page
if (strpos($uri, "bookmarks.php") != false) {
  $page_title = " Bookmarks";
  $home = false;
  $bookmark = true;
}

// Checking if the page is Bookmarks Page
if (strpos($uri, "user-change-password.php") != false) {
  $page_title = " Change Password";
  $home = false;
  $changePass = true;
}

// Checking if the page is Home Page
if (strpos($uri, "categories.php") != false) {
  $page_title = " Categories";
  $home = false;
  $category = true;
}

// Checking if the page is Search Page
if (strpos($uri, "search.php") != false) {
  $page_title = " Search";
  $home = false;
  $search = true;
}

// Checking if the page is Articles Page
if (strpos($uri, "articles.php") != false) {
  $home = false;
  $page_title = "All Article";
}

// Checking if the page is New Article Page
if (strpos($uri, "news.php") != false) {
  $home = false;
  $page_title = "News Article";
}

// Add this with other flag variables
$apiNews = false;

// Then add this check with other page checks
// Checking if the page is API News Page
if (strpos($uri, "api_news_page.php") != false) {
    $page_title = " API News";
    $home = false;
    $apiNews = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- PARTIAL CSS INCLUSIONS -->
  <link rel="stylesheet" href="./assets/css/partials/0-fonts.css" />
  <link rel="stylesheet" href="./assets/css/partials/1-variables.css" />
  <link rel="stylesheet" href="./assets/css/partials/2-reset.css" />
  <link rel="stylesheet" href="./assets/css/partials/3-typography.css" />
  <link rel="stylesheet" href="./assets/css/partials/4-component.css" />

  <!-- CUSTOM CSS INCLUSIONS -->
  <link rel="stylesheet" href="./assets/css/style.css" />

  <!-- RESPONSIVITY CSS INCLUSIONS -->
  <link rel="stylesheet" href="./assets/css/responsivity/media-queries.css" />

  <!-- FAVICON LINK -->
  <link rel="icon" href="./assets/images/favicon1.ico" type="image/x-icon" />

  <!-- TITLE OF THE PAGE -->
  <title>World News | The Official News Portal | <?php echo $page_title; ?></title>

  <!-- FONTAWESOME LINK -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
</head>

<body>

  <!-- ======== BACK TO TOP BUTTON ======== -->
  <button onclick="topFunction()" class="topNavBtn" id="topNavBtn" title="Go to top"><i
      class="fa fa-arrow-up"></i></button>


  <!-- ======== NAVBAR ======== -->
  <nav class="navbar">
    <div class="logo"><a href="./index.php"><img src="./assets/images/world-news-logo.png" /></a></div>
    <label for="btn" class="icon">
      <span class="fa fa-bars"></span>
    </label>
    <input type="checkbox" id="btn" class="input" />
    <ul class="ul">
      <!-- We ECHO class current based upon the boolean variables used in above PHP Snippet -->
      <li><a href="./index.php" <?php if ($home) echo 'class="current"' ?>>Home</a></li>
      <li>
        <label for="btn-1" class="show">Categories +</label>
        <a href="./categories.php" <?php if ($category) echo 'class="current"' ?>>Categories</a>
        <input type="checkbox" id="btn-1" class="input" />
        <ul>
          <?php

          // Category Query to fetch random 4 categories
          $categoryQuery = " SELECT  category_id, category_name
                              FROM category 
                              ORDER BY RAND() LIMIT 4";

          // Running Category Query
          $result = mysqli_query($con, $categoryQuery);

          // Returns the number of rows from the result retrieved.
          $row = mysqli_num_rows($result);

          // If query has any result (records) => If there are categories
          if ($row > 0) {

            // Fetching the data of particular record as an Associative Array
            while ($data = mysqli_fetch_assoc($result)) {

              // Storing the category data in variables
              $category_id = $data['category_id'];
              $category_name = $data['category_name'];
          ?>
              <li><a href="articles.php?id=<?php echo $category_id ?>"><?php echo $category_name ?></a></li>
          <?php
            }
          }
          ?>
          <li><a href="./categories.php">More +</a></li>
        </ul>
      </li>
      <li><a href="./bookmarks.php" <?php if ($bookmark) echo 'class="current"' ?>>Bookmarks</a></li>
      <?php
      if (isset($_SESSION['USER_NAME'])) {
      } else {
      ?>
        <li>
          <label for="btn-2" class="show">Login +</label>
          <a href="./user-login.php" <?php if ($login) echo 'class="current"' ?>>Login</a>
          <input type="checkbox" id="btn-2" class="input" />
          <ul>
            <li><a href="./user-login.php">Reader</a></li>
            <li><a href="./author-login.php">Author</a></li>
          </ul>
        </li>
      <?php
      }
      ?>
      <li><a href="./api_news_page.php" <?php if ($apiNews) echo 'class="current"' ?>>API News</a></li>
      
      <li>
        <a href="./search.php" <?php if ($search) echo 'class="current"' ?>>
          <span>Search</span>
          <i id="search-icon" class="fas fa-search"></i>
        </a>
      </li>
      <?php

      // If user is logged in
      if (isset($_SESSION['USER_NAME'])) {
        echo '
          <li>
            <label for="btn-2" class="show">Settings</label>
            <a href="#"';

        if ($changePass) {
          echo 'class="current" ';
        }
        echo
        '>Settings</a>
            <input type="checkbox" id="btn-2" class="input" />
            <ul>
              <li><a href="./user-change-password.php">Change Password</a></li>
              <li><a href="./logout.php">Logout</a></li>
              </ul>
          </li>
          ';
        echo '<li><a disabled>Hello ' . $_SESSION["USER_NAME"] . ' !</a></li>';
      }
      ?>
    </ul>
  </nav>