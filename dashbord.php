<?php include 'partials/navbar.php'; ?>
<?php include 'inc/header.php'; ?>

<main>
    <h2>Dashboard</h2>
    <div class="cards">
        <div class="card" onclick="goToPage('experience.php')">Expériences</div>
        <div class="card" onclick="goToPage('feedback.php')">Feedback</div>
        <div class="card" onclick="goToPage('upload.php')">Uploads</div>
    </div>
</main>

<?php include 'inc/footer.php'; ?>
<script src="assets/js/main.js"></script>
