<?php
declare(strict_types=1);

/*
 * support_data.php — Data source for contact & support inquiries.
 *
 * This file returns a 2-tier associative array structured as:
 *   [ Support Category => [ Specific Issue 1, Specific Issue 2, ... ] ]
 *
 * It is completely free of hardware specs and location dependencies,
 * making it evergreen and maintenance-free.
 */

function support_categories(): array
{
    return [
        'Report a Listing or Seller' => [
            'Fake or Counterfeit Hardware',
            'Suspicious Seller or Phishing',
            'Misleading Price or Description',
            'Duplicate or Spam Listings'
        ],
        'Transaction Dispute' => [
            'Seller Unresponsive After Payment',
            'Item Defective / Dead on Arrival (DOA)',
            'Meetup No-Show or Late Cancellation',
            'Seller Refusing Agreed Warranty'
        ],
        'Account & Security' => [
            'Cannot Log In or Reset Password',
            'Account Security / Suspicious Activity',
            'Change Email or Account Details'
        ],
        'Website Technical Bug' => [
            'Image Upload Failing',
            'Chat or Messaging Not Working',
            'Search or Filter Errors'
        ],
        'General Inquiry / Feedback' => [
            'Feature Suggestion',
            'Partnership or Advertising',
            'General Question'
        ]
    ];
}
