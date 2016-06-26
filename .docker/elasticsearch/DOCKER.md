# Working with docker / docker-machine

## Goals

  1. Use docker and the existing virtual machine stack to progressively enhance the infrastructural stack to implement new features.
  2. Use elasticsearch for document / content indexing.

## Setup

    docker-machine create --driver generic --generic-ip-address=10.11.12.13 --generic-ssh-key=./.vagrant/machines/default/virtualbox/private_key --generic-ssh-user=vagrant --generic-ssh-port=22 vantomas
    docker-machine env vantomas
    eval $(docker-machine env vantomas)

Note: when using `generic` driver, `docker-machine stop [machine_name]` does not work:

    docker-machine stop vantomas
    > Stopping "vantomas"...
    > generic driver does not support stop

## Container

### Elasticsearch

    docker run -d elasticsearch:2.2

Investigate and install GUI plugin `kopf`:

    docker ps
    > CONTAINER ID        IMAGE               COMMAND                  CREATED             STATUS              PORTS                NAMES
    > c60f340ea915        elasticsearch:2.2   "/docker-entrypoint.s"   11 seconds ago      Up 10 seconds       9200/tcp, 9300/tcp   cocky_knuth
    docker exec -ti cocky_knuth bash
    > root@c60f340ea915:/usr/share/elasticsearch#
    cd bin
    ./plugin install lmenezes/elasticsearch-kopf/2.0
    > -> Installing lmenezes/elasticsearch-kopf/2.0...
    > Trying https://download.elastic.co/lmenezes/elasticsearch-kopf/elasticsearch-kopf-2.0.zip ...
    > Trying https://search.maven.org/remotecontent?filepath=lmenezes/elasticsearch-kopf/2.0/elasticsearch-kopf-2.0.zip ...
    > Trying https://oss.sonatype.org/service/local/repositories/releases/content/lmenezes/elasticsearch-kopf/2.0/elasticsearch-kopf-2.0.zip ...
    > Trying https://github.com/lmenezes/elasticsearch-kopf/archive/2.0.zip ...
    > Downloading .........................................................................................................................................................................................................................................................................................................................................................DONE
    > Verifying https://github.com/lmenezes/elasticsearch-kopf/archive/2.0.zip checksums if available ...
    > NOTE: Unable to verify checksum for downloaded plugin (unable to find .sha1 or .md5 file to verify)
    > Installed kopf into /usr/share/elasticsearch/plugins/kopf
    exit
    docker commit cocky_knuth dreadlabs/vantomas-elasticsearch:v0.1
    docker images
    > REPOSITORY                         TAG                 IMAGE ID            CREATED             VIRTUAL SIZE
    > dreadlabs/vantomas-elasticsearch   v0.1                sha256:93cdc        29 seconds ago      353.1 MB
    > elasticsearch                      2.2                 sha256:51340        6 days ago          347.1 MB
    docker stop cocky_knuth
    docker run -d -p 9200:9200 dreadlabs/vantomas-elasticsearch:v0.1

Now open `http://10.11.12.13:9200/_plugin/kopf` in your browser.

Run extended elasticsearch container and persist the index data:

    docker run -d -v "$PWD/esdata":/usr/share/elasticsearch/data -p 9200:9200 dreadlabs/vantomas-elasticsearch:v0.1

Alternative to `docker commit` by using the `Dockerfile`:

    docker build -t dreadlabs/vantomas-elasticsearch:v0.1 .

Next steps:

  1. create index "raw_process_datamap"
  2. implement TYPO3.CMS DataHandler hook for `$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']`
     - hook = fully qualified class name
     - class must implement method `processDatamap_beforeStart`, expected one argument (`DataHandler` instance)
     - hook may handle data on `processDatamap_afterAllOperations` method (remap relations unset) args: `DataHandler` instance
       - other options: `processDatamap_afterDatabaseOperations` (relations?) args: `$hookArgs['status'], $table, $rawId, $hookArgs['fieldArray'], $this`
       - `processDatamap_postProcessFieldArray` args: `$status, $table, $id, $fieldArray, $this`
     - interesting / necessary `DataHandler` properties
       - `$substNEWwithIDs`: array, `NEW_[int+] => uid` mapping
       - `$newRelatedIDs`: array, related ids mapping
       - `$datamap`: incoming data array
       -