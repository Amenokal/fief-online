# KNOWN BUGS

When moveoption letOne with lone lord : lord disappearing
- if lord alone > moveAll()
- disable letOne when lord is alone in JS ?

When 3 disasters on board already : no discard pile animation + draw immediatly

# TASKS

## BACK-END

### HOME
- Login rework -> register error messages
- Log events rework

### LOBBY
- Event rework
- Lobby to game redirect broken

## FRONT-END

### SASS
- file: background-image for each lords

### ANIMATIONS
- discard animation in discard piles
- loading screen
- moving armies (maybe)

### RESPONSIVE
- FullScreen
- Media Queries

# TODO

### ARMIES
- JS class : ArmyManager for front-end army move & merges
- Restric inspect move = need a lord to move
- listeners cleaner

### CARDS
- disaster phase
- pose phase (need titles)

### GOLD

### BUILDINGS

### BATTLES

### SIEGE & PILLAGE

### ELECTIONS

### DIPLOMACY

### record all events in db table to play asynch

### ingame chat/discord server

# NOTES

### Before release

create .htaccess file in root directory to remove /public/ from url
- change all paths for ingame background-img & redirects

.htaccess file content:

<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    RewriteCond %{REQUEST_FILENAME} -d [OR]
    RewriteCond %{REQUEST_FILENAME} -f
    RewriteRule ^ ^$1 [N]

    RewriteCond %{REQUEST_URI} (\.\w+$) [NC]
    RewriteRule ^(.*)$ public/$1 

    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ server.php
</IfModule>
