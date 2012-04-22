<?php

/*

Copyright (C) 2002-2004 Ryan C. Creasey. All rights reserved.
Copyright (C) 2004 Samuel J. Greear. All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:
1. Redistributions of source code must retain the above copyright
   notice, this list of conditions and the following disclaimer.
2. Redistributions in binary form must reproduce the above copyright
   notice, this list of conditions and the following disclaimer in the
   documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY AUTHOR AND CONTRIBUTORS ``AS IS'' AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
ARE DISCLAIMED.  IN NO EVENT SHALL AUTHOR OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
SUCH DAMAGE.

$Id: $

*/

global $_APPREQ;
if (!isset($_APPREQ['error']))
    $_APPREQ['error'] = 500;

switch ($_APPREQ['error']) {

    case 400:
    {
        $title = 'Bad Request';
        $desc = 'The request could not be understood by the server due to ' .
                'malformed syntax.';
        break;
    }
    case 401:
    {
        $title = 'Unauthorized';
        $desc = 'This request requires user authentication';
        break;
    }
    case 403:
    {
        $title = 'Forbidden';
        $desc = 'This server understood your request, but is refusing to ' .
                'fulfill it';
        break;
    }
    case 404:
    {
        $title = 'Not Found';
        $desc = sprintf("The resource '%s' was not found.",
                        $_SERVER['REQUEST_URI']);
        break;
    }
    case 406:
    {
        $title = 'Not Acceptable';
        $desc = 'The resource identified by the request is only capable of ' .
                'generating response entities which have content ' .
                'characteristics not acceptable according to the accept '.
                'headers sent in the request.';
        break;
    }
    case 408:
    {
        $title = 'Request Timeout';
        $desc = 'The client did not produce a request within the time that ' .
                'this server was prepared to wait.';
        break;
    }
    case 500:
    {
        $title = 'Internal Server Error';
        $desc = 'The server encountered an unexpected condition which ' .
                'prevented it from fulfilling the request.';
        break;
    }
    case 501:
    {
        $title = 'Not Implemented';
        $desc = 'This server does not support the functionality required to ' .
                'fulfill the request.';
        break;
    }
    case 503:
    {
        $title = 'Service Unavailable';
        $desc = 'This server is currently unable to handle the request due ' .
                'to a temporary overload or maintenance.';
        break;
    }
    case 505:
    {
        $title = 'HTTP Version Not Supported';
        $desc = 'The server does not support the protocol version that was ' .
                'used in the request message.';
        break;
    }
}

$error = new XMLement('error');
$error->SetAttribute('type', 'http');
$error->AddElement('code', $_APPREQ['error']);
$error->AddElement('title', $title);
$error->AddElement('description', $desc);

$this->PageTitle = 'HTTP Error';
$this->Header = 'HTTP Error';
$this->Data['http_error'] = $error;

?>
