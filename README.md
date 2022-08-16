# Providence Bundle Demo

A Symfony 6 application that demonstrates how to use the Survos Providence Bundle.

It uses Umbrella 6 for the interface.

The goal of this app is a multi-linguagl browser of the available XML profiles for Collective Access (CA) Providence, and of the data structures.

Profile transations come from

    bin/console providence:create-profile-translations

which creates yaml files in /translations




## Development Setup

Although the final app can be deployed on Heroku without depenendies, during development the original source code files from CA 

This app, through the bundle, reads data from CA (https://github.com/collectiveaccess/providence), which needs to be installed locally. (@todo: read directly from github). The paths are configured in the survos_providence.yaml file.  By default, the related repos in the same directory as this repo locally.

```bash
git clone git@github.com:collectiveaccess/providence.git
git clone git@github.com:survos/providence-bundle-demo.git
```

The bundle needs ca_models.json, which comes from ca-fix, which is generated from ca-install, which as of Aug 15, 2022, didn't load, even using PHP 7.4. 

The XML files come from the bundle (which have been copied from ../providence/install/profiles/xml/ and dumped from demo.collectiveaccess).  


## Translation

There are 3 sets of translation files:

* /translations/messages+icu.en.yaml (this app)
* /translations/<profileName>+icu.en.yaml (each profile)
* /translations/ca+icu.en.yaml (from CA)

The profile translations are created by extracting the labels from each XML file.

bin/console providence:extract-profile-translations

This app does NOT use dynamic translations for the profiles, since the profiles in this app are fixed.


More details can be found in the bundle documentation.


