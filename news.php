<?php
// Fetching all the Navbar Data
require('./includes/nav.inc.php');

// Add CSS for buttons
echo '<style>
.btn-toggle {
    background: #2980b9;
    color: #fff;
    padding: 0.6rem 1.3rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}
.btn-toggle.stop {
    background: #c0392b;
}
.btn-toggle:hover {
    transform: translateY(-2px);
}

/* Flex container for article and aside */
.container {
    display: flex;
    width: 1200px;
    margin-right: 5px;
    margin-bottom: 20px; /* Space between the bottom of article and the footer */
}

/* Main article styling (larger than aside) */
.page-container {
    width: 75%; /* Article takes up 75% of the container */
    padding-right: 10px; /* Space between article and aside */
}

/* Sidebar (aside) styling */
aside {
    width: 25%; /* Aside takes up 25% of the container */
    margin-left:5px
    padding-left: 10px; /* Space between article and aside */
}

/* Card styling for aside */
.card2 {
    background: #f9f9f9;
    border: 1px solid #ddd;
    padding: 1rem;
    margin-bottom: 1rem;
}

/* Title styling for aside */
.aside-title {
    font-size: 1.2rem;
    font-weight: bold;
}

/* Optional: Responsive Design for smaller screens */
@media (max-width: 768px) {
    .container {
        flex-direction: column; /* Stack article and aside vertically */
    }

    .page-container, aside {
        width: 100%; /* Both article and aside take full width */
        padding-right: 0;
        padding-left: 0;
    }
}
</style>';

$cat_id = "";

// If we get article_id from URL
if (isset($_GET['id']) && $_GET['id'] != '') {
    $article_id = $_GET['id'];
} else {
    redirect('./index.php');
}

// Article Query to fetch all data related to a particular article
$articleQuery = "SELECT category.category_name, category.category_id, category.category_color, article.*, author.*
                    FROM category, article, author
                    WHERE article.category_id = category.category_id
                    AND article.author_id = author.author_id
                    AND article.article_active = 1
                    AND article.article_id = {$article_id}";

// Bookmarked variable to determine if the article is bookmarked by the user
$bookmarked = false;

if (isset($_SESSION['USER_ID'])) {
    $bookmarkQuery = "SELECT * FROM bookmark 
                        WHERE user_id = {$_SESSION['USER_ID']}
                        AND article_id = {$article_id}";

    $bookmarkResult = mysqli_query($con, $bookmarkQuery);
    if (mysqli_num_rows($bookmarkResult) > 0) {
        $bookmarked = true;
    }
}

$result = mysqli_query($con, $articleQuery);
if (!$result) {
    redirect('./index.php');
}

$row = mysqli_num_rows($result);
if ($row > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $cat_id = $data['category_id'];
        $category_name = $data['category_name'];
        $category_color = $data['category_color'];
        $article_title = $data['article_title'];
        $article_image = $data['article_image'];
        $article_desc = $data['article_description'];
        $article_date = strtotime($data['article_date']);
        $author_name = $data['author_name'];
        ?>
        <section class="article">
            <div class="container">
                <div class="page-container">
                    <article class="card1">
                        <!-- Article Title -->
                        <h1 class="article-heading"><?php echo $article_title; ?></h1>

                        <!-- Article Image -->
                        <img src="./assets/images/articles/<?php echo $article_image; ?>" class="article-image" />

                        <!-- Meta Data -->
                        <div class="meta">
                            <div class="author">
                                <i class="fas fa-user-alt"></i> <?php echo $author_name; ?>
                            </div>
                            <div class="date">
                                <i class="fas fa-calendar-alt"></i> <?php echo date("d M Y", $article_date); ?>
                            </div>
                            <div class="tag <?php echo $category_color; ?>">
                                <?php echo $category_name; ?>
                            </div>
                        </div>

                        <!-- Article Content -->
                        <div class="article-content">
                            <p><?php echo nl2br($article_desc); ?></p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex text-center">
                            <?php
                            // Bookmark Button
                            if ($bookmarked) {
                                echo '<a class="btn btn-bookmark" href="remove-bookmark.php?id=' . $article_id . '">Remove From Bookmark &nbsp<i class="fas fa-bookmark"></i></a>';
                            } else {
                                echo '<a class="btn btn-bookmark" href="add-bookmark.php?id=' . $article_id . '">Add To Bookmark &nbsp<i class="far fa-bookmark"></i></a>';
                            }
                            echo '&nbsp';

                            // Download Button
                            echo '<a class="btn btn-download" target="_blank" href="download-article.php?id=' . $article_id . '">Download Article &nbsp<i class="fas fa-download"></i></a>';
                            echo '&nbsp';

                            // Listen/Stop Button
                            echo '<button class="btn btn-toggle" id="audioButton" onclick="toggleSpeech()">Listen &nbsp<i class="fas fa-volume-up"></i></button>';
                            ?>
                        </div>

                        <!-- Text-to-Speech Script -->
                        <script>
                        let speech = null;
                        let isSpeaking = false;

                        function toggleSpeech() {
                            const button = document.getElementById('audioButton');
                            const articleText = <?php echo json_encode(strip_tags($article_desc)); ?>;

                            // Detect the Google Translate language setting
                            const translateElement = document.querySelector('.goog-te-combo'); // Google Translate dropdown
                            let selectedLang = 'en-US'; // Default language

                            if (translateElement) {
                                const langCode = translateElement.value;
                                if (langCode === 'mr') {
                                    selectedLang = 'mr-IN'; // Marathi
                                }
                            }

                            if (isSpeaking) {
                                // Stop the speech
                                window.speechSynthesis.cancel();
                                speech = null;
                                isSpeaking = false;
                                button.textContent = "Listen ";
                                button.innerHTML += '<i class="fas fa-volume-up"></i>';
                                button.classList.remove("stop");
                            } else {
                                // Start or resume the speech
                                if (!speech) {
                                    speech = new SpeechSynthesisUtterance(articleText);
                                    speech.lang = selectedLang; // Set speech language based on the dropdown
                                    speech.rate = 1;
                                    speech.pitch = 1;

                                    speech.onend = () => {
                                        isSpeaking = false;
                                        button.textContent = "Listen ";
                                        button.innerHTML += '<i class="fas fa-volume-up"></i>';
                                        button.classList.remove("stop");
                                    };
                                }

                                window.speechSynthesis.speak(speech);
                                isSpeaking = true;
                                button.textContent = "Stop ";
                                button.innerHTML += '<i class="fas fa-stop"></i>';
                                button.classList.add("stop");
                            }
                        }
                        </script>
                    </article>
                </div>

                <aside>
                    <!-- Trending Articles Card -->
                    <div class="card2">
                        <h2 class="aside-title">Must read</h2>
                        <?php
                        // Trending Article Query to fetch maximum 5 random trending articles
                        $trendingArticleQuery = "SELECT * FROM article, author
                                                WHERE article.article_trend = 1
                                                AND article.author_id = author.author_id
                                                AND article.article_active = 1
                                                AND NOT article.article_id = {$article_id}
                                                ORDER BY RAND() LIMIT 5";

                        // Running Trending Article Query
                        $trendingResult = mysqli_query($con, $trendingArticleQuery);
                        $row = mysqli_num_rows($trendingResult);

                        // If query has any result (records) => If any trending articles are present
                        if ($row > 0) {
                            while ($data = mysqli_fetch_assoc($trendingResult)) {
                                // Storing the article data in variables
                                $article_id = $data['article_id'];
                                $article_title = $data['article_title'];
                                $article_image = $data['article_image'];
                                $article_date = $data['article_date'];
                                $author_name = $data['author_name'];

                                // Article date is updated to a timestamp 
                                $article_date = strtotime($article_date);
                                $article_date = date("d M Y", $article_date);
                                $article_title = substr($article_title, 0, 75) . ' . . . . .';

                                // Calling user defined function to create an aside article card with respective article details
                                createAsideCard($article_image, $article_id, $article_title, $author_name, $article_date);
                            }
                        }
                        ?>

                        <!-- View all button -->
                        <div class="text-center py-1">
                            <a href="search.php?trending=1" class="btn btn-card">View All <span>&twoheadrightarrow; </span></a>
                        </div>
                    </div>

                    
                </aside>
            </div>
        </section>
        <?php
    }
}

?>
