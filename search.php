<?php
require('./includes/nav.inc.php');
require_once('./includes/api_functions.php'); // Ensure this is included to access your API functions

// Check if the search query is set
if (isset($_GET['query'])) {
    $query = urlencode($_GET['query']);
    $category_id = isset($_GET['category_select']) ? $_GET['category_select'] : '';
    $trending = isset($_GET['trending']) ? $_GET['trending'] : '';

    // Construct the API URL using the function from api_functions.php
    $newsData = getNewsFromAPI($query, $category_id, $trending);

    // Check if news data is available
    if (isset($newsData['articles']) && !empty($newsData['articles'])) {
        // Display the results
        echo '<div class="card-container" id="results-container">'; // Added id here
        foreach ($newsData['articles'] as $article) {
            if (!empty($article['title']) && !empty($article['description'])) {
                ?>
                <div class="card">
                    <?php if (!empty($article['urlToImage'])) { ?>
                        <img src="<?php echo htmlspecialchars($article['urlToImage']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>">
                    <?php } ?>
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p><?php echo htmlspecialchars($article['description']); ?></p>
                        <div class="card-meta">
                            <span class="date"><?php echo date('M d, Y', strtotime($article['publishedAt'])); ?></span>
                            <?php if (!empty($article['source']['name'])) { ?>
                                <span class="source"><?php echo htmlspecialchars($article['source']['name']); ?></span>
                            <?php } ?>
                        </div>
                        <a href="<?php echo htmlspecialchars($article['url']); ?>" target="_blank" class="btn btn-primary">Read More</a>
                    </div>
                </div>
                <?php
            }
        }
        echo '</div>'; // Close the results container
        echo '<script>document.getElementById("results-container").scrollIntoView();</script>'; // Scroll to results
    } else {
        echo "<p>No articles found.</p>";
    }
}
?>

<!-- Container to store Search filters -->
<section class="search-box">
    <div class="container p-2">
        <form method="GET" class="search-article" action="search.php">
            <div class="box-container d-flex">
                <table class=".search-table">
                    <tr>
                        <td>
                            <input class="search-input" type="text" name="query" id="query" placeholder="Search" autocomplete="off" required />
                        </td>
                    </tr>
                </table>
            </div>
            <div class="filters">
                <div>
                    <label for="category_select">Category</label>
                    <select name="category_select" id="category_select">
                        <option value="">Select Any Category</option>
                        <?php
                        // Category Query to fetch all the categories from DB in lexicographic order
                        $categoryQuery = "SELECT * FROM category ORDER BY category_name ASC";
                        $result = mysqli_query($con, $categoryQuery);
                        while ($data = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $data['category_id'] . '">' . $data['category_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="trending">Trending</label>
                    <input type="checkbox" name="trending" id="trending" value="1">
                </div>
            </div>
            <center>
                <button type="submit" name="search" class="btn btn-primary">Search</button>
            </center>
        </form>
    </div>
</section>

<?php
// Fetching all the Footer Data
require('./includes/footer.inc.php');
?>