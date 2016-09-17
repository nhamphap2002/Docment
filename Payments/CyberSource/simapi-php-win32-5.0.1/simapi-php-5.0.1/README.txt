===============================================================================
CyberSource Simple Order API for PHP
Copyright 2004-2007 CyberSource Corporation
===============================================================================


-------------------------------------------------------------------------------
RELEASE NOTES
-------------------------------------------------------------------------------

Please refer to the CHANGES.txt file for the release notes.


-------------------------------------------------------------------------------
REQUIREMENTS
-------------------------------------------------------------------------------

--------------------
System Requirements
--------------------

* Windows XP and 2000 or later
* PHP4 (4.2.1 or later)
   or
  PHP5 (5.0.0 - 5.0.3, 5.1.0 - 5.1.2, 5.2.0 - 5.2.5)



-------------------------------------------------------------------------------
CONFIGURATION AND TESTING
-------------------------------------------------------------------------------

1. You need a security key (<your merchant id>.p12) in order to send requests
   to the server.  If you do not have your key yet, refer to the accompanying
   Developer's Guide for the procedure to create one.
   
2. Unzip the CyberSource package into a directory of your choice.  This will
   create a directory called simapi-php-n.n.n, where n.n.n. is the package version.
   
3. Copy phpN_cybersource.dll into the PHP extension directory, where N is:
     4   if your PHP version is 4.x.x
     5   if your PHP version is 5.0.0, 5.0.1, or 5.0.2
     503 if your PHP version is 5.0.3
     512 if your PHP version is 5.1.0, 5.1.1, or 5.1.2
     525 if your PHP version is between 5.2.0 and 5.2.5, inclusive.  It may or
         may not work with future versions.

   If you do not know where the PHP extension directory is, look inside php.ini
   and search for "extension_dir".  The value it is set to is the PHP extension
   directory.  If you do not already have "extension_dir" set to an explicit
   directory:
	a. Create an extension directory (outside of the client installation
	   directory).
	b. Set "extension_dir" to that directory.
	c. Copy the phpN_cybersource.dll file to that directory location.
   
4. In php.ini, look for the section "Windows Extensions", and add one of the
   following lines anywhere before the next section, depending on your PHP
   version as in the previous step:
   
	extension=phpN_cybersource.dll

   where N is the same number you picked in step 3 above.

   and then, save your change.
   
5. Add the lib directory of the CyberSource client installation to the system
   PATH (not the user path as it wouldn't be visible to IIS).  This will make
   the DLLs included in the CyberSource package available to the CyberSource
   PHP extension.

6. Go to the simapi-php-n.n.n\samples\nvp directory.

7. Edit cybs.ini and make the following changes:

	a. Set merchantId to your merchantID.  Please note that this is
	   case-sensitive.
	
	b. Set keysDirectory to the directory where your key resides.  The 
           client includes a "keys" directory that you can use.
	   
	(Optional Additional Changes)
	
	c. Set targetAPIVersion to the latest version of the server API.  By
	   default, it is set to the latest version when the package was
           created.
	   
           To determine the latest version available, go to:
           https://ics2ws.ic3.com/commerce/1.x/transactionProcessor/
           The latest version is listed first.
	    
	d. Modify the logging properties as appropriate.  The log directory you
           specify must already exist.  The client includes a "logs" directory
           that you can use.
	   
	e. Set sslCertFile to the directory to the full path of the file
           containing the bundle of CA root certificates necessary for SSL
           communication.  By default, the client looks for a file called
           ca-bundle.crt in the keys directory.  If you move it such that it is
           no longer in the same directory as your key(s) and/or if you rename
           it, you must specify its full path (including the filename) in the
           sslCertFile property, e.g. "c:\sampleLocation\ca-bundle.crt".
	   
	NOTE:  sendToProduction is initially set to false.  Set it to true only
	       when you are ready to send live transactions.
	
8. Run the name-value pair sample by typing:

	<php dir>\php authCaptureSample.php
   	   
	
If you also wish to test the XML Sample:

1. Go to the simapi-php-n.n.n\samples\xml directory.

2. Modify cybs.ini as appropriate or copy over the one from
   simapi-php-n.n.n\samples\nvp directory.
   
3. Run the XML sample by typing:
	<php dir>\php authSample.php
	
	
If you also wish to test the Sample Store:

1. Copy all the files in simapi-php-n.n.n\samples\store into your web server's
   document root directory.  For Apache, it is the directory to which
   "DocumentRoot" is set to inside httpd.conf.  (Note:  This is a
   simplistic approach.  As you may already have files there that may have
   the same name as the files in the sample store, you may want to back up
   all the existing files before performing this step.)  For IIS, you may
   want to create a virtual directory and put the files there.
   
2. Modify cybs.ini as appropriate or copy over the one from
   simapi-php-n.n.n\samples\nvp or simapi-php-n.n.n\samples\xml directory.

3. Inside checkout.php, change the call to cybs_load_config() to include
   the full path to cybs.ini.

4. Restart your web server. If you are using IIS, you will need to restart
   your computer for IIS to pick up the additional entry in the system
   path you added earlier.

4. Open a Web browser and type the following URL:
   http://<web server name or IP>/<virtual dir, if applicable>/phpinfo.php

   Search for "cybersource support" and verify that it is "enabled".
   If you can't find it, it might be looking in a different php.ini.

5. Type the following URL and click on the Submit button on the page:
   http://<web server name or IP>/<virtual dir, if applicable>/checkout.php

        
-------------------------------------------------------------------------------
THIRD-PARTY LICENSES
-------------------------------------------------------------------------------

This product includes software developed by the Apache Software Foundation
(<http://www.apache.org>).

See the accompanying NOTICE and LICENSE files.


-------------------------------------------------------------------------------
DOCUMENTATION
-------------------------------------------------------------------------------

For more information about installing and using this software package, see the
accompanying documentation.
 
Business Center users:

For information about how to use the various payment services, see the 
Business Center Simple Order API User's Guide, available in the documentation
area of the Business Center.
 
Enteprise Business Center users:

For information about how to use a specific ICS service, see the Implementation
Guide for that service. The Implementation Guides are available on the Support
Center at:

http://www.cybersource.com/support_center/support_documentation/services_documentation/
