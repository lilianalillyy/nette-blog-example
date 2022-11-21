# Nubium Trial

## Installation

### Requirements

- Docker
- Docker Compose

### Start the container

In the root directory, run:

```shell
docker-compose up
`````

### Update database

The current database schema is in `sql/db.sql`. Additionally, Adminer is provided at `localhost:8080`
to easily manage to database. You can either attach the database container and import the SQL file, or use the Adminer
interface.

### Optional: Seed database

You may use the php container and run the create-* scripts inside the `bin` folder to seed the database with test data.

### Run

The application should be available at `http://nubium-sandbox.test`

## Testing

### Static analysis

This project uses PHPStan for static analysis, run it using:

```shell
./vendor/bin/phpstan analyze .
`````
