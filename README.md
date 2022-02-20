Hello Here are the steps to perform to run the code

1. Clone the repo using: git clone https://github.com/parthgajjar34/aspire-api.git
2. switch to master branch: git checkout master
3. rename .env.example to .env and do the according db changes
4. Run comoposer install command inside project folder
5. After coposer install run this command to geneate a project key in .env file: 
    php artisan key:generate
    php artisan jwt:secret
    php artisan migrate
    php -S localhost:8000 -t public
6. now your application is in running stat. to check your application you need Postman. I have attached postman collection in mail. Please download and run the API.