# Image Supervisor

## About
Project for moderate pictures.

## Install
```
git clone git clone  git@github.com:peektoseen/image-supervisor.git 
cd image-supervisor
./deploy.sh
```

If you need add new sources types - you can create new component in `/components` directory. As example and for skeleton component - you can use `/components/picsum` .

<b>WARNING</b> 80 port must be available on host machine. In other cases you need do manual configuration. 
And GitHub issues always welcome.

<b>WARNING</b> In production you must specify postgres password. For easy development - postgresql from docker-compose.yml allow no-password connection by default, but anyway - postgresql port doesn't opened outside of docker.

## Admin access
Available on `/admin` page. 
For access to admin part of service - you need past get parameter `token` , by default `token` set to **xyz123** .
You can override it in **ADMIN_TOKEN** environment variable.

## Realisation peculiarities
* For parameters in moderation request to api used two parameters: url and id. Theoretically - we can use url for extract id, but not always url may contain plain id, and for some sources may be need transformation from url to integer id. 
* You can easily add new sources type, for it, you need add two new classes in `./components` directory.

## Backlog for next versions
* Image preload. Preload images before click on button
* Remove bootstrap dependency.