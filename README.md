# sc2\_season\_mgr
## Development
### Long-Lived Branches
1. ``master``: current production code (stable)
2. ``mevelopment``: non-production code (can be unstable)

### Process
1. Do all your development in your own branch created from the ``development`` branch. (eg. ``lopezjo/fix-issue-1``)
2. Create a Pull Request from your branch into the ``development`` branch.
3. When Pull Request gets merged into the ``development`` branch then your branch can be deleted.
4. The ``development`` branch gets merged into the ``master`` branch when accepted for production use via a new Pull Request.

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

The script creates a BLANK database with the necessary schema.

### Variables
Update the two files below to match your deployment configuration:

[https://github.com/lopezjo/sc2_season_mgr/blob/master/settings.php](https://github.com/lopezjo/sc2_season_mgr/blob/master/settings.php)
[https://github.com/lopezjo/sc2_season_mgr/blob/master/.htaccess](https://github.com/lopezjo/sc2_season_mgr/blob/master/.htaccess)

Variables include the database connection info and a whitelist of approved client addresses.

## Usage
### Player APIs
#### Adding a player
<p>
HTTP VERB: ``POST`` <br />
URI: ``http://[base_uri]/players``

Sample POST data:

``{ "name": "Freeedom" }``
</p>

#### Getting players
<p>
HTTP VERB: ``GET`` <br />
URI: ``http://[base_uri]/players``

Sample data returned:

<code>[<br />
    {
        "id": 5,
        "href": "http://localhost/sc2_season_mgr/players/5",
        "name": "Freeedom"
    },<br />
    {
        "id": 6,
        "href": "http://localhost/sc2_season_mgr/players/6",
        "name": "HurtnTime"
    }<br />
]</code>
</p>

#### Editing a player
#### Deleting player



