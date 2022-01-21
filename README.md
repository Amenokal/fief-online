
# TODO: ORGANIZING && MOVING ARMIES ???? •w•

- ArmyServices ?
- Marechal::march() /!\
> how will be displayed on client side ?
> how move soldiers between armies ?
> wich data will be sent with axios request ?
> banners !?

- possible solutions
I) different options onclick on lord in game view while move phase :
> move all || put 1 sergeant in village || inspect & manage manually
>>> all other phases = inspect army = show nb of soldiers/lords

II) new db table "armies"? id | power | lord_id
III) foreign id -> bind soldiers to lord 

# TODO: CARDS

# TODO: DIPLOMACY




# ----
# TODO: create .htaccess file in root directory to remove /public/ from url
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