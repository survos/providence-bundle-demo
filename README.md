# Providence Bundle Demo

A Symfony 6 application that demonstrates how to use the Survos Providence Bundle.

It uses Umbrella 6 for the interface.

The goal of this app is a multi-linguagl browser of the available XML profiles for Collective Access (CA) Providence, and of the data structures.



## Development Setup

Although the final app can be deployed on Heroku without depenendies, during development the original source code files from CA 

This app, through the bundle, reads data from CA (https://github.com/collectiveaccess/providence), which needs to be installed locally. (@todo: read directly from github). The paths are configured in the survos_providence.yaml file.  By default, the related repos in the same directory as this repo locally.

```bash
git clone git@github.com:collectiveaccess/providence.git
git clone git@github.com:survos/providence-bundle-demo.git
```



## Translation

* 

More details can be found in the bundle documentation.


