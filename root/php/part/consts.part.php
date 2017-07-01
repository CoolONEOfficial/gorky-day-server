<?php

# ==== Consts ====

# Constants

# --- Code ---

# Debug mode
define('DEBUG', false);

# Internet
define('INTERNET', true);

# Password method
define('PASSWORD_METHOD', PASSWORD_DEFAULT);

# Sleep time (in seconds)
define('SLEEP_TIME', 5);

// Life length

# Restore key
define('KEY_RESTORE_LIFE_MINUTES', 15);

# Session key
define('KEY_SESSION_LIFE_DAYS', 7);

// Length

# Restore password
define('RESTORE_PASS_LEN', 6);

# Key
define('KEY_LEN', 16);

# Login
define('LOGIN_LEN_MIN', 4);
define('LOGIN_LEN_MAX', 32);

# Pass
define('PASS_LEN_MIN', 8);
define('PASS_LEN_MAX', 255);

# Message
define('MSG_LEN_MIN', 1);
define('MSG_LEN_MAX', 512);

# User agent
define('USER_AGENT_LENGTH_MAX', 250);

// Flags

# Signed
define('FLAG_SIGNED',     true );
define('FLAG_UNSIGNED', false);
