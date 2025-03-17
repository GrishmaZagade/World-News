<?php
require_once('./includes/api_functions.php');

// Fetch news data from the API
$newsData = getNewsFromAPI();

// Check if news data is available
if (isset($newsData['articles']) && !empty($newsData['articles'])) {
?>
    <header class="img-slider">
        <?php
        foreach ($newsData['articles'] as $index => $article) {
            // Ensure article has a title and description
            if (!empty($article['title']) && !empty($article['description'])) {
                $activeClass = ($index === 0) ? 'active' : ''; // Set the first article as active
                ?>
                <div class="slide <?php echo $activeClass; ?>">
                    <?php if (!empty($article['urlToImage'])) { ?>
                        <img src="<?php echo htmlspecialchars($article['urlToImage']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>">
                    <?php } ?>
                    <div class="info">
                        <h1><?php echo htmlspecialchars($article['title']); ?></h1>
                        <p><?php echo htmlspecialchars($article['description']); ?></p>
                        <a href="<?php echo htmlspecialchars($article['url']); ?>" target="_blank" class="btn btn-primary">Read More</a>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </header>
    <div class="navigation">
        <?php for ($i = 0; $i < count($newsData['articles']); $i++) { ?>
            <div class="slide-nav-btn <?php echo ($i === 0) ? 'active' : ''; ?>"></div>
        <?php } ?>
    </div>
<?php
} else {
    echo "<p>No news articles available.</p>";
}
?>