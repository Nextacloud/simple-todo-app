# Simple To Do App - Laravel, Next JS, Tailwind

A simple to-do app written using Laravel as the backend and Next JS as the frontend.

## Backend

### Requirements
1. Docker
2. PHP 8.0 (optional)
3. Composer

### Installation Steps
1. Clone this repo
2. `cd backend`
3. If you have php 8.0 and composer installed, run `composer install`, take note if you use this approach, subtitute `./vendor/bin/sail` to the appropriate `php` command. 
4. Otherwise, run the following to spin up a light docker container to install the dependencies (recommended). 
```bash
   docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
5. Copy paste `.env.example` to `.env`
6. Spin up the docker containers, `./vendor/bin/sail up -d`. This will spin up MySQL, Laravel, Adminer, Redis, & Mailhog Containers
7. Set up the `APP_KEY` by running `./vendor/bin/sail artisan key:generate`
8. By default, the DB Credential defined in `.env` and the DB in MySQL Container should be matching. Otherwise, edit the DB Configuration in .env
9. Migrate and seed the database by running `./vendor/bin/sail artisan migrate:fresh --seed`
10. Application can be accessed in `http://127.0.0.1:80`, assuming you don't change the app port in `docker-compose.yml`

### API Availables

1. `Get /api/tasks` - returns list of tasks
2. `GET /api/tasks/:task_id` - return task detail
3. `POST /api/tasks/` - create new task
4. `PATCH /api/tasks/:task_id` - update a task
5. `DELETE /api/tasks/:task_id` - delete a task
6. `POST /api/tasks/:task_id/complete` - mark a task as complete
7. `POST /api/tasks/:task_id/incomplete` - mark a task as incomplete

### Notes
1. You might notice that I didn't use Laravel's model route binding in `TaskController`, this is intentional as I want to demostrate the Dependency Inversion Principle to bind the `TaskServiceInterface` to `TaskService`. 
2. `JsonResponseMiddleware` was added so I can just force the response to be returned in JSON format as I don't want to deal with Content Negotation for this project at the moment.

### Test

Run `./vendor/bin/sail artisan test` to run the test

---

## Frontend

### Requirements
1. NPM version 7+
2. Node version 16+
3. Yarn

### Technologies Used
1. Next JS
2. Tailwind
3. Use SWR
4. Axios
5. Formik
6. Headless UI
7. Hero Icons

### Installation Steps
1. Clone this repository if you haven't
2. `cd frontend`
3. Run `yarn` to instal the dependencies
4. Copy paste `.env.example` to `.env.local`
5. By default, `NEXT_PUBLIC_BACKEND_API_URL` should be pointing to the backend URL. otherwise, change it to match your backend URL.
6. Run `yarn dev` to spin up the development server, the app should be running at `http://127.0.0.1:3000`