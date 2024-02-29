<!-- ABOUT THE PROJECT -->
## About The Project

Project uses the Star Wars API(https://swapi.dev/) to find spaceships whose hyperdrive is at least 2.0

### Built With

* PHP 8.3
* Symfony 7

<!-- GETTING STARTED -->
## Getting Started
### Prerequisites
To run this project you need environment that is capable of running Docker and Docker Compose commands.
### Installation
1. Clone the repo
   ```sh
   https://github.com/Szewo/swapi-starships.git
   ```
2. Build project
   ```sh
   make build
   ```
3. Run project
   ```sh
   make up
   ```
4. Run web container
   ```sh
   make run-web-container
   ```
5. Install dependencies
   ```sh
   composer install
   ```
6. Install all assets
   ```sh
   php bin/console importmap:install
   ```
## Usage
After installation step site should be available under (http://localhost:80)

