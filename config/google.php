<?php

return [
    'calendar_id' => env('GOOGLE_CALENDAR_ID'),
    'credentials' => storage_path('app/google-credentials.json'),
    'service_account_email' => env('GOOGLE_SERVICE_ACCOUNT_EMAIL'),
];