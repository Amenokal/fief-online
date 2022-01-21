# HOME
- Login rework -> register error messages
- Log events rework

# LOBBY
- Event rework
- Lobby to game redirect broken

# CARDS
- Set up ingame card draw (back ok)
- Set up reshuffle when deck is empty (back almost done)
> Discard piles
> Disaster cards

# ARMIES
> Move: let one
> Move: inspect
> Army manager modal

# TODO: TITLES

# TODO: DIPLOMACY

# TODO: record all events in db table to play asynch

# TODO: ingame chat

# TODO: discord server

# TODO: FullScreen / adapt to screen resolution

# TODO: ANIMATIONS
> moving armies
> loading screen

# ----
# BEFORE RELEASE: create .htaccess file in root directory to remove /public/ from url
> change all paths for ingame background-img & redirects

### .htaccess file content  ###
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

# ---