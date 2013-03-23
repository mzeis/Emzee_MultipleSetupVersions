Emzee_MultipleSetupVersions
===========================

A proof of concept for my problem "[avoid conflicts in setup scripts with multiple developers](http://magento.stackexchange.com/questions/1497/avoid-conflicts-in-setup-scripts-with-multiple-developers)".

Facts
-----
- version: 0.0.3
- extension key: Emzee_MultipleSetupVersions
- [extension on GitHub](https://github.com/mzeis/Emzee_MultipleSetupVersions)

Description
-----------
This extension enables developers to use multiple setup resources in one extension with different version numbers.

Use the resource setup class provided in this extension, create your own `config.xml` and specify:

    <global>
        <resources>
            <[your_setup_name_1]>
                <setup>
                    <module>[Your_Extension]</module>
                    <class>Emzee_MultipleSetupVersions_Model_Resource_Setup</class>
                    <version>0.0.3</version>
                </setup>
            </[your_setup_name_1]>
            <[your_setup_name_2]>
                <setup>
                    <module>[Your_Extension]</module>
                    <class>Emzee_MultipleSetupVersions_Model_Resource_Setup</class>
                    <version>0.0.2</version>
                </setup>
            </[your_setup_name_2]>
        </resources>
    </global>

Each of your setup scripts has its own entry in the database table `core_resource` and its own version number. This is accomplished by modifing the line in the methods `applyDataUpdates()` and `applyUpdates()`. The version number gets read from another part of the XML, that's all (search for the lines containing `$configVer =`).

If you want you can go even further and tell `applyDataUpdates()` to get the config version from another XML node (like `data_version` instead of `version`) for using different version numbers for data and structure changes. 

Requirements
------------
- PHP >= 5.2.0
- Mage_Core

Compatibility
-------------
- Magento 1.7 CE (only tested with this version, may work with others)

Installation Instructions
-------------------------
1. Install the extension using modman or copy all the files into your document root.

Uninstallation
--------------
1. Remove the extension like all other extensions you install using modman.

Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/mzeis/Emzee_MultipleSetupVersions/issues).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
Matthias Zeis
[http://www.matthias-zeis.com](http://www.matthias-zeis.com)  
[@mzeis](https://twitter.com/mzeis)

Licence
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2013 Matthias Zeis
