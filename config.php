<?php

  class jQueryConfig {
    public $subdomain = 'fishbowl';                // Your Wufoo username. If when logged into Wufoo the domain is example.wufoo.com, put "example" here
    public $apiKey = 'AOI6-LFKL-VM1Q-IEX9';        // XXXXX-XXXX-XXXX-XXXX   - From the Entry Manager, click Code button for any form then click API Information button
    public $hash = array();                        // Array of hashes of the form/report you want to pull be able to data from. If used, attempted API calls made to non-specified hashes will result in no call being made. If left blank, API calls may be made to any valid form/report hash for this API key. Added to address security concern where users could potentially make API calls against any form/report hash when jQuery wrapper is used (Added by sdunham 8/22/2011)
  }

?>