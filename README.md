# sc2\_season\_mgr

## Development

### Long-Lived Branches
1. ``Master``: current production code (stable)
2. ``Development``: non-production code (can be unstable)

### Process
1. Do all your development in your own branch created from the ``Development`` branch. (eg. ``lopezjo/fix-issue-1``)
2. Create a Pull Request from your branch into the ``Development`` branch.
3. When Pull Request gets merged into the ``Development`` branch then your branch can be deleted.
4. The ``Development`` branch gets merged into the ``Master`` branch when accepted for production use via a new Pull Request.

## Setting up the project

### Epiphany PHP Framework
Create a folder named ``./src`` at the same level as ``sc2_season_mgr``.

The contents of ``./src`` are found at: 

[https://github.com/jmathai/epiphany/tree/master/src](https://github.com/jmathai/epiphany/tree/master/src)

If you chose a different folder for the Epiphany code, then update:

[https://github.com/lopezjo/sc2_season_mgr/blob/master/index.php](https://github.com/lopezjo/sc2_season_mgr/blob/master/index.php)

Line containing:

``Epi::setPath('base', '../src');``

### Database

A MySQL database is used by this project. To recreate the database use the following SQL script:

[https://github.com/lopezjo/sc2_season_mgr/blob/master/schema/sc2_seasons.sql](https://github.com/lopezjo/sc2_season_mgr/blob/master/schema/sc2_seasons.sql)

### Variables

Update the variables defined in:

[https://github.com/lopezjo/sc2_season_mgr/blob/master/settings.php](https://github.com/lopezjo/sc2_season_mgr/blob/master/settings.php)

Variables include the database connection info and a whitelist of approved client addresses.




