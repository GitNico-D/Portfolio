<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/categories' => [
            [['_route' => 'get_category_list', '_controller' => 'App\\Controller\\CategoryController::readCategoryList'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'create_category', '_controller' => 'App\\Controller\\CategoryController::createCategory'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/educations' => [
            [['_route' => 'get_education_list', '_controller' => 'App\\Controller\\EducationController::readEducationList'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'create_education', '_controller' => 'App\\Controller\\EducationController::createEducation'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/experiences' => [
            [['_route' => 'get_experience_list', '_controller' => 'App\\Controller\\ExperienceController::readExperienceList'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'create_experiences', '_controller' => 'App\\Controller\\ExperienceController::createExperience'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/projects' => [
            [['_route' => 'get_project_list', '_controller' => 'App\\Controller\\ProjectController::readProjectList'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'create_project', '_controller' => 'App\\Controller\\ProjectController::createProject'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/register' => [[['_route' => 'register', '_controller' => 'App\\Controller\\SecurityController::register'], null, ['POST' => 0], null, false, false, null]],
        '/api/login' => [[['_route' => 'login', '_controller' => 'App\\Controller\\SecurityController::login'], null, ['POST' => 0], null, false, false, null]],
        '/api/skills' => [
            [['_route' => 'get_skill_list', '_controller' => 'App\\Controller\\SkillController::readSkillList'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'create_skill', '_controller' => 'App\\Controller\\SkillController::createSkill'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/softwares' => [
            [['_route' => 'get_software_list', '_controller' => 'App\\Controller\\SoftwareController::readSoftwareList'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'create_software', '_controller' => 'App\\Controller\\SoftwareController::createSoftware'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/login_check' => [[['_route' => 'api_login_check'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/api/(?'
                    .'|categories/([^/]++)(?'
                        .'|(*:37)'
                    .')'
                    .'|e(?'
                        .'|ducations/([^/]++)(?'
                            .'|(*:70)'
                        .')'
                        .'|xperiences/([^/]++)(?'
                            .'|(*:100)'
                        .')'
                    .')'
                    .'|projects/([^/]++)(?'
                        .'|(*:130)'
                    .')'
                    .'|s(?'
                        .'|kills/([^/]++)(?'
                            .'|(*:160)'
                        .')'
                        .'|oftwares/([^/]++)(?'
                            .'|(*:189)'
                        .')'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        37 => [
            [['_route' => 'get_category', '_controller' => 'App\\Controller\\CategoryController::readCategory'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'update_category', '_controller' => 'App\\Controller\\CategoryController::updateCategory'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'delete_category', '_controller' => 'App\\Controller\\CategoryController::deleteCategory'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        70 => [
            [['_route' => 'get_education', '_controller' => 'App\\Controller\\EducationController::readEducation'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'update_education', '_controller' => 'App\\Controller\\EducationController::updateEducation'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'delete_education', '_controller' => 'App\\Controller\\EducationController::deleteEducation'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        100 => [
            [['_route' => 'get_experience', '_controller' => 'App\\Controller\\ExperienceController::readExperience'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'update_experience', '_controller' => 'App\\Controller\\ExperienceController::updateExperience'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'delete_experience', '_controller' => 'App\\Controller\\ExperienceController::deleteExperience'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        130 => [
            [['_route' => 'get_project', '_controller' => 'App\\Controller\\ProjectController::readProject'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'update_project', '_controller' => 'App\\Controller\\ProjectController::updateProject'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'delete_project', '_controller' => 'App\\Controller\\ProjectController::deleteProject'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        160 => [
            [['_route' => 'get_skill', '_controller' => 'App\\Controller\\SkillController::readSkill'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'update_skill', '_controller' => 'App\\Controller\\SkillController::updateSkill'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'delete_skills', '_controller' => 'App\\Controller\\SkillController::deleteSkill'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        189 => [
            [['_route' => 'get_software', '_controller' => 'App\\Controller\\SoftwareController::readSoftware'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'update_software', '_controller' => 'App\\Controller\\SoftwareController::updateSoftware'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'delete_software', '_controller' => 'App\\Controller\\SoftwareController::deleteSoftware'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
