<?php

$result = QueryNotVerifiedUser($email = GetEmailFromUrl($connection));
ActivationHandling($result);
UpdateUserStatus($email);
