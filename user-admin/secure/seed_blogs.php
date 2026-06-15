<?php
/**
 * Database Seeder for QASWAH HEALTH CLINIC Blogs
 */
require_once __DIR__ . '/db_connect.php';

if (!empty($db_connection_error)) {
    echo "SEED_ERROR: Database connection failed: " . $db_connection_error . "\n";
    exit(1);
}

echo "Database connection successful. Initializing categories and posts...\n";

// Disable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// 1. Seed Categories
$categories = [
    ['name' => "Women's Health", 'slug' => 'womens-health'],
    ['name' => "Men's Health", 'slug' => 'mens-health'],
    ['name' => 'Couples Care', 'slug' => 'couples-care'],
    ['name' => 'Hormones', 'slug' => 'hormones'],
    ['name' => 'Physical Therapy', 'slug' => 'physical-therapy'],
    ['name' => 'LGBTQ+ Wellness', 'slug' => 'lgbtq-wellness']
];

$cat_map = []; // Name -> ID map

foreach ($categories as $cat) {
    $stmt = $conn->prepare("SELECT category_id FROM category WHERE category_slug = ?");
    $stmt->bind_param("s", $cat['slug']);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($cat_id);
        $stmt->fetch();
        $cat_map[$cat['name']] = $cat_id;
        echo "Category '{$cat['name']}' already exists (ID: $cat_id).\n";
    } else {
        $insert = $conn->prepare("INSERT INTO category (category_name, category_slug) VALUES (?, ?)");
        $insert->bind_param("ss", $cat['name'], $cat['slug']);
        if ($insert->execute()) {
            $cat_id = $insert->insert_id;
            $cat_map[$cat['name']] = $cat_id;
            echo "Created Category '{$cat['name']}' (ID: $cat_id).\n";
        } else {
            echo "Error seeding category '{$cat['name']}': " . $conn->error . "\n";
        }
        $insert->close();
    }
    $stmt->close();
}

// 2. Seed Posts
$posts = [
    [
        'title' => "Understanding Vaginismus: A Clinical Guide to Intimacy",
        'slug' => "understanding-vaginismus-a-clinical-guide-to-intimacy",
        'category' => "Women's Health",
        'content' => "<h3>What is Vaginismus?</h3><p>Vaginismus is the involuntary contraction of the pelvic floor muscles when any form of penetration is attempted. It is a highly treatable physical condition that is often accompanied by significant performance stress and relationship friction.</p><p>For many women, the body develops an unconscious 'splinting reflex'—tightening the muscles to protect against anticipated pain. This creates a painful cycle: anticipation of pain leads to tightening, which causes actual pain, reinforcing the initial fear.</p><h3>The Multi-Disciplinary Recovery Plan</h3><p>At QASWAH HEALTH CLINIC, we utilize a highly successful multi-disciplinary model:</p><ul><li><strong>Pelvic Relaxation:</strong> Learning to actively control and release the pelvic muscles.</li><li><strong>Gentle Dilator Therapy:</strong> Re-educating the vaginal muscles slowly and under total patient control.</li><li><strong>Intimacy Psychology:</strong> Identifying cognitive blocks, trauma history, or performance guilt that reinforce the physical constriction.</li></ul><p>Intimacy should be a source of pleasure and connection, not physical distress. Our specialists are here to guide you through a gentle, confidential recovery journey.</p>",
        'meta_title' => "Understanding Vaginismus: A Clinical Guide | QASWAH HEALTH CLINIC",
        'meta_desc' => "Learn what vaginismus is, its physiological and psychological triggers, and how gentle clinical dilation therapies help women achieve painless intimacy.",
        'meta_keyword' => "vaginismus, painful intercourse, female health, pelvic floor therapy, Trichy clinic"
    ],
    [
        'title' => "The Science of Performance Anxiety in Men",
        'slug' => "the-science-of-performance-anxiety-in-men",
        'category' => "Men's Health",
        'content' => "<h3>The Autonomic Nervous System & Intimacy</h3><p>Performance anxiety is one of the primary psychological triggers for erectile dysfunction (ED) and premature ejaculation (PE) in men of all ages. To understand how to break this loop, we must examine the science of the autonomic nervous system.</p><p>Physical intimacy requires a state of relaxation governed by the <strong>parasympathetic nervous system</strong>. However, when a man experiences stress, fear of failure, or high pressure, the body enters a 'fight or flight' state governed by the <strong>sympathetic nervous system</strong>.</p><p>This stress state triggers a massive release of adrenaline and cortisol, which constricts blood vessels and redirects blood flow away from the pelvic organs to the large muscle groups, making an erection physically difficult to sustain.</p><h3>Breaking the Anxiety Loop</h3><p>Our clinical approach at QASWAH HEALTH CLINIC focus on:</p><ul><li><strong>Sensate Focus Exercises:</strong> Mindful physical touch without the pressure of performance.</li><li><strong>Cognitive Restructuring:</strong> Overcoming the self-monitoring habit ('spectatoring') where a man analyzes his performance in real-time.</li><li><strong>Hormonal Diagnostics:</strong> Checking testosterone levels to ensure there are no underlying physical imbalances.</li></ul><p>If you are experiencing these difficulties, remember that it is a common physiological response to stress, not a permanent limitation. Confidential guidance is available.</p>",
        'meta_title' => "Overcoming Performance Anxiety in Men | QASWAH HEALTH CLINIC",
        'meta_desc' => "An in-depth medical analysis of the adrenaline-driven physiological loops that trigger ED, and behavioral ways to break the performance anxiety cycle.",
        'meta_keyword' => "performance anxiety, erectile dysfunction, premature ejaculation, men's sexual health"
    ],
    [
        'title' => "Desire Mismatch in Marriage: Rebuilding Relational Sparks",
        'slug' => "desire-mismatch-in-marriage-rebuilding-relational-sparks",
        'category' => "Couples Care",
        'content' => "<h3>The Myth of Equal Desire</h3><p>In almost every long-term relationship, one partner naturally has a higher spontaneous sex drive than the other. This is medically known as desire mismatch or libido discrepancy. It is not a sign of a failed relationship, but rather a normal human variation.</p><p>The conflict arises when the mismatch is interpreted as rejection, leading to the 'demand-withdraw' dynamic: the higher-desire partner pushes for intimacy, which causes the lower-desire partner to feel pressured and withdraw further.</p><h3>Steps to Align Relational Desire</h3><p>Intimacy therapy focuses on practical tools to navigate this mismatch:</p><ol><li><strong>Understand Spontaneous vs. Responsive Desire:</strong> Some people experience desire out of the blue (spontaneous), while others require arousal, touch, and context first to feel desire (responsive). Recognizing this reduces pressure.</li><li><strong>Redefine Intimacy:</strong> Expanding intimacy to include non-demand touch, massage, and deep emotional connection.</li><li><strong>Establish Safe Boundaries:</strong> Scheduling low-pressure time for relational connection and communication without expectations.</li></ol><p>By removing pressure and learning each other's intimate languages, couples can restore organic desire and rebuild intimate connection.</p>",
        'meta_title' => "Resolving Desire Mismatch in Marriage | QASWAH HEALTH CLINIC",
        'meta_desc' => "It is perfectly natural for couples to have differing levels of sexual desire. Our intimacy experts outline practical steps to resolve desire mismatch.",
        'meta_keyword' => "desire mismatch, marriage counseling, couples therapy, relationship advice, Trichy"
    ],
    [
        'title' => "Understanding Testosterone and Male Vitality",
        'slug' => "understanding-testosterone-and-male-vitality",
        'category' => "Hormones",
        'content' => "<h3>The Role of Testosterone</h3><p>Testosterone is the primary male sex hormone, regulating not only libido and erectile function, but also muscle mass, bone density, mood, cognitive focus, and overall energy levels.</p><p>As men age, testosterone levels naturally decline by about 1% per year starting around age 30. However, modern lifestyles, stress, lack of sleep, and poor diet can accelerate this decline, leading to symptoms like chronic fatigue, brain fog, low libido, and performance anxiety.</p><h3>Natural and Medical Optimizations</h3><p>Reclaiming your vitality involves clear clinical diagnostics followed by custom lifestyle changes:</p><ul><li><strong>Comprehensive Hormone Panels:</strong> Measuring total and free testosterone, SHBG, and prolactin.</li><li><strong>Restorative Sleep:</strong> The majority of testosterone is produced during deep REM sleep; getting 7-8 hours is essential.</li><li><strong>Urological Health:</strong> Ensuring circulatory health and cardiovascular wellness to optimize pelvic blood flow.</li></ul><p>At QASWAH HEALTH CLINIC, we combine scientific endocrine analysis with customized health programs to safely restore your physical energy and intimate vitality.</p>",
        'meta_title' => "Testosterone & Male Vitality Optimization | QASWAH HEALTH CLINIC",
        'meta_desc' => "Explore how testosterone affects energy, mood, and libido, and learn the clinical diagnostics and natural urological habits to optimize hormonal balance.",
        'meta_keyword' => "testosterone, male vitality, hormone therapy, urology, low libido treatment"
    ],
    [
        'title' => "Pelvic Floor Relaxation Exercises for Intimate Wellness",
        'slug' => "pelvic-floor-relaxation-exercises-for-intimate-wellness",
        'category' => "Physical Therapy",
        'content' => "<h3>The Hypertonic Pelvic Floor</h3><p>Many individuals suffer from a 'hypertonic' pelvic floor—meaning the muscles surrounding the pelvic area are constantly held in a state of high tension or spasm. This muscle constriction is a primary cause of physical pain during intimacy, bladder urgency, and pelvic distress.</p><p>Learning to actively relax and lengthen these muscles (rather than strengthen them through Kegels) is crucial for intimate physical wellness and painless connection.</p><h3>Effective Relaxation Techniques</h3><p>We recommend integrating these three gentle stretches into your daily routine:</p><ol><li><strong>Deep Diaphragmatic Breathing:</strong> Breathing deeply into your lower abdomen allows the diaphragm to push down, naturally lengthening and opening the pelvic floor muscles.</li><li><strong>Happy Baby Stretch:</strong> Lie on your back, bend your knees, hold the outer edges of your feet, and gently pull your knees toward the floor to open the pelvic region.</li><li><strong>Deep Squats (Malasana):</strong> A wide-stance deep squat with hands in prayer position helps completely release chronic tension in the lower back and pelvic muscles.</li></ol><p>Consistent pelvic floor physical therapy is a powerful, non-invasive treatment that restores comfort and intimate pleasure.</p>",
        'meta_title' => "Pelvic Floor Relaxation Exercises | QASWAH HEALTH CLINIC",
        'meta_desc' => "Discover key physical relaxation methods that help reduce physical constriction, alleviate pain during intimate moments, and promote pelvic health.",
        'meta_keyword' => "pelvic floor exercises, vaginismus relief, hypertonic pelvic floor, intimate wellness"
    ],
    [
        'title' => "Creating Affirming Intimacy Spaces for All Orientations",
        'slug' => "creating-affirming-intimacy-spaces-for-all-orientations",
        'category' => "LGBTQ+ Wellness",
        'content' => "<h3>Identity Affirmation in Intimacy Therapy</h3><p>Every individual deserves high-quality, scientifically sound, and non-judgmental healthcare. In the field of psychosexual therapy, creating a safe, validating, and affirmative space is vital for patients of all sexual orientations and gender identities.</p><p>Many LGBTQ+ individuals carry minority stress, internal guilt, or social anxiety, which can directly manifest as performance anxiety, relational friction, or intimate aversion.</p><h3>Affirmative Health Practices</h3><p>Our affirmative clinical sexology focuses on:</p><ul><li><strong>Validating Unique Challenges:</strong> Recognizing the distinct relationship structures, gender transitions, and social factors that influence wellness.</li><li><strong>Overcoming internal stress:</strong> Rebuilding self-esteem, overcoming internalized shame, and developing a positive intimate self-concept.</li><li><strong>Safe Sex & Health Guidance:</strong> Offering open, scientifically accurate advice tailored specifically to diverse orientations.</li></ul><p>At QASWAH HEALTH CLINIC, we are proud to offer an inclusive clinic where intimacy is healed and celebrated in all its diverse and beautiful forms.</p>",
        'meta_title' => "LGBTQ+ Affirming Intimate Counseling | QASWAH HEALTH CLINIC",
        'meta_desc' => "An educational look at how validating, affirmative counseling supports healthy self-esteem, overcomes social guilt, and nurtures intimate wellness.",
        'meta_keyword' => "LGBTQ therapy, affirmative counseling, sexology, relational wellness, gender affirmation"
    ]
];

foreach ($posts as $post) {
    $stmt = $conn->prepare("SELECT post_id FROM posts WHERE post_slug = ?");
    $stmt->bind_param("s", $post['slug']);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "Post '{$post['title']}' already exists.\n";
    } else {
        $cat_id = $cat_map[$post['category']];
        $status = 'published';
        $img = ''; // Empty defaults to fallback icon
        $pub_at = date('Y-m-d H:i:s');
        
        $insert = $conn->prepare("INSERT INTO posts 
            (post_title, post_content, post_slug, category_id, meta_title, meta_description, meta_keyword, image_path, post_status, created_at, updated_at, published_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)");
        
        $insert->bind_param("sssissssss", 
            $post['title'], $post['content'], $post['slug'], $cat_id, $post['meta_title'], $post['meta_desc'], $post['meta_keyword'], $img, $status, $pub_at
        );
        
        if ($insert->execute()) {
            echo "Seeded Post '{$post['title']}' (Category: {$post['category']}).\n";
        } else {
            echo "Error seeding post '{$post['title']}': " . $conn->error . "\n";
        }
        $insert->close();
    }
    $stmt->close();
}

// Re-enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "Database seeding successfully finished!\n";
?>
