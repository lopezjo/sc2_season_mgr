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
URI: ``POST http://[base_uri]/players``

Sample POST data:

<pre><code>
{ "name": "Freeedom" }
</code></pre>

#### Getting players
URI: ``GET http://[base_uri]/players``

Sample data returned:

<pre><code>[
    {
        "id": 5,
        "href": "http://localhost/sc2_season_mgr/players/5",
        "name": "Freeedom"
    },
    {
        "id": 6,
        "href": "http://localhost/sc2_season_mgr/players/6",
        "name": "HurtnTime"
    }
]
</code></pre>

#### Getting a player
URI: ``GET http://[base_uri]/players/[player_id]``

Sample data returned:

<pre><code>{
        "id": 5,
        "href": "http://localhost/sc2_season_mgr/players/5",
        "name": "Freeedom"
    }
</code></pre>

#### Editing a player
URI: ``PUT http://[base_uri]/players/[player_id]``

Sample PUT data:

<pre><code>
{ "name": "Freeedom" }
</code></pre>

#### Deleting a player
URI: ``DELETE http://[base_uri]/players/[player_id]``

### Map APIs
#### Adding a map
URI: ``POST http://[base_uri]/maps``

Sample POST data:

<pre><code>
{ "name": "Overgrowth" }
</code></pre>

#### Getting maps
URI: ``GET http://[base_uri]/maps``

Sample data returned:

<pre><code>[
    {
        "id": 7,
        "href": "http://localhost/sc2_season_mgr/maps/7",
        "name": "Overgrowth"
    },
    {
        "id": 8,
        "href": "http://localhost/sc2_season_mgr/maps/8",
        "name": "Nimbus"
    }
]
</code></pre>

#### Getting a map
URI: ``GET http://[base_uri]/maps/[map_id]``

Sample data returned:

<pre><code>{
        "id": 7,
        "href": "http://localhost/sc2_season_mgr/maps/7",
        "name": "Overgrowth"
    }
</code></pre>

#### Editing a map
URI: ``PUT http://[base_uri]/maps/[map_id]``

Sample PUT data:

<pre><code>
{ "name": "Overgrowth" }
</code></pre>

#### Deleting a map
URI: ``DELETE http://[base_uri]/maps/[map_id]``

### Season APIs
#### Adding a season
URI: ``POST http://[base_uri]/seasons``

Sample POST data:

<pre><code>
{"date":null, "winner": {"id": null}, "maps": [{"id": 7}, {"id": 8}], "name": "Test Season 1"}
</code></pre>

#### Getting seasons
URI: ``GET http://[base_uri]/seasons``

Sample data returned:

<pre><code>[
    {
        "id": 3,
        "href": "http://localhost/sc2_season_mgr/seasons/3",
        "name": "Test Season 1",
        "date": null,
        "winner": {
            "id": null,
            "name": null,
            "href": null
        },
        "maps": [
            {
                "id": 7,
                "name": "Overgrowth",
                "href": "http://localhost/sc2_season_mgr/maps/7"
            },
            {
                "id": 8,
                "name": "Nimbus",
                "href": "http://localhost/sc2_season_mgr/maps/8"
            }
        ],
        "divisions_href": "http://localhost/sc2_season_mgr/seasons/3/divisions"
    },
    {
        "id": 4,
        "href": "http://localhost/sc2_season_mgr/seasons/4",
        "name": "Test Season 2",
        "date": null,
        "winner": {
            "id": null,
            "name": null,
            "href": null
        },
        "maps": [
            {
                "id": 7,
                "name": "Overgrowth",
                "href": "http://localhost/sc2_season_mgr/maps/7"
            },
            {
                "id": 8,
                "name": "Nimbus",
                "href": "http://localhost/sc2_season_mgr/maps/8"
            }
        ],
        "divisions_href": "http://localhost/sc2_season_mgr/seasons/4/divisions"
    }
]
</code></pre>

#### Getting a season
URI: ``GET http://[base_uri]/seasons/[season_id]``

Sample data returned:

<pre><code>{
        "id": 3,
        "href": "http://localhost/sc2_season_mgr/seasons/3",
        "name": "Test Season 1",
        "date": null,
        "winner": {
            "id": null,
            "name": null,
            "href": null
        },
        "maps": [
            {
                "id": 7,
                "name": "Overgrowth",
                "href": "http://localhost/sc2_season_mgr/maps/7"
            },
            {
                "id": 8,
                "name": "Nimbus",
                "href": "http://localhost/sc2_season_mgr/maps/8"
            }
        ],
        "divisions_href": "http://localhost/sc2_season_mgr/seasons/3/divisions"
    }
</code></pre>

#### Editing a season
URI: ``PUT http://[base_uri]/seasons/[season_id]``

Sample PUT data:

<pre><code>
{"date":null, "winner": {"id": null}, "maps": [{"id": 7}, {"id": 8}], "name": "Test Season 1"}
</code></pre>

#### Deleting a season
URI: ``DELETE http://[base_uri]/seasons/[season_id]``

### Division APIs
A season is broken up into one or more divisions. When players are added to a division, matches 
are automatically generated for the player using a randomly selected map from the list of maps
the season is using.

#### Adding a division
URI: ``POST http://[base_uri]/seasons/[season_id]/divisions``

Sample POST data:

<pre><code>
{"name": "Diamond", "season": {"id": 3}, "players": [{"id": 5}, {"id": 6}]}
</code></pre>

#### Getting divisions
URI: ``GET http://[base_uri]/seasons/[season_id]/divisions``

Sample data returned:

<pre><code>[
    {
        "id": 18,
        "href": "http://localhost/sc2_season_mgr/seasons/3/divisions/18",
        "name": "Diamond",
        "season": {
            "id": 3,
            "name": "Test Season 1",
            "href": "http://localhost/sc2_season_mgr/seasons/3"
        },
        "players": [
            {
                "id": 5,
                "name": "Freeedom",
                "href": "http://localhost/sc2_season_mgr/players/5"
            },
            {
                "id": 6,
                "name": "HurtnTime",
                "href": "http://localhost/sc2_season_mgr/players/6"
            }
        ],
        "matches_href": "http://localhost/sc2_season_mgr/seasons/3/divisions/18/matches"
    },
    {
        "id": 20,
        "href": "http://localhost/sc2_season_mgr/seasons/3/divisions/20",
        "name": "Master",
        "season": {
            "id": 3,
            "name": "Test Season 1",
            "href": "http://localhost/sc2_season_mgr/seasons/3"
        },
        "players": [
            {
                "id": 5,
                "name": "Freeedom",
                "href": "http://localhost/sc2_season_mgr/players/5"
            },
            {
                "id": 6,
                "name": "HurtnTime",
                "href": "http://localhost/sc2_season_mgr/players/6"
            }
        ],
        "matches_href": "http://localhost/sc2_season_mgr/seasons/3/divisions/20/matches"
    }
]
</code></pre>

#### Getting a division
URI: ``GET http://[base_uri]/seasons/[season_id]/divisions/[division_id]``

Sample data returned:

<pre><code>{
        "id": 18,
        "href": "http://localhost/sc2_season_mgr/seasons/3/divisions/18",
        "name": "Diamond",
        "season": {
            "id": 3,
            "name": "Test Season 1",
            "href": "http://localhost/sc2_season_mgr/seasons/3"
        },
        "players": [
            {
                "id": 5,
                "name": "Freeedom",
                "href": "http://localhost/sc2_season_mgr/players/5"
            },
            {
                "id": 6,
                "name": "HurtnTime",
                "href": "http://localhost/sc2_season_mgr/players/6"
            }
        ],
        "matches_href": "http://localhost/sc2_season_mgr/seasons/3/divisions/18/matches"
    }
]
</code></pre>

#### Editing a division
URI: ``PUT http://[base_uri]/seasons/[season_id]/divisions/[division_id]``

Sample PUT data:

<pre><code>
{"name": "Diamond", "season": {"id": 3}, "players": [{"id": 5}, {"id": 6}]}
</code></pre>

#### Deleting a division
URI: ``DELETE http://[base_uri]/seasons/[season_id]/divisions/[division_id]``

### Matches APIs
Matches are normally created and deleted when the players of a division are modified.

#### Adding a match
Should not have to manually add a match.

URI: ``POST http://[base_uri]/seasons/[season_id]/divisions/[division_id]/matches``

Sample POST data:

<pre><code>
{"division": {"id": 20}, "player1": {"id": 5}, "player2": {"id": 6}, "winner": {"id": null}, "map": {"id": 7}}
</code></pre>

#### Getting matches
URI: ``GET http://[base_uri]/seasons/[season_id]/divisions/[division_id]/matches``

Sample data returned:

<pre><code>[
    {
        "id": 35,
        "href": "http://localhost/sc2_season_mgr/seasons/3/divisions/20/matches/35",
        "division": {
            "id": 20,
            "name": "Master",
            "href": "http://localhost/sc2_season_mgr/seasons/3/divisions/20"
        },
        "player1": {
            "id": 5,
            "name": "Freeedom",
            "href": "http://localhost/sc2_season_mgr/players/5"
        },
        "player2": {
            "id": 6,
            "name": "HurtnTime",
            "href": "http://localhost/sc2_season_mgr/players/6"
        },
        "winner": {
            "id": null,
            "name": null,
            "href": null
        },
        "map": {
            "id": 7,
            "name": "Overgrowth",
            "href": "http://localhost/sc2_season_mgr/maps/7"
        }
    }
]
</code></pre>

#### Getting a match
URI: ``GET http://[base_uri]/seasons/[season_id]/divisions/[division_id]/matches/[match_id]``

Sample data returned:

<pre><code>{
    "id": 35,
    "href": "http://localhost/sc2_season_mgr/seasons/3/divisions/20/matches/35",
    "division": {
        "id": 20,
        "name": "Master",
        "href": "http://localhost/sc2_season_mgr/seasons/3/divisions/20"
    },
    "player1": {
        "id": 5,
        "name": "Freeedom",
        "href": "http://localhost/sc2_season_mgr/players/5"
    },
    "player2": {
        "id": 6,
        "name": "HurtnTime",
        "href": "http://localhost/sc2_season_mgr/players/6"
    },
    "winner": {
        "id": null,
        "name": null,
        "href": null
    },
    "map": {
        "id": 7,
        "name": "Overgrowth",
        "href": "http://localhost/sc2_season_mgr/maps/7"
    }
}
</code></pre>

#### Editing a match
URI: ``PUT http://[base_uri]/seasons/[season_id]/divisions/[division_id]/matches/[match_id]``

Sample PUT data:

<pre><code>
{"division": {"id": 20}, "player1": {"id": 5}, "player2": {"id": 6}, "winner": {"id": 6}, "map": {"id": 7}}
</code></pre>

#### Deleting a season
Should not have to manually delete a match.

URI: ``http://[base_uri]/seasons/[season_id]/divisions/[division_id]/matches/[match_id]``

### Rounds APIs
The division is scheduled via round-robin where all players play against each other.
A round contains a set of matches between all players.

#### Getting rounds
URI: ``GET http://[base_uri]/seasons/[season_id]/divisions/[division_id]/rounds``

Sample data returned:

<pre><code>[
    {
        "id": 1,
        "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/rounds/1",
        "matches": [
            {
                "id": 14,
                "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/matches/14",
                "division": {
                    "id": 3,
                    "name": "Platinum",
                    "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3"
                },
                "player1": {
                    "id": 1,
                    "name": "HurtnTime",
                    "href": "http://localhost/sc2_season_mgr/players/1"
                },
                "player2": {
                    "id": 9,
                    "name": "SEF",
                    "href": "http://localhost/sc2_season_mgr/players/9"
                },
                "winner": {
                    "id": null,
                    "name": null,
                    "href": null
                },
                "map": {
                    "id": 1,
                    "name": "Overgrowth",
                    "href": "http://localhost/sc2_season_mgr/maps/1"
                }
            },
            {
                "id": 13,
                "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/matches/13",
                "division": {
                    "id": 3,
                    "name": "Platinum",
                    "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3"
                },
                "player1": {
                    "id": 4,
                    "name": "Zelevin",
                    "href": "http://localhost/sc2_season_mgr/players/4"
                },
                "player2": {
                    "id": 5,
                    "name": "Sheikh",
                    "href": "http://localhost/sc2_season_mgr/players/5"
                },
                "winner": {
                    "id": null,
                    "name": null,
                    "href": null
                },
                "map": {
                    "id": 5,
                    "name": "King Sejong",
                    "href": "http://localhost/sc2_season_mgr/maps/5"
                }
            }
        ]
    },
    {
        "id": 2,
        "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/rounds/2",
        "matches": [
            {
                "id": 12,
                "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/matches/12",
                "division": {
                    "id": 3,
                    "name": "Platinum",
                    "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3"
                },
                "player1": {
                    "id": 1,
                    "name": "HurtnTime",
                    "href": "http://localhost/sc2_season_mgr/players/1"
                },
                "player2": {
                    "id": 5,
                    "name": "Sheikh",
                    "href": "http://localhost/sc2_season_mgr/players/5"
                },
                "winner": {
                    "id": null,
                    "name": null,
                    "href": null
                },
                "map": {
                    "id": 3,
                    "name": "Foxtrot Labs",
                    "href": "http://localhost/sc2_season_mgr/maps/3"
                }
            },
            {
                "id": 15,
                "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/matches/15",
                "division": {
                    "id": 3,
                    "name": "Platinum",
                    "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3"
                },
                "player1": {
                    "id": 4,
                    "name": "Zelevin",
                    "href": "http://localhost/sc2_season_mgr/players/4"
                },
                "player2": {
                    "id": 9,
                    "name": "SEF",
                    "href": "http://localhost/sc2_season_mgr/players/9"
                },
                "winner": {
                    "id": null,
                    "name": null,
                    "href": null
                },
                "map": {
                    "id": 1,
                    "name": "Overgrowth",
                    "href": "http://localhost/sc2_season_mgr/maps/1"
                }
            }
        ]
    },
    {
        "id": 3,
        "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/rounds/3",
        "matches": [
            {
                "id": 11,
                "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/matches/11",
                "division": {
                    "id": 3,
                    "name": "Platinum",
                    "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3"
                },
                "player1": {
                    "id": 1,
                    "name": "HurtnTime",
                    "href": "http://localhost/sc2_season_mgr/players/1"
                },
                "player2": {
                    "id": 4,
                    "name": "Zelevin",
                    "href": "http://localhost/sc2_season_mgr/players/4"
                },
                "winner": {
                    "id": null,
                    "name": null,
                    "href": null
                },
                "map": {
                    "id": 5,
                    "name": "King Sejong",
                    "href": "http://localhost/sc2_season_mgr/maps/5"
                }
            },
            {
                "id": 16,
                "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/matches/16",
                "division": {
                    "id": 3,
                    "name": "Platinum",
                    "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3"
                },
                "player1": {
                    "id": 5,
                    "name": "Sheikh",
                    "href": "http://localhost/sc2_season_mgr/players/5"
                },
                "player2": {
                    "id": 9,
                    "name": "SEF",
                    "href": "http://localhost/sc2_season_mgr/players/9"
                },
                "winner": {
                    "id": null,
                    "name": null,
                    "href": null
                },
                "map": {
                    "id": 5,
                    "name": "King Sejong",
                    "href": "http://localhost/sc2_season_mgr/maps/5"
                }
            }
        ]
    }
]
</code></pre>

#### Getting a round
URI: ``GET http://[base_uri]/seasons/[season_id]/divisions/[division_id]/rounds/[round_id]``

Sample data returned:

<pre><code>{
    "id": 3,
    "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/rounds/3",
    "matches": [
        {
            "id": 11,
            "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/matches/11",
            "division": {
                "id": 3,
                "name": "Platinum",
                "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3"
            },
            "player1": {
                "id": 1,
                "name": "HurtnTime",
                "href": "http://localhost/sc2_season_mgr/players/1"
            },
            "player2": {
                "id": 4,
                "name": "Zelevin",
                "href": "http://localhost/sc2_season_mgr/players/4"
            },
            "winner": {
                "id": null,
                "name": null,
                "href": null
            },
            "map": {
                "id": 5,
                "name": "King Sejong",
                "href": "http://localhost/sc2_season_mgr/maps/5"
            }
        },
        {
            "id": 16,
            "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/matches/16",
            "division": {
                "id": 3,
                "name": "Platinum",
                "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3"
            },
            "player1": {
                "id": 5,
                "name": "Sheikh",
                "href": "http://localhost/sc2_season_mgr/players/5"
            },
            "player2": {
                "id": 9,
                "name": "SEF",
                "href": "http://localhost/sc2_season_mgr/players/9"
            },
            "winner": {
                "id": null,
                "name": null,
                "href": null
            },
            "map": {
                "id": 5,
                "name": "King Sejong",
                "href": "http://localhost/sc2_season_mgr/maps/5"
            }
        }
    ]
}
</code></pre>

### Standings API
The standings collection returns a list of players in order of wins and losses for
the division.

#### Getting stangings
URI: ``GET http://[base_uri]/seasons/[season_id]/divisions/[division_id]/standings``

Sample data returned:

<pre><code>[
    {
        "player": {
            "id": 1,
            "name": "HurtnTime",
            "href": "http://localhost/sc2_season_mgr/players/1"
        },
        "wins": 3,
        "losses": 0
    },
    {
        "player": {
            "id": 4,
            "name": "Zelevin",
            "href": "http://localhost/sc2_season_mgr/players/4"
        },
        "wins": 2,
        "losses": 1
    },
    {
        "player": {
            "id": 9,
            "name": "SEF",
            "href": "http://localhost/sc2_season_mgr/players/9"
        },
        "wins": 1,
        "losses": 2
    },
    {
        "player": {
            "id": 5,
            "name": "Sheikh",
            "href": "http://localhost/sc2_season_mgr/players/5"
        },
        "wins": 0,
        "losses": 3
    }
]
</code></pre>
