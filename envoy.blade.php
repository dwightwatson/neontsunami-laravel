@servers(['web' => 'forge@192.241.221.56'])

@task('deploy')
  cd /home/forge/default
  php artisan down
  git pull origin {{ $branch or 'master' }} --force
  composer install --no-dev --prefer-dist
  gulp
  php artisan config:cache
  php artisan route:cache
  php artisan up
@endtask

@task('stage')
  cd /home/forge/default
  git pull origin {{ $branch or 'develop' }}
  composer install --no-dev --prefer-dist
  php artisan up
@endtask

@task('up')
  cd /home/forge/default
  php artisan up
@endtask

@task('down')
  cd /home/forge/default
  php artisan down
@endtask

@task('migrate')
  cd /home/forge/default
  php artisan down
  php artisan migrate
  php artisan up
@endtask

@task('migrate:rollback')
  cd /home/forge/default
  php artisan down
  php artisan migrate:rollback
  php artisan up
@endtask
