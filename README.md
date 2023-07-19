<h1 align="center">
  <a href="https://yourls.org">
    <img src="images/yourls-logo.svg" width=66% alt="YOURLS">
  </a>
</h1>

> Your Own URL Shortener

![CI](https://github.com/YOURLS/YOURLS/workflows/CI/badge.svg) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/YOURLS/YOURLS/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/YOURLS/YOURLS/?branch=master) ![PHP Version Support](https://img.shields.io/packagist/php-v/yourls/yourls) [![Packagist](https://img.shields.io/packagist/v/yourls/yourls.svg)](https://packagist.org/packages/yourls/yourls) [![OpenCollective](https://opencollective.com/yourls/backers/badge.svg)](https://opencollective.com/yourls#contributors) 
[![OpenCollective](https://opencollective.com/yourls/sponsors/badge.svg)](#sponsors)

**YOURLS** is a set of PHP scripts that will allow you to run <strong>Y</strong>our <strong>O</strong>wn <strong>URL</strong> <strong>S</strong>hortener, on **your** server. You'll have full control over your data, detailed stats, analytics, plugins, and more. It's free and open-source.

## Quick Start
Both the master and docker branches are missing the following files
* nginx-selfsigned.crt
* nginx-selfsigned.key
* yourls.conf

The docker branch is also missing
* .env.yourls
* .env.mysql

To run Kubernetes version locally
1. Install minikube, kubectl and Docker Desktop
2. Clone the repo, download the missing files and open the master branch
3. Change usernames and passwords in mysql.yaml, yourls.yaml and config.php to desired values
4. cd to root of repo the following commands
    $ kubectl create configmap yourls --from-file=config.php --from-file=index.php
    $ kubectl create configmap nginx --from-file=nginx-selfsigned.crt --from-file=nginx-selfsigned.key --from-file=yourls.conf
    $ kubectl apply -f .
5. Open one terminal and run
    $ sudo kubectl port-forward service/nginx 443:443
6. Open another terminal and run
    $ sudo kubectl port-forward service/yourls 80:80
7. Leave them both running and go to http://localhost/admin/index.php to “install” yourls

To run Docker Compose version locally
1. Install Docker Desktop
2. Clone repo, download the missing files and open the docker branch
3. Change usernames and passwords in .env.yourls, .env.mysql and config.php to desired values
4. cd to root of repo and run
    $ docker-compose up
5. Go to http://localhost/admin/index.php to “install” yourls

## License
Free software. Do whatever the hell you want with it.  
YOURLS is released under the [MIT license](LICENSE).
