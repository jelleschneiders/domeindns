<?php

namespace App;

abstract class Status
{
    public static $OK = 'ok';
    public static $FAILED = 'failed';

    public static $PENDING_CREATION = 'pending_creation';
    public static $PENDING_DELETION = 'pending_deletion';
    public static $PENDING_DNSSEC_CREATION = 'pending_dnssec_creation';
    public static $PENDING_DNSSEC_DELETION = 'pending_dnssec_deletion';
    public static $PENDING_UPDATE_DELETION = 'pending_update_deletion';

    public static $TRANSFER_PENDING = 'pending_transfer';
    public static $TRANSFER_ACCEPTED = 'accepted_transfer';
    public static $TRANSFER_REJECTED = 'rejected_transfer';
}
