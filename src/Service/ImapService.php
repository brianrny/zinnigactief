<?php
/**
 * Created by PhpStorm.
 * User: henry
 * Date: 19-9-16
 * Time: 13:35
 */

namespace App\Service;


class ImapService
{

    function validatePasswordAction($email, $password)
    {
        $password_verrified = false;
        imap_timeout(IMAP_OPENTIMEOUT, 5);
        imap_timeout(IMAP_READTIMEOUT, 5);
        imap_timeout(IMAP_WRITETIMEOUT, 5);
        imap_timeout(IMAP_CLOSETIMEOUT, 5);
        try {
            $mbox = @imap_open("{outlook.office365.com:993/ssl}INBOX", $email, $password, OP_HALFOPEN, 1, array('DISABLE_AUTHENTICATOR' => array('GSSAPI', 'NTLM')));
            if ($mbox) {
                imap_close($mbox);
                $password_verrified = TRUE;
            }
            unset($mbox);
        } finally {
            restore_error_handler();
        }
        return $password_verrified;

    }
}