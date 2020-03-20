<?php

return [
    'name' => 'Transferência Bancária',
    'description' => 'Transferência Bancária',
    'bank_name' => env('BANK_TRANSFER_NAME', 'Banco do Brasil'),
    'account_type' => env('BANK_TRANSFER_ACCOUNT_TYPE', 'Conta Corrente'),
    'account_name' => env('BANK_TRANSFER_ACCOUNT_NAME', 'John Doe'),
    'account_number' => env('BANK_TRANSFER_ACCOUNT_NUMBER', '99999-999-99999'),
    'bank_swift_code' => env('BANK_TRANSFER_SWIFT_CODE', 'ABC-123'),
    'note' => env('BANK_TRANSFER_SWIFT_NOTE', 'Choosing this option may delay the shipment of the item.')
];