<?php
// Include necessary files
require_once('./includes/nav.inc.php');
require_once('./includes/api_functions.php');

// Get category from URL parameter
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch news
$newsData = getNewsFromAPI($category);
?>
<style>


.btn:hover {
    background-color: var(--primary-color); /* Darker shade on hover */
    transform: translateY(-2px); /* Slight lift on hover */
}

.btn-active {
    background-color: #caf0f8; /* Active button color */
    font-weight: bold; /* Bold text for the active button */
}

.btn-inactive {
    background-color: #007bff; /* Inactive button color */
    color: white; /* Text color */
}
/* Media Queries for Responsiveness */
@media (max-width: 768px) {
    .btn {
        flex: 1 1 100%; 
    }
}

@media (max-width: 480px) {
    .btn {
        padding: 10px; /* Adjust padding for smaller screens */
        font-size: 14px; /* Smaller font size for buttons */
    }
}

        .category-selection {
    display: flex; /* Use flexbox for layout */
    justify-content: center; /* Center the buttons */
    flex-wrap: wrap; /* Allow buttons to wrap on smaller screens */
    margin-bottom: 20px; /* Space below the category selection */
}

.btn {
    background-color: var(--primary-color); /* Default button color */
    color: white; /* Text color */
    padding: 10px 15px; /* Padding for buttons */
    margin: 5px; /* Margin between buttons */
    border-radius: 5px; /* Rounded corners */
    text-decoration: none; /* Remove underline */
    transition: background-color 0.3s, transform 0.2s; /* Smooth transition */
    flex: 1 1 100px; /* Allow buttons to grow and shrink with a minimum width */
    text-align: center; /* Center text in buttons */
}

/* Media Queries for Responsiveness */
@media (max-width: 600px) {
    .btn {
        flex: 1 1 100%; /* Full width buttons on small screens */
    }
}
</style>


<section class="category-list">
    <div class="container">
        <h2 class="category-heading">
            <?php echo empty($category) ? 'Top Headlines' : ucfirst($category) . ' News'; ?>
        </h2>

        <!-- Category Selection -->
        <div class="category-selection">
            <a href="api_news_page.php" class="btn <?php echo empty($category) ? 'btn-primary' : 'btn-secondary'; ?>">All</a>
            <?php
            $categories = ['business', 'entertainment', 'health', 'science', 'sports', 'technology'];
            foreach ($categories as $cat) {
                $activeClass = ($category === $cat) ? 'btn-primary' : 'btn-secondary';
                echo "<a href='api_news_page.php?category={$cat}' class='btn {$activeClass}'>" . ucfirst($cat) . "</a>";
            }
            ?>
        </div>

        <!-- News Articles -->
        <div class="card-container">
            <?php
            if (isset($newsData['articles']) && !empty($newsData['articles'])) {
                foreach ($newsData['articles'] as $article) {
                    if (!empty($article['title']) && !empty($article['description'])) {
                        ?>
                        <div class="card">
                            <?php if (!empty($article['urlToImage'])) { ?>
                                <img src="<?php echo htmlspecialchars($article['urlToImage']); ?>" 
                                     alt="<?php echo htmlspecialchars($article['title']); ?>"
                                     onerror="this.src='./assets/images/placeholder.jpg'">
                            <?php } ?>
                            <div class="card-content">
                                <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                                <p><?php echo htmlspecialchars($article['description']); ?></p>
                                <div class="card-meta">
                                    <span class="date">
                                        <?php echo date('M d, Y', strtotime($article['publishedAt'])); ?>
                                    </span>
                                    <?php if (!empty($article['source']['name'])) { ?>
                                        <span class="source">
                                            <?php echo htmlspecialchars($article['source']['name']); ?>
                                        </span>
                                    <?php } ?>
                                </div>
                                <a href="<?php echo htmlspecialchars($article['url']); ?>" 
                                   target="_blank" 
                                   class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                        <?php
                    }
                }
            } else {
                echo "<div class='no-articles'><p>No articles found.</p></div>";
            }
            ?>
        </div>
    </div>
</section>

<?php
 
?>