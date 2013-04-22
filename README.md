DlcUseCase
===================
A simple module for Zend Framework 2 based applications for getting an overview of your use cases.

This module is currently under heavy development.

## Introduction

Comming soon...

Requirements
------------
* [DlcBase](https://github.com/dlabas/DlcBase)
* [DlcCategory](https://github.com/dlabas/DlcCategory)
* [DlcDiagramm](https://github.com/dlabas/DlcDiagramm)
* [DlcDoctrine](https://github.com/dlabas/DlcDoctrine)

Installation
------------

## Main Setup

#### By cloning project

1. Install the [DlcBase](https://github.com/dlabas/DlcBase), [DlcCategory](https://github.com/dlabas/DlcCategory), [DlcDiagramm](https://github.com/dlabas/DlcDiagramm) and [DlcDoctrine](https://github.com/dlabas/DlcDoctrine) ZF2 modules
   by cloning it into `./vendor/`.
2. Clone this project into your `./vendor/` directory.

#### With composer

1. Add this project and [DlcUseCase](https://github.com/dlabas/DlcUseCase) in your composer.json:

    ```json
    "require": {
        "dl-commons/dlc-use-case": "dev-master"
    }
    ```

2. Now tell composer to download DlcUseCase by running the command:

    ```bash
    $ php composer.phar update

#### Post installation

1. Enabling it in your `application.config.php`file.

    ```php
    <?php
    return array(
        'modules' => array(
            // ...
            'DlcBase',
            'DlcDoctrine',
            'DlcDiagramm',
            'DlcCategory',
            'DlcUseCase',
        ),
        // ...
    );

