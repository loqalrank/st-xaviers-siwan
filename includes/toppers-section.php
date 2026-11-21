<?php
/**
 * Renders the "Our School Toppers" section on the home page.
 * Data is read from includes/toppers-config.php so details can be
 * updated without touching this markup.
 */

$toppersConfigFile = __DIR__ . '/site-config.php';
if (!is_file($toppersConfigFile)) {
    return;
}

$siteConfig    = include $toppersConfigFile;
$toppersConfig = isset($siteConfig['toppers']) ? $siteConfig['toppers'] : [];
if (empty($toppersConfig['enabled']) || empty($toppersConfig['toppers'])) {
    return;
}

$toppersKicker   = isset($toppersConfig['kicker']) ? $toppersConfig['kicker'] : 'Proud Achievers';
$toppersTitle    = isset($toppersConfig['title']) ? $toppersConfig['title'] : 'Our School Toppers';
$toppersSubtitle = isset($toppersConfig['subtitle']) ? $toppersConfig['subtitle'] : '';
$toppersYear     = isset($toppersConfig['year']) ? $toppersConfig['year'] : '';
$toppersList     = $toppersConfig['toppers'];

$toppersInitials = function ($name) {
    $name  = trim((string) $name);
    $parts = preg_split('/\s+/', $name, -1, PREG_SPLIT_NO_EMPTY);
    if (!$parts) {
        return '?';
    }
    $first = strtoupper(substr($parts[0], 0, 1));
    $last  = count($parts) > 1 ? strtoupper(substr($parts[count($parts) - 1], 0, 1)) : '';
    return $first . $last;
};

$toppersResolveImage = function ($path) {
    $path = ltrim((string) $path, '/');
    if ($path === '') {
        return '';
    }
    return is_file(__DIR__ . '/../' . $path) ? $path : '';
};
?>
<section class="section toppers-section">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <div class="kicker"><?php echo htmlspecialchars($toppersKicker, ENT_QUOTES, 'UTF-8'); ?></div>
            <h2 class="section-title"><?php echo htmlspecialchars($toppersTitle, ENT_QUOTES, 'UTF-8'); ?></h2>
            <?php if ($toppersSubtitle !== ''): ?>
                <p class="lead-copy mx-auto"><?php echo htmlspecialchars($toppersSubtitle, ENT_QUOTES, 'UTF-8'); ?><?php echo $toppersYear !== '' ? ' (' . htmlspecialchars($toppersYear, ENT_QUOTES, 'UTF-8') . ')' : ''; ?></p>
            <?php elseif ($toppersYear !== ''): ?>
                <p class="lead-copy mx-auto"><?php echo htmlspecialchars($toppersYear, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($toppersList as $topper):
                $name  = isset($topper['name']) ? $topper['name'] : '';
                $class = isset($topper['class']) ? $topper['class'] : '';
                $score = isset($topper['score']) ? $topper['score'] : '';
                $note  = isset($topper['note']) ? $topper['note'] : '';
                $image = $toppersResolveImage(isset($topper['image']) ? $topper['image'] : '');
            ?>
                <div class="col-6 col-md-4 reveal">
                    <div class="topper-card">
                        <div class="topper-photo">
                            <?php if ($image !== ''): ?>
                                <img src="<?php echo htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($class, ENT_QUOTES, 'UTF-8'); ?> topper" width="220" height="220" loading="lazy">
                            <?php else: ?>
                                <span class="topper-initials" aria-hidden="true"><?php echo htmlspecialchars($toppersInitials($name), ENT_QUOTES, 'UTF-8'); ?></span>
                            <?php endif; ?>
                            <?php if ($note !== ''): ?>
                                <span class="topper-badge"><?php echo htmlspecialchars($note, ENT_QUOTES, 'UTF-8'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="topper-body">
                            <h3 class="topper-name"><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></h3>
                            <?php if ($class !== ''): ?>
                                <p class="topper-class"><?php echo htmlspecialchars($class, ENT_QUOTES, 'UTF-8'); ?></p>
                            <?php endif; ?>
                            <?php if ($score !== ''): ?>
                                <p class="topper-score"><?php echo htmlspecialchars($score, ENT_QUOTES, 'UTF-8'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
