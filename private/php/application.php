<?php
# evilcode.net
# $Id$

class UserApp extends Application {

    function __construct() {
        parent::__construct();

        $this->SitePath  = SITE_BASE . '/private/inc';
        $this->AppTitle  = 'evilcode.net';

        $this->Footer   = '&#169; 2006 <a href="http://evilcode.net/">evilcode.net</a>';
        $this->Footer  .= ' | Powered by <a href="http://evilcode.net/projects/exhibition/">Exhibition</a>.';
        $this->Footer  .= ' | Hosted by <a href="http://infernalhosting.net/">Infernal Hosting</a>.';

        # | value of pages that require authentication and their minimum access level
        $protected = array();
        #$protected[] = array('name' => 'profile', 'level' => 0);
        #$protected[] = array('name' => 'admin', 'level' => 1);

        $access = (@$_SESSION['user']['access'] === NULL ) ? -1 : $_SESSION['user']['access'];
        foreach( $protected as $page ) {
          if ($this->Request['page'] == $page['name'] && $access < $page['level'])
            Application::HandleHTTPError(403);
        }

    }

    function PrepareContent() {
        parent::PrepareContent();

    }
}

?>
