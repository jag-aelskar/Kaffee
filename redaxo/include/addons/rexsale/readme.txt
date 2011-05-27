REXsale, http://www.gn2-netwerk.de
------------------------------------------------------
REXsale ist nicht fertig und ist noch Alpha Software!
Benutzung auf eigene Gefahr!
------------------------------------------------------

Systemvoraussetzungen
    * PHP 4
    * MySQL4 (UTF-8 kodiert)


------------------------------------------------------
Installation:

	DB Einrichten
	    *  MySQL connection collation: utf8_general_ci
    	* Default collation: utf8_general_ci

	Redaxo Installieren
		* UTF8 Kodiert

	In redaxo/addons/
		Addon PHPMailer aktivieren
		Addon URLRewrite installieren/aktivieren
			(auch wenn URLRewrite nicht gebraucht wird!)
		Addon REXsmarty installieren (von GN2-Netwerk.de) 
		Addon REXsale installieren 


Nach der Installation (WICHTIG!)

	In Redaxo > RexSale > Konfiguration
		Konfiguration anpassen bzw:
			BaseNoSSL und BaseSSL


Demo Daten
	In Redaxo > Import / Export:
	
	rexsale_rex4_livebytes_demo.sql
	
	und 
	
	rexsale_rex4_livebytes_demo.tar.gz
		(Es kann sein, dass Sie die Ordner files/_css,
		files/_js, files/_templates und files/_img per FTP erstellen
		müssen)

	..importieren.
		

------------------------------------------------------
REXsale SEF (schöne URLs)

Redaxo > Addons > urlrewrite > Installieren/Aktivieren
Redaxo > System > Mod-Rewrite = TRUE



/.htaccess - RewriteRule /shop/ anpassen wenn Sie die Shopkategorie umbenannt haben!!!
####################################
RewriteEngine On
RewriteBase /
RewriteRule (.*)\/shop/(.*)$ index.php?article_id=2%{QUERY_STRING}&SHOPKEY=$2&SHOPLANG=$1 [L]
RewriteRule .*\/index.html$ index.php?%{QUERY_STRING} [L]
RewriteRule .*\/$ index.php?%{QUERY_STRING} [L]
####################################

/redaxo/.htaccess
####################################
RewriteEngine Off
####################################


Changelog von 3.2 => 4
WICHTIG!!

ALTER TABLE `rex_153_products2cats` DROP INDEX `rPROD`;
ALTER TABLE `rex_153_values2products` CHANGE `fMODIFIER` `fMODIFIER` VARCHAR( 20 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '+';
ALTER TABLE `rex_153_values2products` CHANGE `fMODIFIER` `fMODIFIER` CHAR( 1 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;


