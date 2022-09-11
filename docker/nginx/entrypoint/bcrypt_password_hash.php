#!/usr/bin/env php
<?php
$unhashed_password = getenv('ADMIN_PASSWORD');
$hashed_password = password_hash($unhashed_password, PASSWORD_BCRYPT);
echo $hashed_password;
