<?php include_once "./include/header.php";
include_once "scripts/DB.php";

$slides = DB::query("SELECT * FROM slides WHERE active=1 ORDER BY sort_order ASC")->fetchAll(PDO::FETCH_OBJ);
$services = DB::query("SELECT * FROM services WHERE active=1 ORDER BY sort_order ASC")->fetchAll(PDO::FETCH_OBJ);
?>
<style>
.carousel-item {
    height: 85vh;
    min-height: 400px;
    background-size: cover;
    background-position: center;
    position: relative;
}
.carousel-item::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.3));
}
.carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.carousel-caption {
    z-index: 2;
    bottom: 50%;
    transform: translateY(50%);
    text-align: left;
    left: 10%;
    right: 10%;
    max-width: 700px;
}
.carousel-caption h1 {
    font-size: 3.2rem;
    font-weight: 800;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
}
.carousel-caption p {
    font-size: 1.2rem;
    opacity: 0.9;
    max-width: 500px;
}
.carousel-indicators li {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    background: transparent;
    opacity: 0.6;
}
.carousel-indicators li.active {
    background: #fff;
    opacity: 1;
}
</style>

<?php if (count($slides) > 0): ?>
<div id="heroCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
    <ol class="carousel-indicators">
        <?php foreach ($slides as $i => $s): ?>
        <li data-target="#heroCarousel" data-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>"></li>
        <?php endforeach; ?>
    </ol>
    <div class="carousel-inner">
        <?php foreach ($slides as $i => $s): ?>
        <?php $imgPath = 'images/' . $s->image; $hasImg = file_exists($imgPath); ?>
        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>" <?= !$hasImg ? 'style="background:linear-gradient(135deg,#667eea,#764ba2)"' : '' ?>>
            <?php if ($hasImg): ?><img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($s->title ?? 'Slide') ?>"><?php endif; ?>
            <div class="carousel-caption">
                <?php if ($s->title): ?><h1><?= htmlspecialchars($s->title) ?></h1><?php endif; ?>
                <?php if ($s->subtitle): ?><p><?= htmlspecialchars($s->subtitle) ?></p><?php endif; ?>
                <?php if ($s->link): ?>
                <a href="<?= htmlspecialchars($s->link) ?>" class="btn btn-success btn-lg mt-2">
                    <i class="fa fa-arrow-right"></i> Get Started
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </a>
    <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a>
</div>
<?php else: ?>
<section class="hero-section">
    <div class="hero-content container">
        <h1>Welcome to Home Services</h1>
        <p>Nepal's leading platform for electronics, electrical, and home maintenance services. Book trusted professionals near you.</p>
        <div>
            <a href="home.php" class="btn btn-success btn-lg"><i class="fa fa-search"></i> Find a Provider</a>
            <a href="register.php" class="btn btn-light btn-lg"><i class="fa fa-user-plus"></i> Register as Provider</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- How It Works -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">How It Works</h2>
        <p class="section-subtitle">Get your home service in 3 easy steps</p>
    </div>
    <div class="row">
        <div class="col-md-4 text-center mb-4">
            <div class="card service-card border-0">
                <div class="card-body py-5">
                    <div style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:800;margin:0 auto 1rem;">1</div>
                    <h5 class="font-weight-bold">Search & Select</h5>
                    <p class="text-muted mb-0">Choose your city, select a profession, and browse verified providers near you.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="card service-card border-0">
                <div class="card-body py-5">
                    <div style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#34a853,#1e8e3e);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:800;margin:0 auto 1rem;">2</div>
                    <h5 class="font-weight-bold">Book & Pay</h5>
                    <p class="text-muted mb-0">Set your estimated budget, pick a date, and send a booking request instantly.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="card service-card border-0">
                <div class="card-body py-5">
                    <div style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#f093fb,#f5576c);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:800;margin:0 auto 1rem;">3</div>
                    <h5 class="font-weight-bold">Get It Done</h5>
                    <p class="text-muted mb-0">The provider arrives, completes the work, rate your experience afterwards.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Services -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Our Services</h2>
        <p class="section-subtitle">Professional home services at your doorstep</p>
    </div>
    <?php if (count($services) === 0): ?>
    <p class="text-center text-muted">No services listed yet.</p>
    <?php else: ?>
    <div class="row">
        <?php foreach ($services as $svc):
            $img = 'images/' . $svc->image;
            $hasBg = file_exists($img);
            $profession = $svc->profession ? 'home.php?profession=' . urlencode($svc->profession) : 'home.php';
        ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card service-card border-0 text-white" style="<?= $hasBg ? "background:url('$img') center/cover;min-height:320px;" : 'background:linear-gradient(135deg,#667eea,#764ba2);min-height:320px;' ?> position:relative;overflow:hidden;">
                <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.85),rgba(0,0,0,0.3));"></div>
                <div class="card-body d-flex flex-column justify-content-end position-relative" style="z-index:1;min-height:320px;">
                    <h5 class="card-title font-weight-bold"><?= htmlspecialchars($svc->name) ?></h5>
                    <p class="card-text" style="opacity:0.9;font-size:0.9rem;"><?= htmlspecialchars($svc->description ?? '') ?></p>
                    <a href="<?= $profession ?>" class="btn btn-light btn-sm align-self-start"><i class="fa fa-search"></i> Find <?= htmlspecialchars(explode(' ', $svc->name)[0]) ?></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Stats -->
<div style="background: linear-gradient(135deg, #1a73e8, #0d47a1); padding: 4rem 0; color: #fff;">
    <div class="container">
        <div class="row text-center">
            <?php
                $totalProviders = DB::query("SELECT COUNT(*) FROM providers")->fetchColumn();
                $totalBookings = DB::query("SELECT COUNT(*) FROM bookings")->fetchColumn();
                $verifiedProviders = DB::query("SELECT COUNT(*) FROM providers WHERE verified=1")->fetchColumn();
                $completedBookings = DB::query("SELECT COUNT(*) FROM bookings WHERE status=3")->fetchColumn();
            ?>
            <div class="col-md-3 col-6 mb-3">
                <div style="font-size: 2.5rem; font-weight: 800;"><?= $totalProviders ?></div>
                <div style="opacity: 0.8;">Total Providers</div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div style="font-size: 2.5rem; font-weight: 800;"><?= $verifiedProviders ?></div>
                <div style="opacity: 0.8;">Verified</div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div style="font-size: 2.5rem; font-weight: 800;"><?= $totalBookings ?></div>
                <div style="opacity: 0.8;">Total Bookings</div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div style="font-size: 2.5rem; font-weight: 800;"><?= $completedBookings ?></div>
                <div style="opacity: 0.8;">Completed</div>
            </div>
        </div>
    </div>
</div>

<!-- Why Choose Us -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title">Why Choose Us?</h2>
        <p class="section-subtitle">We make home services hassle-free</p>
    </div>
    <div class="row text-center">
        <div class="col-md-3 col-6 mb-4">
            <div style="font-size: 2.5rem; color: var(--primary);"><i class="fa fa-shield"></i></div>
            <h6 class="font-weight-bold mt-2">Verified Pros</h6>
            <small class="text-muted">All providers are verified by admin</small>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div style="font-size: 2.5rem; color: var(--primary);"><i class="fa fa-map-marker"></i></div>
            <h6 class="font-weight-bold mt-2">Live Tracking</h6>
            <small class="text-muted">Find online providers near you</small>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div style="font-size: 2.5rem; color: var(--primary);"><i class="fa fa-calendar-check-o"></i></div>
            <h6 class="font-weight-bold mt-2">Easy Booking</h6>
            <small class="text-muted">Book in minutes, track in real-time</small>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div style="font-size: 2.5rem; color: var(--primary);"><i class="fa fa-star"></i></div>
            <h6 class="font-weight-bold mt-2">Ratings & Reviews</h6>
            <small class="text-muted">See what others say</small>
        </div>
    </div>
</div>

<!-- CTA -->
<div class="container pb-5">
    <div class="card" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none; border-radius: var(--radius);">
        <div class="card-body text-center py-5">
            <h3 class="text-white font-weight-bold mb-2">Ready to get started?</h3>
            <p class="text-white opacity-75 mb-4">Join thousands of happy customers and verified professionals.</p>
            <a href="register.php" class="btn btn-light btn-lg mr-2"><i class="fa fa-user-plus"></i> Register as Provider</a>
            <a href="home.php" class="btn btn-success btn-lg"><i class="fa fa-search"></i> Find a Service</a>
        </div>
    </div>
</div>

<?php include_once "include/footer.php"; ?>
