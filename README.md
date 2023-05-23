# Cursotopia

Cursotopia is a web application for online courses

![](.screenshoots/hero_banner.png)

# Technologies:
## Frontend
<p align="left">
<img
    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg"
    width="64"
    alt="HTML5"
    style="margin-right: 4px"
/>
<img 
    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg"
    width="64"
    alt="CSS3"
    style="margin-right: 4px"
/>
<img
    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg"
    width="64"
    alt="JavaScript" 
    style="margin-right: 4px"
/>
<img
    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/jquery/jquery-original.svg"
    width="64"
    alt="jQuery"
    style="margin-right: 4px"
/>
<img
    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg"
    width="64"
    alt="Bootstrap"
    style="margin-right: 4px"
/>
</p>

## Backend
<p align="left">
<img
    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/apache/apache-original-wordmark.svg"
    width="64"
    alt="Apache"
    style="margin-right: 4px"
/>
<img
    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original-wordmark.svg"
    width="64"
    alt="MySQL"
    style="margin-right: 4px"
/>
<img
    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg"
    width="64"
    alt="PHP"
    style="margin-right: 4px"
/>
<img 
    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/composer/composer-original.svg"
    width="64"
    alt="Composer"
    style="margin-right: 4px" 
/>
</p>

## Others
<p align="left">
<img
    src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vscode/vscode-original.svg"
    width="64"
    alt="Visual Studio Code"
    style="margin-right: 4px"
/>
</p>

#
![](.screenshoots/course_details.png)

# Setup

Clone the repository
```
git clone https://github.com/Prz-Ellam/Cursotopia
cd Cursotopia
```

Initialize the dependencies for frontend and backend
```
npm install
```

```
composer update --no-dev
```

Transpile the frontend code into a dist for the web
```
npm run build
```

This will generate a `dist` folder in `public`

If you use Apache, set the public folder of the project in the `httpd.conf`
```
DocumentRoot <This is where your public folder path goes>

<Directory "<This is where your public folder path>">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
    Allow from all
</Directory>
```

Change configuration in the php.ini to support video upload
```
php_value upload_max_filesize 500M
php_value post_max_size 500M
php_value max.execution_time 300
```

Enable Intl module in php.ini
```
extension=intl
```

Go to the folder `/database` and execute php script
```
php build.php
```

This is gonna create a `cursotopia.sql`, in your RDBMS execute the script and this will create the entire cursotopia.sql (tables, stored procedures, triggers, views, functions and initial data)

Create a `.env` file in the root folder (you can duplicate the `.env.example` and rename it)
Fill it with your database

Recomended values:
```
APP_NAME=Cursotopia
APP_DEBUG=false
APP_TIMEZONE=Etc/GMT-6
APP_LANG=es-MX
APP_LOCALE=es_MX.UTF-8
APP_CHARSET=UTF-8
```

# Features
- [x] Auth
- [x] Users and roles
- [x] Courses
- [x] Levels (Sections)
- [x] Categories
- [x] Messages
- [x] Comments and reviews
- [x] Homepage
- [x] Certificates and progress
- [x] Sales reports
- [x] Browser
