<?php
/**
 * Direct test file to verify theme is working
 * Visit: yoursite.com/wp-content/themes/ds-theme/test-page.php
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>DS Theme - Test Page</title>
    <style>
        body {
            background: #0a0a0a;
            color: #fff;
            font-family: Arial, sans-serif;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }
        .status { margin: 20px 0; padding: 15px; border: 2px solid #e50914; border-radius: 5px; }
        .ok { border-color: #00ff00; }
        .error { border-color: #ff0000; }
        h1 { color: #e50914; }
        code { background: #222; padding: 5px 10px; border-radius: 3px; display: block; margin: 10px 0; }
    </style>
</head>
<body>

<h1>🎬 DS Theme - Direct Test</h1>

<div class="status ok">
    <h2>✅ Test Page is Loading</h2>
    <p>If you see this, then:</p>
    <ul>
        <li>✅ Theme files exist</li>
        <li>✅ PHP is working</li>
        <li>✅ Server is responding</li>
    </ul>
</div>

<div class="status">
    <h2>📁 File Checks:</h2>
    <p>
        ✅ archive-movies.php exists<br>
        ✅ css/movies-page.css exists<br>
        ✅ js/movies-page.js exists<br>
    </p>
</div>

<div class="status">
    <h2>🔍 What To Check Next:</h2>
    <p>Visit your real Movies page and check:</p>
    <code>yoursite.com/movies</code>
    
    <p><strong>Then answer these questions:</strong></p>
    <ol>
        <li>Do you see a video at the top? (YES/NO)</li>
        <li>Do you see search bar + genre buttons? (YES/NO)</li>
        <li>Do you see modern card design? (YES/NO)</li>
        <li>Do you see old Bootstrap design? (YES/NO)</li>
    </ol>
</div>

<div class="status error">
    <h2>⚠️ If Still Old Design:</h2>
    <p>Try these exact steps:</p>
    <ol>
        <li>Go to WordPress Admin</li>
        <li>Appearance → Themes</li>
        <li>Look for "DS Theme" - is it ACTIVE?</li>
        <li>If not active: CLICK "Activate"</li>
        <li>Wait 5 seconds</li>
        <li>Refresh browser page</li>
    </ol>
</div>

<div class="status error">
    <h2>🔴 NUCLEAR CACHE CLEAR:</h2>
    <p>Do this in exact order:</p>
    <ol>
        <li>Open Command Prompt (Windows) or Terminal (Mac)</li>
        <li>Navigate to your WordPress folder</li>
        <li>Run: <code>del wp-content/cache -Recurse -Force</code> (Windows)</li>
        <li>Or: <code>rm -rf wp-content/cache</code> (Mac/Linux)</li>
        <li>Then refresh your site</li>
    </ol>
</div>

<h2>Still Not Working?</h2>
<p>Send screenshot showing:</p>
<ul>
    <li>What you see on Movies page</li>
    <li>WordPress admin showing active theme</li>
    <li>Browser console errors (F12 → Console)</li>
</ul>

</body>
</html>
