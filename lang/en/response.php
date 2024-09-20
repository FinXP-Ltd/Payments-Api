<?php

return [
    'error' => [
        'not_found' => 'No results found!',
        'unauthorized' => 'Unauthorized to make a request',
        'forbidden' => 'You don\'t have permission to access / this server',
        'general' => 'There was a problem encountered while trying to fulfill your request',
        'method_not_allowed' => 'Method not allowed.',

        'kycp_error' => 'There was a problem while trying to communicate to the server.',
        'duplicate_error' => 'An application with the same details already exists',

        'validation' => 'The given data was invalid!',

        'transfer_error' => 'The given iban and/or application is invalid',

        'application_approved' => 'Cannot update an already approved application',

        'application_closed' => 'Cannot update an already closed account'
    ],
    'success' => [
        'general' => 'Your :message has been submitted successfully!',
        'action' => ':item has been :action successfully!'
    ],
    'failed' => [
        'action' => 'Unable to :action :item!'
    ],
    'kycp_error' => 'There was a problem while communicating on KYCP'
];
