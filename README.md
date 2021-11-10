<p align="center"><img src="https://vemvacinagaranhuns.site/img/logo_vem_vacina.png" width="400"></p>

# Project Members

![Anurag's GitHub stats](https://github-readme-stats.vercel.app/api?username=Gabriel-31415&show_icons=true&theme=dark&include_all_commits=false&count_private=true)
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

The VemVacina is open-sourced software.
