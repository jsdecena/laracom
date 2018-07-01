<?php

return [
    'name' => 'Bank Transfer',
    'description' => 'Online / Offline Bank fund transfer',
    'bank_name' => env('BANK_TRANSFER_NAME', 'Bank of Mars'),
    'account_type' => env('BANK_TRANSFER_ACCOUNT_TYPE', 'Savings Account (SA)'),
    'account_name' => env('BANK_TRANSFER_ACCOUNT_NAME', 'John Doe'),
    'account_number' => env('BANK_TRANSFER_ACCOUNT_NUMBER', '99999-999-99999'),
    'bank_swift_code' => env('BANK_TRANSFER_SWIFT_CODE', 'ABC-123'),
    'note' => env('BANK_TRANSFER_SWIFT_NOTE', 'Choosing this option may delay the shipment of the item.')
];