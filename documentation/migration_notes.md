# Migration Notes

## Upgrade to PHP 7.4

The primary changes encountered when updating to PHP 7.4 where the following:
- True deprecation of the mysql module in favor of the mysqli module.
- An upgrade of the Apache version packaged in the updated php Docker image.

### Mysql module deprecation

The mysql module was deprecated as of PHP 5.5.0, neccesitating its upgrade. Furthermore, the official PHP Docker image does not support installing this plug with a sufficiently high PHP version specified. Luckily, there is a near drop-in replacement in mysqli. Most of the method signatures are similar and replacements are easy to perform, especially in an IDE with some form of intellisense. Once these methods were updated, no other PHP issues were discovered.

*Important*
The upgrade to mysqli does not come with any inherent security improvements. To take advantage of it, a manual refactor is required in order to prevent sql injection using query binds.

### Apache version bump

The Apache version bundled with the offical PHP 5.4 Docker image was 2.4.10, while the PHP 7.4 image contains 2.4.52. This version bump came with some minor adjustments to the config files that needed to be accounted for. Ultimately, the legacy application Apache setup is a fairly minimal deviation from the default setup.
