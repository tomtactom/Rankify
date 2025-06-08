<?php
// Application configuration
// Toggle development mode: set to true to display debug messages
const DEV_MODE = false;

// Path for debug log file
const DEBUG_LOG_FILE = __DIR__ . '/../logs/debug.log';

// Base URL of the application (no trailing slash)
const BASE_URL = 'https://rankify.tomaschmann.de';

// Path to SQLite database file
const DB_FILE = __DIR__ . '/../data/rankify.sqlite';

// Minimum number of entries required for normative statistics
const NORM_MIN_COUNT = 30;

