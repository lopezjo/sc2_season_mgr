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
        "id": 1,
        "href": "http://localhost/sc2_season_mgr/players/1",
        "name": "HurtnTime",
        "links_href": "http://localhost/sc2_season_mgr/players/1/links"
    },
    {
        "id": 10,
        "href": "http://localhost/sc2_season_mgr/players/10",
        "name": "Boxer",
        "links_href": "http://localhost/sc2_season_mgr/players/10/links"
    }
]
</code></pre>

#### Getting a player
URI: ``GET http://[base_uri]/players/[player_id]``

Sample data returned:

<pre><code>{
    "id": 5,
    "href": "http://localhost/sc2_season_mgr/players/5",
    "name": "Sheikh",
    "links_href": "http://localhost/sc2_season_mgr/players/5/links"
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
        "id": 1,
        "href": "http://localhost/sc2_season_mgr/maps/1",
        "name": "Overgrowth",
        "links_href": "http://localhost/sc2_season_mgr/maps/1/links"
    },
    {
        "id": 6,
        "href": "http://localhost/sc2_season_mgr/maps/6",
        "name": "Dead Wing",
        "links_href": "http://localhost/sc2_season_mgr/maps/6/links"
    }
]
</code></pre>

#### Getting a map
URI: ``GET http://[base_uri]/maps/[map_id]``

Sample data returned:

<pre><code>{
    "id": 6,
    "href": "http://localhost/sc2_season_mgr/maps/6",
    "name": "Dead Wing",
    "links_href": "http://localhost/sc2_season_mgr/maps/6/links"
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
{"date": "2015-04-13 00:00:00", "winner": {"id": null}, "maps": [{"id": 7}, {"id": 8}], "name": "Test Season 1"}
</code></pre>

#### Getting seasons
URI: ``GET http://[base_uri]/seasons``

Sample data returned:

<pre><code>[
    {
        "id": 3,
        "href": "http://localhost/sc2_season_mgr/seasons/3",
        "name": "Test Season 1",
        "date": "2015-04-13 00:00:00",
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
        "date": "2015-04-13 00:00:00",
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
        "date": "2015-04-13 00:00:00",
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
{"date":"2015-04-13 00:00:00", "winner": {"id": null}, "maps": [{"id": 7}, {"id": 8}], "name": "Test Season 1"}
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
        "id": 1,
        "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1",
        "name": "Diamond",
        "season": {
            "id": 2,
            "name": "Test Season 1",
            "href": "http://localhost/sc2_season_mgr/seasons/2"
        },
        "players": [
            {
                "id": 2,
                "name": "Freeedom",
                "href": "http://localhost/sc2_season_mgr/players/2"
            },
            {
                "id": 3,
                "name": "Lamp",
                "href": "http://localhost/sc2_season_mgr/players/3"
            },
            {
                "id": 6,
                "name": "KriMiNaL",
                "href": "http://localhost/sc2_season_mgr/players/6"
            },
            {
                "id": 7,
                "name": "samuraipanda",
                "href": "http://localhost/sc2_season_mgr/players/7"
            },
            {
                "id": 8,
                "name": "MygraiN.277",
                "href": "http://localhost/sc2_season_mgr/players/8"
            },
            {
                "id": 10,
                "name": "Boxer",
                "href": "http://localhost/sc2_season_mgr/players/10"
            }
        ],
        "matches_href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1/matches",
        "rounds_href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1/rounds",
        "standings_href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1/standings"
    },
    {
        "id": 3,
        "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3",
        "name": "Platinum",
        "season": {
            "id": 2,
            "name": "Test Season 1",
            "href": "http://localhost/sc2_season_mgr/seasons/2"
        },
        "players": [
            {
                "id": 1,
                "name": "HurtnTime",
                "href": "http://localhost/sc2_season_mgr/players/1"
            },
            {
                "id": 4,
                "name": "Zelevin",
                "href": "http://localhost/sc2_season_mgr/players/4"
            },
            {
                "id": 5,
                "name": "Sheikh",
                "href": "http://localhost/sc2_season_mgr/players/5"
            },
            {
                "id": 9,
                "name": "SEF",
                "href": "http://localhost/sc2_season_mgr/players/9"
            }
        ],
        "matches_href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/matches",
        "rounds_href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/rounds",
        "standings_href": "http://localhost/sc2_season_mgr/seasons/2/divisions/3/standings"
    }
]
</code></pre>

#### Getting a division
URI: ``GET http://[base_uri]/seasons/[season_id]/divisions/[division_id]``

Sample data returned:

<pre><code>{
    "id": 1,
    "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1",
    "name": "Diamond",
    "season": {
        "id": 2,
        "name": "Test Season 1",
        "href": "http://localhost/sc2_season_mgr/seasons/2"
    },
    "players": [
        {
            "id": 2,
            "name": "Freeedom",
            "href": "http://localhost/sc2_season_mgr/players/2"
        },
        {
            "id": 3,
            "name": "Lamp",
            "href": "http://localhost/sc2_season_mgr/players/3"
        },
        {
            "id": 6,
            "name": "KriMiNaL",
            "href": "http://localhost/sc2_season_mgr/players/6"
        },
        {
            "id": 7,
            "name": "samuraipanda",
            "href": "http://localhost/sc2_season_mgr/players/7"
        },
        {
            "id": 8,
            "name": "MygraiN.277",
            "href": "http://localhost/sc2_season_mgr/players/8"
        },
        {
            "id": 10,
            "name": "Boxer",
            "href": "http://localhost/sc2_season_mgr/players/10"
        }
    ],
    "matches_href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1/matches",
    "rounds_href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1/rounds",
    "standings_href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1/standings"
}
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
        "id": 50,
        "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1/matches/50",
        "division": {
            "id": 1,
            "name": "Diamond",
            "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1"
        },
        "player1": {
            "id": 7,
            "name": "samuraipanda",
            "href": "http://localhost/sc2_season_mgr/players/7"
        },
        "player2": {
            "id": 10,
            "name": "Boxer",
            "href": "http://localhost/sc2_season_mgr/players/10"
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
        },
        "links": "http://localhost/sc2_season_mgr/seasons/2/divisions/1/matches/50/links"
    },
    {
        "id": 51,
        "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1/matches/51",
        "division": {
            "id": 1,
            "name": "Diamond",
            "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1"
        },
        "player1": {
            "id": 8,
            "name": "MygraiN.277",
            "href": "http://localhost/sc2_season_mgr/players/8"
        },
        "player2": {
            "id": 10,
            "name": "Boxer",
            "href": "http://localhost/sc2_season_mgr/players/10"
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
        },
        "links": "http://localhost/sc2_season_mgr/seasons/2/divisions/1/matches/51/links"
    }
]
</code></pre>

#### Getting a match
URI: ``GET http://[base_uri]/seasons/[season_id]/divisions/[division_id]/matches/[match_id]``

Sample data returned:

<pre><code>{
    "id": 50,
    "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1/matches/50",
    "division": {
        "id": 1,
        "name": "Diamond",
        "href": "http://localhost/sc2_season_mgr/seasons/2/divisions/1"
    },
    "player1": {
        "id": 7,
        "name": "samuraipanda",
        "href": "http://localhost/sc2_season_mgr/players/7"
    },
    "player2": {
        "id": 10,
        "name": "Boxer",
        "href": "http://localhost/sc2_season_mgr/players/10"
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
    },
    "links": "http://localhost/sc2_season_mgr/seasons/2/divisions/1/matches/50/links"
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

### Link APIs
#### Adding a link
URI: ``POST http://[base_uri]/players/[player_id]/links``<br />
URI: ``POST http://[base_uri]/maps/[map_id]/links``<br />
URI: ``POST http://[base_uri]/seasons/[season_id]/divisions[division_id]/matches/[match_id]/links``

Sample POST data:

<pre><code>
{ "url": "www.ggtracker.com", "desc": "replay" }
</code></pre>

#### Getting links
URI: ``GET http://[base_uri]/players/[player_id]/links``<br />
URI: ``GET http://[base_uri]/maps/[map_id]/links``<br />
URI: ``GET http://[base_uri]/seasons/[season_id]/divisions[division_id]/matches/[match_id]/links``

Sample data returned:

<pre><code>[
    {
        "id": 3,
        "href": "http://localhost/sc2_season_mgr/players/1/links/3",
        "url": "http://www.jrl-e.com",
        "desc": "my site"
    },
    {
        "id": 12,
        "href": "http://localhost/sc2_season_mgr/players/1/links/12",
        "url": "www.psistorm.com",
        "desc": "clan site"
    }
]
</code></pre>

#### Getting a link
URI: ``GET http://[base_uri]/players/[player_id]/links/[link_id]``<br />
URI: ``GET http://[base_uri]/maps/[map_id]/links/[link_id]``<br />
URI: ``GET http://[base_uri]/seasons/[season_id]/divisions[division_id]/matches/[match_id]/links/[link_id]``

Sample data returned:

<pre><code>{
    "id": 3,
    "href": "http://localhost/sc2_season_mgr/players/1/links/3",
    "url": "http://www.jrl-e.com",
    "desc": "my site"
}
</code></pre>

#### Editing a link
URI: ``PUT http://[base_uri]/players/[player_id]/links/[link_id]``<br />
URI: ``PUT http://[base_uri]/maps/[map_id]/links/[link_id]``<br />
URI: ``PUT http://[base_uri]/seasons/[season_id]/divisions[division_id]/matches/[match_id]/links/[link_id]``

Sample PUT data:

<pre><code>
{ "url": "www.ggtracker.com", "desc": "replay" }
</code></pre>

#### Deleting a player
URI: ``DELETE http://[base_uri]/players/[player_id]/links/[link_id]``<br />
URI: ``DELETE http://[base_uri]/maps/[map_id]/links/[link_id]``<br />
URI: ``DELETE http://[base_uri]/seasons/[season_id]/divisions[division_id]/matches/[match_id]/links/[link_id]``

