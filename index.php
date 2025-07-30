<?php
// require_once 'config.php';
require_once 'db.php';
require_once 'includes/layout.php';


$selectedCategory = $_GET['category'] ?? null;

// Prepare SQL query
if ($selectedCategory) {
  $stmt = $pdo->prepare("SELECT id, title, location, event_date, thumbnail_url, category 
                           FROM events 
                           WHERE featured = 1 AND category = :category 
                           ORDER BY event_date ASC");
  $stmt->execute(['category' => $selectedCategory]);
} else {
  $stmt = $pdo->query("SELECT id, title, location, event_date, thumbnail_url, category 
                         FROM events 
                         WHERE featured = 1 
                         ORDER BY event_date ASC");
}
$events = $stmt->fetchAll();

ob_start();
?>

<section class="hero">
  <h1>Unlock the stage to <br><span>unforgettable sounds.</span></h1>
  <div class="search-bar">
    <input type="text" placeholder="Search for event">
    <button>🔍</button>
  </div>
  <p class="sub-text">Get tickets to gigs, parties and festivals<br>for the best price in the market.</p>
</section>


<section class="categories" style="text-align: center; margin: 20px 0;">
  <a href="index.php" class="category-btn">All</a>
  <a href="index.php?category=music" class="category-btn">Music</a>
  <a href="index.php?category=movie" class="category-btn">Movie</a>
  <a href="index.php?category=concert" class="category-btn">Concert</a>
  <a href="index.php?category=festival" class="category-btn">Festivals</a>


  
</section>


<section class="featured-events">
  <h2>Featured Events</h2>
  <div class="event-grid">
    <?php if (count($events) === 0): ?>
      <p>No featured events currently.</p>
    <?php else: ?>
      <?php foreach ($events as $event): ?>
        <div class="event-card" data-category="<?php echo strtolower($event['category'] ?? ''); ?>">

          <div class="thumbnail" style="background-image: url('<?php echo htmlspecialchars($event['thumbnail_url']); ?>');"></div>
          <h3><?php echo htmlspecialchars($event['title']); ?></h3>
          <p><?php echo htmlspecialchars($event['location']) . ' - ' . date('d/m/Y', strtotime($event['event_date'])); ?></p>
          <form method="POST" action="add_cart.php">
            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
            <button type="submit" class="buy">Buy Tickets</button>
          </form>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>









<?php
$content = ob_get_clean();

renderLayout($content);
