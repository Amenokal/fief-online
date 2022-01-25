### <BUG> ###

- lord disappears when moveoption : letOne and lord is alone;
> if lord alone > moveAll()
> disable letOne when lord is alone in JS ?

- bug when 3 disasters on board already : to discard pile animation to make / bug: draw immediatly ?



### <BACK> ###

# HOME
- Login rework -> register error messages
- Log events rework

# LOBBY
- Event rework
- Lobby to game redirect broken

# TODO: TITLES

# ARMIES
> JS class : ArmyManager for front-end army move & merges
> Restric inspect move = need a lord to move
> listeners cleaner

# CARDS
> disaster phase
> pose phase (need titles)

# TODO: GOLD

# TODO BUILDINGS

# TODO: BATTLES

# TODO: SIEGE & PILLAGE

# TODO: ELECTIONS

# TODO: DIPLOMACY

# TODO: record all events in db table to play asynch

# TODO: ingame chat/discord server



### <FRONT> ###

# SASS
> file: background-image for each lords

# TODO: ANIMATIONS
> discard animation in discard piles
> loading screen
> moving armies (maybe)

# TODO: FullScreen / adapt to screen resolution


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
