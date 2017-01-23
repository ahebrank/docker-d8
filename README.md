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

## Tweaks

### Patches

Add a section to composer.json that lists patches per module. For example:

```
"patches": {
    "drupal/better_formats": {
        "Paragraphs integration": "https://www.drupal.org/files/issues/better_formats_paragraphs-2754029-15.patch"
    },
    "drupal/cshs": {
        "Show stuff by default": "https://www.drupal.org/files/issues/cshs-no_default_filter-2781511-4.patch",
        "Allow default options": "https://www.drupal.org/files/issues/fix-default-val-views-error-2797349-1.patch",
        "Accessible labels": "patches/cshs-accessibility.patch"
    },
    "drupal/paragraphs": {
        "IEF save problem": "patches/saving_problem_in-2804377-x.patch"
    },
    "drupal/feeds": {
        "Dynamic sources": "https://www.drupal.org/files/issues/feeds-dynamic_mapping_sources-2443471-4.patch"
    },
    "drupal/devel": {
        "Shorten max depth": "patches/kint_max_levels.patch"
    },
    "drupal/field_group": {
        "Don't force on the front end": "https://www.drupal.org/files/issues/field_group-check-for-empty-render-key-2825389-4.patch"
    },
    "drupal/cdn": {
        "No CDN when logged in": "patches/cdn_not_when_logged_in.patch"
    },
    "drupal/eck": {
        "Fix schema": "https://www.drupal.org/files/issues/changes_to-2825407-6.patch"
    }
}
```

### Including dev contrib modules in the repo

Composer installs dev modules (from git repos) with the `.git` directory included.  When the root repository sees these `.git` directories, it stores the module as a gitlink (basically an incomplete submodule). This is usually OK but if you're including these modules in the deployment artifact without any sort of build (i.e., installing them via `composer`), the modules have no real content so can't be part of the artifact. The solution is a composer post-install script to delete the module `.git` directories. Add to your composer.json `autoload` section:

```
"autoload": {
    "classmap": [
        "utils/composer/RemoveGit.php"
    ]
},
```

and to the `scripts` section:

```
"scripts": {
    "post-install-cmd": [
        "DrupalNewCity\\composer\\RemoveGit::removeModuleGit"
    ],
    "post-update-cmd": [
        "DrupalNewCity\\composer\\RemoveGit::removeModuleGit"
    ]
},
```
