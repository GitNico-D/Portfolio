# P05 - PORTFOLIO
"Création d’un portfolio personnel"

[![Maintainability](https://api.codeclimate.com/v1/badges/399cbf225695affb71bb/maintainability)](https://codeclimate.com/github/GitNico-D/Portfolio/maintainability) 
[![Quality gate](https://sonarcloud.io/api/project_badges/quality_gate?project=GitNico-D_Portfolio)](https://sonarcloud.io/dashboard?id=GitNico-D_Portfolio)
[![DeepScan grade](https://deepscan.io/api/teams/13170/projects/16178/branches/341869/badge/grade.svg)](https://deepscan.io/dashboard#view=project&tid=13170&pid=16178&bid=341869)

## Prerequisites ##
You will need to have npm and composer installed on your machine

## Environment ##
This project has been made with the following dependencies. 
For more please look through each package.json

### Backend ###
* [composer](https://getcomposer.org/) 
* [Symfony](https://symfony.com/) v5.1

### Frontend ###
* [VueJS](https://vuejs.org/) v2.6.11
* [VueX](https://vuex.vuejs.org/) v3.6.2
* [VeeValidate](https://vee-validate.logaretm.com/v3) v3.4.5
* [Vue-router](https://router.vuejs.org/) v3.5.1
* [vue-axios](https://github.com/axios/axios) v3.2.4
* [bootstrap-vue](https://bootstrap-vue.org/) v2.21.2
* [fontawesome/vue-fontawesome](https://github.com/FortAwesome/vue-fontawesome)
v2.0.2
* [fontawesome/free-solid-svg-icons](https://github.com/FortAwesome/vue-fontawesome)  v5.15.2
* [fontawesome/fontawesome-svg-core](https://github.com/FortAwesome/vue-fontawesome) v1.2.34


## Installation ##
Clone this repository. Then run through the following explanations.
### Backend ###
1. Run the following command in your terminal

    `cd backend/`
    
    `composer install`

2. Copy .env to .env.local and set DATABASE_URL informations and JWT_PASSPHRASE
    
### Frontend ###
1. Run the following command in your terminal

    `cd front_end`
    
    `npm install`

2. The server should run on localhost with port 8080

    `npm run serve`

If there is any error with the serve command, please try the following line:

    `npm run lint`
    
3. In .env change VUE_APP_API_URL with your virtual host adress api

## DEMONSTRATION ##
You can connect account with the following : 
    
    `email: admin@admin.com || password: password` 



