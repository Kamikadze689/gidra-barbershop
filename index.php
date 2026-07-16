<?php

// Forward requests to the public front controller when the router
// is executed with the project root as the current working directory.
// This prevents errors when the built-in PHP server expects an
// index.php at the project root.

require __DIR__ . '/public/index.php';
