<?php
// Fetching all the Navbar Data
require_once('./includes/nav.inc.php');
require_once('./api_news.php');

// Available categories
$categories = ['business', 'entertainment', 'general', 'health', 'science', 'sports', 'technology'];
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Get news directly from API
$newsData = getNewsFromAPI($category);

// Function to truncate text
function truncateText($text, $maxLength = 100) {
    return strlen($text) > $maxLength ? substr($text, 0, $maxLength) . '...' : $text;
}

// Function to format article date
function formatArticleDate($date) {
    $timestamp = strtotime($date);
    return date("F j, Y", $timestamp);
}
?>


   

<?php
require_once('./includes/footer.inc.php');
?>
