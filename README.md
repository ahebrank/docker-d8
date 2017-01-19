# D8 Drupal boilerplate

Skeleton for a D8-in-docker setup. A major goal is to try to keep everything except custom modules and themes inside the container (and out of the repo).

To this end, `composer` is used to install dependencies, but it is run inside the PHP container. The `modules` and `themes` directories are mapped out to the container but should only be used for `custom` stuff.

There are some utility functions for installing and updating core/modules.

## Quickstart

- clone/copy this to a new project: `composer create-project ahebrank/docker-d8 YOUR-PROJECT-DIR --stability dev`
- run `docker-compose up --build` to spin up your container network
- browse to `http://localhost:8000` to set up your site.  The database and application files are kept in persistent storage containers

## Management

A collection of `d` utilities run things inside the container transparently.

- To install modules: e.g., `./dcomposer require drupal/paragraphs` (accepts composer versioning info as well)
- Drupal console: `./ddrupal`
- Drush: `./ddrush`
- Shell into Drupal container: `./d`
