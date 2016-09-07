# symfony-crud-elasticsearch
A simple CRUD operation on a Symfony Entity with Elasticsearch index and retrive



## Setup project settings
```
composer install
```
mysql username: homestead
mysql username: secret

```
php vendor/bin/homestead make
```


* edit "./Homestead.yaml" with personal paths, database name and options
* Add on local file Hosts:
```
192.168.10.10 	symfony-crud-elasticsearch.app
```


```
vagrant up

vagrant ssh

cd ~/symfony-crud-elasticsearch

php bin/console doctrine:schema:update --force
```


## Install Java and Elasticsearch into Vagrant VM
```
sudo apt-get install default-jre

wget -qO - https://packages.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -

echo "deb http://packages.elastic.co/elasticsearch/1.7/debian stable main" | sudo tee -a /etc/apt/sources.list.d/elasticsearch-1.7.list

sudo apt-get update && sudo apt-get install elasticsearch

sudo /bin/systemctl daemon-reload

sudo /bin/systemctl enable elasticsearch.service
```


## Populate Elasticsearch
```
cd ~/symfony-crud-elasticsearch

php bin/console fos:elastica:populate
```