<?php

/**
 * @file
 * Contains \DrupalNewCity\composer\RemoveGit.
 */

namespace DrupalNewCity\composer;

use Composer\Script\Event;
use Composer\Semver\Comparator;
use Symfony\Component\Filesystem\Filesystem;

class RemoveGit {

  protected static function getDrupalRoot($project_root) {
    return $project_root . '/web';
  }

  // http://stackoverflow.com/questions/3349753/delete-directory-with-files-in-it
  protected static function delTree($dir) {
    $files = array_diff(scandir($dir), array('.', '..'));

    foreach ($files as $file) {
      (is_dir("$dir/$file")) ? static::delTree("$dir/$file") : unlink("$dir/$file");
    }

    return rmdir($dir);
  }

  protected static function endsWith($haystack, $needle) {
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
  }

  /**
   * Run through all the modules and remove .git folders
   */
  public static function removeModuleGit(Event $event) {
    $fs = new Filesystem();
    $root = static::getDrupalRoot(getcwd());

    $dirs = [
      'modules',
    ];

    foreach ($dirs as $dir) {
      $dir = $root . '/'. $dir;
      $it = new \RecursiveDirectoryIterator($dir);
      foreach (new \RecursiveIteratorIterator($it) as $file) {
        if (is_dir($file) && static::endsWith($file, '.git/.')) {
          $file = dirname($file);
          echo "Removing " . $file . "\n";
          static::delTree($file);
        }
      }
    }
  }

  
}
