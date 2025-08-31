<p align="center">
<img width="512" height="512" alt="DCS Statistics Dashboard Logo" src="https://github.com/user-attachments/assets/2a685a5c-9847-4b31-92aa-55d0f88d8209" />
</p>

![Filament 4.x Required](https://img.shields.io/badge/Filament-4.x-FF2D20?style=for-the-badge)
[![DCSServerBotAPI](https://img.shields.io/badge/DCS_Server_Bot_API-0.3-green?style=for-the-badge)](https://github.com/pschilly/dcs-server-bot-api)
[![DCSServerBot](https://img.shields.io/badge/🤖_Requires-DCS_Server_Bot-green?style=for-the-badge)](https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot)
![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/pschilly/filament-dcs-server-stats/fix-php-code-style-issues.yml?branch=main&style=for-the-badge)

## About DCS Statistics Dashboard

The DCS Statistics Dashboard is an opinionated approach to displaying the statistics gathered by the DCS Server Bot by Special-K in a web based analytics dashboard.

As of version 2.0 - the dashboard is utlizing [Laravel](https://laravel.com) for the backend and [Filament PHP](https://filamentphp.com) for the frontend. The responsive design is powered by [Tailwind CSS v4](https://tailwindcss.com)

Laravel is accessible, powerful, and provides tools required for large, robust applications.

# 🚀 Installation

> [!WARNING]
> These installation steps presume that you have already configured your DCS Server Bot RestAPI & Webservice. For more information on that please head on over to the relevent documentation:
>
> -   [RestAPI](https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot/blob/master/plugins/restapi/README.md)
> -   [WebService](https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot/blob/master/services/webservice/README.md)
>
> You will need both your RestAPI address / port & your API Key.
>
> Although the _API Key_ is not strictly required - it is **highly encouraged** for security.

## Standalone Web Server

To install on a pre-built webserver follow these steps:

### I - Confirm Server Requirements

Given that this project utlizes Laravel underneath, the following are minimum server requirements for the webserver:

-   PHP >= 8.2
-   Ctype PHP Extension
-   cURL PHP Extension
-   DOM PHP Extension
-   Fileinfo PHP Extension
-   Filter PHP Extension
-   Hash PHP Extension
-   Mbstring PHP Extension
-   OpenSSL PHP Extension
-   PCRE PHP Extension
-   PDO PHP Extension
-   Session PHP Extension
-   Tokenizer PHP Extension
-   XML PHP Extension
-   Redis PHP Extension

On top of this - you will also want to have a Redis Server setup for caching purposes. You can do without, but Redis is preferred and the most stable approach for caching.

Once you have your server(s) setup, continue to step II.

### II - Clone to the Repository

Using Git to clone the repo is the suggested method - this will make updates down the road significantly easier.

```bash
git clone https://github.com/Penfold-88/DCS-Statistics-Dashboard
```

### II - ENV File & App Key

Every Laravel project needs an .env file - this is where a lot of the base configuration is stored and so long as you have setup your webserver correctly, it is entirely inaccessable to the world which makes it the perfect place to store things like API keys.

```bash
cp .env.example .env
```

Generate an App Key with `artisan` - this is used as a salt for all encryption and is unique to each install.

Once you have copied the .env file - open it up and scroll to the bottom. Fill in the following:

```php
# DCS Server Bot Websockets API URL
DCS_BOT_API_URL=  // This is both the IP address (or fqdn) and port. EG: http://localhost:9876
# DCS Server Bot API Key
DCS_BOT_API_KEY=  // This is the key you set in your Rest API configuration files on the DCS Server Bot.
```

```bash
php artisan key:generate
```

### III - Database

This project ships with a default database setup. Let's copy it to the right spot:

```bash
cp database.sqlite.default database/database.sqlite
```

Once you have copied it over - continue on.

### IV - Composer Install, NPM Build

Install the composer assets & generate the CSS & JS build files.

```bash
composer install
npm run build
```

### V - DB Seed

The small SQLite database has been resetup with most of the application defaults you need. The part that still remains is getting the default admin user created. Do so with the db seeder:

```bash
php artisan db:seed --force
```

Once that is complete - you are good to go! I highly suggest you change the default admin credentials:

```bash
Username: admin@changeme.com
Password: password
```

You can do so by logging into the stats-config panel and going to the profile:
`https://your-project.domain/stats-config/profile`

## 🎯 Brand Configuration

This project comes with a configuration panel where you can adjust different options pertaining to the branding of the website. Including:

-   Brand Name
-   Brand Logo \*\* _If a logo is set, the Brand Name no longer shows on the top bar_
-   Header Image
-   Color Schemes [primary, success, info, warning, danger, gray] based on [Tailwind CSS color pallets](https://tailscan.com/colors).

The package comes included with some default settings for these - but if you wish to adjust them you can do so by signing into the stats-config panel using the username & password you made in the last step of the setup. `https://your-project.domain/stats-config/brand-settings`

## 🎯 Feature Management

Many of the features within this project can be turned off with ease. Within the `stats-config` panel located at `https://your-project.domain/stats-config/feature-settings`, you can enable / disable the following:

-   Pages
    -   Leaderboard
    -   Player Stats
    -   Squadrons \*\* Requires that you have the Squadrons feature enabled in the DCS Server Bot
    -   Servers
-   Leaderboard Columns
    -   Deaths
    -   KDR
    -   Credits \*\* Requires that you have the Credits feature enabled in the DCS Server Bot
    -   Playtime
-   Player Stats Widgets
    -   All
-   Dashboard Widgets
    -   All
-   Server Selector

## 🤝 Contributing

We welcome contributions from the DCS community! Anyone with a knowledge of Laravel and Filament PHP is welcome to submit a PR to help contribute to this project. Given the codebase - if you wish to contribute to the overall project - please submit a PR to this repo.

If you are looking to create a new widget or feature for the statistics, please head over to the [Filament PHP DCS Server Stats Plugin](https://github.com/pschilly/filament-dcs-server-stats) repo to submit a PR.

#### Contribution Guidelines

-   ✅ Follow existing code patterns
-   ✅ Test responsive design
-   ✅ Ensure security best practices
-   ✅ Update documentation
-   ✅ Include screenshots for UI changes

## License

This project is licensed under the **MIT License** - see [LICENSE](LICENSE.md) file.

## 🙏 Acknowledgments

-   **DCSServerBot** by [Special K](https://github.com/Special-K-s-Flightsim-Bots/DCSServerBot) - The foundation of this system
-   **Global Task Force Overlord** - Version 2.0 codebase upgrades
-   **Sky Pirates Squadron** - Original development and testing
-   **DCS Community** - Continuous feedback and improvements
-   **Eagle Dynamics** - For creating DCS World

---

---

**⭐ Star this repository** if it helps your community!  
**🐛 Report issues** to help improve the platform  
**💬 Share with other** DCS server administrators  
**🎮 Join the community** and showcase your dashboard

### Support Links

-   💬 [**Discord Support**](https://discord.gg/uTk8uQ2hxC) - Get help and chat with the community
-   📖 [**Documentation**](https://github.com/Penfold-88/DCS-Statistics-Website-Uploader/wiki)
-   🐛 [**Issue Tracker**](https://github.com/Penfold-88/DCS-Statistics-Website-Uploader/issues)
-   🌐 [**Live Demo**](https://gtfo-dcs.org)

**Transform your DCS server into a professional gaming platform today!** 🎖️
