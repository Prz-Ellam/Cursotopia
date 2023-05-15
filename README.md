# Cursotopia

Cursotopia is a web application for online courses

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
composer install
```

Transpile the frontend code into a dist for the web
```
npm run build
```

If you use Apache, set the root of the project in the `httpd.conf`
```
DocumentRoot <This is where you root goes>

<Directory "<This is where you root goes>">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
    Allow from all
</Directory>
```

Change configuration in the php.ini
```
php_value upload_max_filesize 500M
php_value post_max_size 500M
php_value max.execution_time 300
```

Enable Intl module in php.ini
```
extension=intl
```

# Features
- [x] Auth
- [x] Users and roles
- [ ] Courses
- [ ] Levels (Sections)
- [x] Categories
- [x] Messages
- [x] Comments and reviews
- [x] Homepage
- [x] Certificates and progress
- [ ] Sales reports
- [x] Browser
