<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Project Members

![Anurag's GitHub stats](https://github-readme-stats.vercel.app/api?username=Gabriel-31415&show_icons=true&theme=dark)
![Anurag's GitHub stats](https://github-readme-stats.vercel.app/api?username=carlos1270&show_icons=true&theme=gruvbox)
![Anurag's GitHub stats](https://github-readme-stats.vercel.app/api?username=Sekva&show_icons=true&theme=gruvbox)
![Anurag's GitHub stats](https://github-readme-stats.vercel.app/api?username=danillobion&show_icons=true&theme=gruvbox)
![Anurag's GitHub stats](https://github-readme-stats.vercel.app/api?username=Edgarvital&show_icons=true&theme=gruvbox)
## How to use

- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database credentials there
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)
- Run __npm install__ 
- Run __npm run dev__ 
- Run php artisan queue:work or use supervisor (https://laravel.com/docs/8.x/queues#supervisor-configuration)
- Run php artisan schedule:run on cron (generate schedules for vaccination points) 
    - ex.: 0 4 * * * php artisan schedule:run >> path/storage/logs/schedule.log

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
