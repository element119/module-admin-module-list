<div align="center">

<!-- Module Image Here -->

</div>

<h1 align="center">element119 | Admin Module List</h1>

## 📝 Features
✔️ View all modules installed in the Magento application

✔️ Easily identify which modules are enabled and disabled

✔️ See which modules are installed via Composer and which are installed locally

✔️ Provides configuration options to handle non-standard Magento module installation locations

✔️ Customise the grid view with filters, sorting, pagination, and column visibility

✔️ Export grid data in CSV, XML, or XLSX formats

✔️ Built in accordance with Magento best practises

✔️ Dedicated module configuration section secured with custom admin user controls

✔️ Seamless integration with Magento

✔️ Built with developers and extensibility in mind to make customisations as easy as possible

✔️ Installable via Composer

✔️ Theme agnostic

<br/>

## 🔌 Installation
Run the following command to *install* this module:
```bash
composer require element119/module-admin-module-list
php bin/magento setup:upgrade
```

<br/>

## ⏫ Updating
Run the following command to *update* this module:
```bash
composer update element119/module-admin-module-list
php bin/magento setup:upgrade
```

<br/>

## ❌ Uninstallation
Run the following command to *uninstall* this module:
```bash
composer remove element119/module-admin-module-list
php bin/magento setup:upgrade
```

<br/>

## 📚 User Guide
Configuration for this module can be found in the Magento admin under `Stores -> Settings -> Configuration -> Advanced
-> System -> Modules`.

<br>

### Module List
The list of modules, their status, and how they are installed in the application can be seen in the admin by navigating
to `System -> Modules -> Module Information`.

<br>

### Directory Configuration
The names of the directories in which modules can be found can be configured in case something other than the standard
`vendor/` and `app/code/` directories are used.

<br>

## 📸 Screenshots & GIFs
### Admin Configuration
![admin-config](https://github.com/element119/module-admin-module-list/assets/40261741/284c9b4a-1280-4d59-b936-b804674d4e35)

<br>

### Module List
![admin-grid](https://github.com/element119/module-admin-module-list/assets/40261741/c697cb11-5fe5-41e6-b91b-8f60f5ec45c1)
