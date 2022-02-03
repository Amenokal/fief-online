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
- Media Queries

# TODO

### ARMIES
- Restric inspect move = need a lord to move
- restrict move to 2
- clean "just_arrived" and "move" on soldiers and lords after move phase finishes

### CARDS
- tax
- instant cards

### GOLD
- buy titles
- buy cardinal

### BUILDINGS
- cities when a title is buyed

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
