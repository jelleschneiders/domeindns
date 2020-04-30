<?php

namespace App\Mail;

use \Spatie\PersonalDataExport\Mail\PersonalDataExportCreatedMail;

class ExportMail extends PersonalDataExportCreatedMail
{
    public function build()
    {
        return $this->subject('Your data export is ready!')
                    ->markdown('personal-data-export::mail');
    }
}
