# Import More than One Million Rows to Database Efficiently (Laravel/PHP)

This project demonstrates efficient CSV file import using Laravel's LazyCollection to import millions of customer records to a database without running out of memory. The project was inspired by Christoph Rumpel's video where he explored different approaches to import CSV files.

## Features

- **LazyCollection Implementation**: Leverages PHP generators to avoid storing all data in memory at once
- **Batch Processing**: Processes data in chunks of 1,000 rows for optimal performance
- **Data Validation**: Validates customer data including ID, name, email, company, city, country, and birthday
- **Prepared Statements**: Uses PDO prepared statements for secure and efficient batch inserts
- **Benchmarking**: Automatic benchmarking that shows execution time, memory usage, SQL queries count, and rows inserted
- **Docker Setup**: Complete Docker environment with PHP 8.2, MariaDB 10.6, and Nginx
- **Auto Migration**: Database migrations run automatically when containers start

## Tech Stack

- **Laravel 12**: PHP framework
- **PHP 8.2**: Programming language
- **MariaDB 10.6**: Database
- **Docker**: Containerization
- **Nginx**: Web server

## Project Structure

- `CustomersImportCommand`: Console command that handles the CSV import
- `ImportHelper` trait: Contains benchmarking logic and file selection
- CSV files: Sample data files (100, 1k, 10k, 100k, 1m, and 2m rows)
- Docker setup: Complete containerized environment

## Prerequisites

* Docker and Docker Compose

## Installation

1. Clone the repository
   ```sh
   git clone https://github.com/luizfelipelopes/import-million-rows-with-validations.git
   cd import-million-rows-with-validations
   ```

2. Build and start the project
   ```sh
   make build
   ```
   
   This command will:
   - Copy `.env.example` to `src/.env`
   - Stop and remove existing containers
   - Build and start the Docker containers
   - Automatically run database migrations

## Usage

### Running the Import Command

To run the customer import demonstration:

```sh
docker exec -it laravel_app php artisan import:customers
```

### CSV File Selection

The command will prompt you to select which CSV file to import:

- **CSV 100 Customers**: Small dataset for testing
- **CSV 1K Customers**: 1,000 rows
- **CSV 10K Customers**: 10,000 rows
- **CSV 100K Customers**: 100,000 rows
- **CSV 1M Customers**: 1,000,000 rows
- **CSV 2M Customers**: 2,000,000 rows

### Benchmark Results

After each execution, you'll see detailed statistics:

- **TIME**: Execution time (formatted as ms, seconds, or minutes:seconds)
- **MEM**: Memory usage in MB
- **SQL**: Number of SQL queries executed
- **ROWS**: Number of rows inserted into the database

## How It Works

1. **File Reading**: Uses PHP generators to read CSV files line by line without loading everything into memory
2. **Data Validation**: Validates each row's data (ID, name, email, company, city, country, birthday)
3. **Chunking**: Groups validated rows into batches of 1,000
4. **Batch Insert**: Uses prepared statements to insert chunks efficiently
5. **Benchmarking**: Tracks and displays performance metrics

## Docker Services

The project includes three Docker services:

- **laravel_app**: PHP 8.2-FPM application container
- **laravel_db**: MariaDB 10.6 database container
- **laravel_nginx**: Nginx web server container

## Database

- **Database**: `laravel_db`
- **User**: `laravel_user`
- **Password**: `secret`
- **Root Password**: `root_password`
- **Port**: `3306`

Migrations run automatically when the container starts via the entrypoint script.

## Notes

- The import command truncates the `customers` table before importing new data
- Invalid rows are filtered out during validation