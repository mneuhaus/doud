# Doud

This little repository is a dead-simple way to create quick prototypes/clickdummys
using the awesome typo3/fluid template engine. It uses a tiny bootstrap that takes
the url path and tries to load a matching Template and a Fixture.
So, if you use a url "[path-to-doud]/foo/bar" it will try to load the Template
file "Templates/Foo/Bar.html" and the Fixture "Fixtures/Foo/Bar.yaml".
Fixtures are optional and there is a Global.yaml that will be assigned to every
Template.

# Installation

download/clone repository, [install composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) if not already installed and then run the following command inside the main directory:

```
composer install
```
